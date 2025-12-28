<?php

namespace App\Models;

use CodeIgniter\Model;

class KartuKeluargaModel extends Model
{
    protected $table = 'kartu_keluarga';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'no_kk',
        'kepala_keluarga',
        'alamat',
        'rt',
        'rw',
        'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'no_kk' => 'required|exact_length[16]|numeric|is_unique[kartu_keluarga.no_kk,id,{id}]',
        'kepala_keluarga' => 'required|min_length[3]|max_length[100]',
        'alamat' => 'required',
        'rt' => 'required',
    ];

    protected $validationMessages = [
        'no_kk' => [
            'required' => 'Nomor KK harus diisi',
            'exact_length' => 'Nomor KK harus 16 digit',
            'is_unique' => 'Nomor KK sudah terdaftar',
        ],
    ];

    /**
     * Get active KK with member count
     */
    public function getActiveKKWithCount()
    {
        return $this->select('kartu_keluarga.*, COUNT(warga.id) as jumlah_anggota')
                    ->join('warga', 'warga.kk_id = kartu_keluarga.id', 'left')
                    ->where('kartu_keluarga.status', 'aktif')
                    ->groupBy('kartu_keluarga.id')
                    ->findAll();
    }

    /**
     * Get total active KK
     */
    public function getTotalActiveKK(): int
    {
        return $this->where('status', 'aktif')->countAllResults();
    }
}
