<?php

namespace App\Models;

use CodeIgniter\Model;

class StrukturOrganisasiModel extends Model
{
    protected $table = 'struktur_organisasi';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama',
        'jabatan',
        'periode_mulai',
        'periode_selesai',
        'no_hp',
        'alamat',
        'foto',
        'is_active',
        'urutan'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama' => 'required|min_length[3]',
        'jabatan' => 'required',
        'periode_mulai' => 'required',
        'periode_selesai' => 'required',
    ];

    public function getActivePengurus()
    {
        return $this->where('is_active', 1)
                    ->orderBy('urutan', 'ASC')
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    public function getPengurusForDropdown()
    {
        $pengurus = $this->getActivePengurus();
        $result = [];
        foreach ($pengurus as $p) {
            $result[$p['id']] = $p['nama'] . ' (' . $p['jabatan'] . ')';
        }
        return $result;
    }
}
