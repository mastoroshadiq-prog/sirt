<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaKegiatanModel extends Model
{
    protected $table = 'rencana_kegiatan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'program_kerja_id',
        'nama_kegiatan',
        'deskripsi',
        'timeline',
        'bulan_target',
        'target_peserta',
        'expected_outcome',
        'pic_user_id',
        'status',
        'progress_persen',
        'kegiatan_id'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'program_kerja_id' => 'required|integer',
        'nama_kegiatan' => 'required|min_length[5]',
        'timeline' => 'required',
    ];

    public function getByProgram($program_id)
    {
        return $this->where('program_kerja_id', $program_id)
                    ->orderBy('timeline', 'ASC')
                    ->orderBy('bulan_target', 'ASC')
                    ->findAll();
    }

    public function getWithKegiatan($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('rencana_kegiatan rk');
        $builder->select('rk.*, k.nama_kegiatan as kegiatan_nama, k.status as kegiatan_status, k.tanggal as kegiatan_tanggal');
        $builder->join('kegiatan k', 'k.id = rk.kegiatan_id', 'left');
        $builder->where('rk.id', $id);
        
        return $builder->get()->getRowArray();
    }
}
