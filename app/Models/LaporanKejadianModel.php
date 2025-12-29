<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanKejadianModel extends Model
{
    protected $table = 'laporan_kejadian';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'jadwal_ronda_id',
        'tanggal_waktu',
        'jenis_kejadian',
        'deskripsi',
        'lokasi',
        'latitude',
        'longitude',
        'tindakan',
        'status',
        'pelapor_id'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'tanggal_waktu' => 'required',
        'jenis_kejadian' => 'required',
        'deskripsi' => 'required',
        'lokasi' => 'required',
    ];
}
