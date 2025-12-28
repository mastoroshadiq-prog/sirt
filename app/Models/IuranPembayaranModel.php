<?php

namespace App\Models;

use CodeIgniter\Model;

class IuranPembayaranModel extends Model
{
    protected $table = 'iuran_pembayaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'kk_id',
        'kategori_iuran_id',
        'bulan',
        'tahun',
        'jumlah',
        'tanggal_bayar',
        'bukti_file',
        'keterangan',
        'user_id'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Check if KK already paid for specific category in a month
     */
    public function isAlreadyPaid(int $kkId, int $kategoriId, int $bulan, int $tahun): bool
    {
        return $this->where([
            'kk_id' => $kkId,
            'kategori_iuran_id' => $kategoriId,
            'bulan' => $bulan,
            'tahun' => $tahun
        ])->countAllResults() > 0;
    }

    /**
     * Get payment status for all KK in a month
     */
    public function getMonthlyPaymentStatus(int $bulan, int $tahun)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('kartu_keluarga kk');
        
        $builder->select('kk.id, kk.no_kk, kk.kepala_keluarga, kk.alamat,
                         ki.id as kategori_id, ki.nama_kategori,
                         IFNULL(ip.id, 0) as sudah_bayar,
                         ip.tanggal_bayar, ip.jumlah')
                ->join('kk_iuran_setup kis', 'kis.kk_id = kk.id', 'left')
                ->join('kategori_iuran ki', 'ki.id = kis.kategori_iuran_id AND ki.is_active = 1', 'left')
                ->join('iuran_pembayaran ip', "ip.kk_id = kk.id AND ip.kategori_iuran_id = ki.id 
                        AND ip.bulan = $bulan AND ip.tahun = $tahun", 'left')
                ->where('kk.status', 'aktif')
                ->where('kis.is_active', 1);
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get total iuran collected for a month
     */
    public function getTotalIuranBulan(int $bulan, int $tahun): float
    {
        $result = $this->selectSum('jumlah')
                       ->where(['bulan' => $bulan, 'tahun' => $tahun])
                       ->first();
        
        return $result ? (float)$result['jumlah'] : 0;
    }

    /**
     * Get iuran breakdown by category
     */
    public function getIuranByCategory(int $bulan, int $tahun): array
    {
        return $this->select('kategori_iuran.nama_kategori, 
                             SUM(iuran_pembayaran.jumlah) as total')
                    ->join('kategori_iuran', 'kategori_iuran.id = iuran_pembayaran.kategori_iuran_id')
                    ->where(['bulan' => $bulan, 'tahun' => $tahun])
                    ->groupBy('kategori_iuran_id')
                    ->findAll();
    }

    /**
     * Record payment and create kas transaction
     */
    public function recordPayment(array $paymentData): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        // Insert payment
        $this->insert($paymentData);
        $paymentId = $this->insertID();
        
        // Create kas transaction
        $kasModel = new KasTransaksiModel();
        $kategori = (new KategoriIuranModel())->find($paymentData['kategori_iuran_id']);
        $kk = (new KartuKeluargaModel())->find($paymentData['kk_id']);
        
        $kasData = [
            'tanggal' => $paymentData['tanggal_bayar'],
            'jenis' => 'masuk',
            'kategori' => $kategori['nama_kategori'],
            'uraian' => "Iuran {$kategori['nama_kategori']} - {$kk['kepala_keluarga']} (Bulan {$paymentData['bulan']}/{$paymentData['tahun']})",
            'masuk' => $paymentData['jumlah'],
            'keluar' => 0,
            'ref_type' => 'iuran',
            'ref_id' => $paymentId
        ];
        
        $kasModel->addTransaction($kasData);
        
        $db->transComplete();
        
        return $db->transStatus();
    }
}
