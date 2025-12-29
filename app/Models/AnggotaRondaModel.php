<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaRondaModel extends Model
{
    protected $table = 'anggota_ronda';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'warga_id',
        'nama',
        'no_hp',
        'alamat',
        'is_koordinator',
        'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama' => 'required|min_length[3]',
        'no_hp' => 'required',
        'alamat' => 'required',
    ];
}
