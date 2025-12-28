<?php

namespace App\Models;

use CodeIgniter\Model;

class MutasiWargaModel extends Model
{
    protected $table = 'mutasi_warga';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'warga_id',
        'jenis_mutasi',
        'tanggal_mutasi',
        'keterangan',
        'user_id'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';

    protected $validationRules = [
        'jenis_mutasi' => 'required|in_list[baru,pindah,meninggal,kelahiran]',
        'tanggal_mutasi' => 'required|valid_date',
    ];

    /**
     * Get mutasi with warga info
     */
    public function getMutasiWithWarga(int $limit = null)
    {
        $builder = $this->select('mutasi_warga.*, warga.nama_lengkap, warga.nik, kartu_keluarga.no_kk, kartu_keluarga.kepala_keluarga')
                        ->join('warga', 'warga.id = mutasi_warga.warga_id', 'left')
                        ->join('kartu_keluarga', 'kartu_keluarga.id = warga.kk_id', 'left')
                        ->orderBy('mutasi_warga.tanggal_mutasi', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get mutasi by type
     */
    public function getMutasiByType(string $type, int $month = null, int $year = null)
    {
        $builder = $this->where('jenis_mutasi', $type);
        
        if ($month && $year) {
            $builder->where('MONTH(tanggal_mutasi)', $month)
                   ->where('YEAR(tanggal_mutasi)', $year);
        }
        
        return $builder->countAllResults();
    }

    /**
     * Get monthly statistics
     */
    public function getMonthlyStats(int $month, int $year): array
    {
        return [
            'baru' => $this->getMutasiByType('baru', $month, $year),
            'pindah' => $this->getMutasiByType('pindah', $month, $year),
            'meninggal' => $this->getMutasiByType('meninggal', $month, $year),
            'kelahiran' => $this->getMutasiByType('kelahiran', $month, $year),
        ];
    }

    /**
     * Record mutasi and update warga status
     */
    public function recordMutasi(array $data): bool
    {
        $db = \Config\Database::connect();
        $db->transStart();

        // Insert mutasi
        $this->insert($data);

        // Update warga status if pindah or meninggal
        if (in_array($data['jenis_mutasi'], ['pindah', 'meninggal']) && isset($data['warga_id'])) {
            $wargaModel = new WargaModel();
            $wargaModel->update($data['warga_id'], [
                'status' => $data['jenis_mutasi']
            ]);
        }

        $db->transComplete();
        return $db->transStatus();
    }
}
