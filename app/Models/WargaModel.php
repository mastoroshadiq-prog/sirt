<?php

namespace App\Models;

use CodeIgniter\Model;

class WargaModel extends Model
{
    protected $table = 'warga';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'kk_id',
        'nik',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'pekerjaan',
        'status_perkawinan',
        'status_keluarga',
        'foto',
        'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'kk_id' => 'required|numeric',
        'nik' => 'required|exact_length[16]|numeric|is_unique[warga.nik,id,{id}]',
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
        'tempat_lahir' => 'required',
        'tanggal_lahir' => 'required|valid_date',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'agama' => 'required',
        'pekerjaan' => 'required',
        'status_perkawinan' => 'required',
        'status_keluarga' => 'required',
    ];

    protected $validationMessages = [
        'nik' => [
            'required' => 'NIK harus diisi',
            'exact_length' => 'NIK harus 16 digit',
            'is_unique' => 'NIK sudah terdaftar',
        ],
    ];

    /**
     * Get warga with KK info
     */
    public function getWargaWithKK(int $limit = null, int $offset = 0)
    {
        $builder = $this->select('warga.*, kartu_keluarga.no_kk, kartu_keluarga.kepala_keluarga, kartu_keluarga.alamat')
                        ->join('kartu_keluarga', 'kartu_keluarga.id = warga.kk_id')
                        ->where('warga.status', 'aktif')
                        ->orderBy('warga.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit, $offset);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get warga by KK ID
     */
    public function getWargaByKK(int $kkId)
    {
        return $this->where('kk_id', $kkId)
                    ->where('status', 'aktif')
                    ->orderBy('status_keluarga', 'ASC')
                    ->findAll();
    }

    /**
     * Get total warga aktif
     */
    public function getTotalWargaAktif(): int
    {
        return $this->where('status', 'aktif')->countAllResults();
    }

    /**
     * Get statistik by jenis kelamin
     */
    public function getStatsByGender(): array
    {
        return $this->select('jenis_kelamin, COUNT(*) as total')
                    ->where('status', 'aktif')
                    ->groupBy('jenis_kelamin')
                    ->findAll();
    }

    /**
     * Get statistik by agama
     */
    public function getStatsByAgama(): array
    {
        return $this->select('agama, COUNT(*) as total')
                    ->where('status', 'aktif')
                    ->groupBy('agama')
                    ->orderBy('total', 'DESC')
                    ->findAll();
    }

    /**
     * Get statistik by usia
     */
    public function getStatsByUsia(): array
    {
        $sql = "SELECT 
                    CASE 
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) < 5 THEN 'Balita (0-5)'
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 5 AND 12 THEN 'Anak (5-12)'
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 13 AND 17 THEN 'Remaja (13-17)'
                        WHEN TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 18 AND 60 THEN 'Dewasa (18-60)'
                        ELSE 'Lansia (>60)'
                    END as kategori_usia,
                    COUNT(*) as total
                FROM {$this->table}
                WHERE status = 'aktif'
                GROUP BY kategori_usia
                ORDER BY 
                    CASE kategori_usia
                        WHEN 'Balita (0-5)' THEN 1
                        WHEN 'Anak (5-12)' THEN 2
                        WHEN 'Remaja (13-17)' THEN 3
                        WHEN 'Dewasa (18-60)' THEN 4
                        ELSE 5
                    END";
        
        return $this->db->query($sql)->getResultArray();
    }

    /**
     * Search warga
     */
    public function searchWarga(string $keyword)
    {
        return $this->select('warga.*, kartu_keluarga.no_kk, kartu_keluarga.kepala_keluarga')
                    ->join('kartu_keluarga', 'kartu_keluarga.id = warga.kk_id')
                    ->groupStart()
                        ->like('warga.nama_lengkap', $keyword)
                        ->orLike('warga.nik', $keyword)
                        ->orLike('kartu_keluarga.no_kk', $keyword)
                    ->groupEnd()
                    ->where('warga.status', 'aktif')
                    ->findAll();
    }
}
