<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramKerjaModel extends Model
{
    protected $table = 'program_kerja';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'rkt_id',
        'bidang',
        'nama_program',
        'deskripsi',
        'target_output',
        'pj_program'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'rkt_id' => 'required|integer',
        'bidang' => 'required',
        'nama_program' => 'required|min_length[5]',
    ];

    public function getProgramWithKegiatan($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('program_kerja pk');
        $builder->select('pk.*, COUNT(rk.id) as jumlah_kegiatan, AVG(rk.progress_persen) as avg_progress');
        $builder->join('rencana_kegiatan rk', 'rk.program_kerja_id = pk.id', 'left');
        $builder->where('pk.id', $id);
        $builder->groupBy('pk.id');
        
        return $builder->get()->getRowArray();
    }

    public function getByRKT($rkt_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('program_kerja pk');
        $builder->select('pk.*, COUNT(rk.id) as jumlah_kegiatan, AVG(rk.progress_persen) as avg_progress');
        $builder->join('rencana_kegiatan rk', 'rk.program_kerja_id = pk.id', 'left');
        $builder->where('pk.rkt_id', $rkt_id);
        $builder->groupBy('pk.id');
        $builder->orderBy('pk.bidang', 'ASC');
        
        return $builder->get()->getResultArray();
    }
}
