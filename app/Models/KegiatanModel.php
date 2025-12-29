<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_kegiatan',
        'tanggal',
        'lokasi',
        'deskripsi',
        'kategori',
        'anggaran',
        'realisasi',
        'status',
        'pic_user_id',
        'jumlah_peserta',
        'hasil_kegiatan',
        'kendala'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_kegiatan' => 'required|min_length[5]',
        'kategori' => 'required',
        'tanggal' => 'required|valid_date',
    ];

    /**
     * Get upcoming kegiatan
     */
    public function getUpcomingKegiatan(int $limit = 5)
    {
        return $this->where('tanggal >=', date('Y-m-d'))
                    ->whereIn('status', ['direncanakan', 'sedang_berjalan'])
                    ->orderBy('tanggal', 'ASC')
                    ->limit($limit)
                    ->findAll();
    }

    /**
     * Get kegiatan by status
     */
    public function getByStatus(string $status)
    {
        return $this->where('status', $status)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }

    /**
     * Get statistics by kategori
     */
    public function getStatsByKategori(): array
    {
        return $this->select('kategori, COUNT(*) as total')
                    ->groupBy('kategori')
                    ->findAll();
    }

    /**
     * Get monthly kegiatan
     */
    public function getMonthlyKegiatan(int $bulan, int $tahun)
    {
        return $this->where('MONTH(tanggal)', $bulan)
                    ->where('YEAR(tanggal)', $tahun)
                    ->orderBy('tanggal', 'ASC')
                    ->findAll();
    }

    /**
     * Get total anggaran
     */
    public function getTotalAnggaran(string $status = null): int
    {
        $builder = $this->selectSum('anggaran', 'total');
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        $result = $builder->first();
        return $result['total'] ?? 0;
    }

    /**
     * Search kegiatan
     */
    public function searchKegiatan(string $keyword)
    {
        return $this->groupStart()
                        ->like('nama_kegiatan', $keyword)
                        ->orLike('lokasi', $keyword)
                        ->orLike('kategori', $keyword)
                    ->groupEnd()
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }
}
