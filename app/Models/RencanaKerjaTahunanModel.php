<?php

namespace App\Models;

use CodeIgniter\Model;

class RencanaKerjaTahunanModel extends Model
{
    protected $table = 'rencana_kerja_tahunan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'tahun',
        'visi',
        'misi',
        'periode_mulai',
        'periode_selesai',
        'status',
        'user_id',
        'approved_by',
        'approved_at'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'tahun' => 'required|integer',
        'visi' => 'required',
        'periode_mulai' => 'required|valid_date',
        'periode_selesai' => 'required|valid_date',
    ];

    /**
     * Get active RKT
     */
    public function getActiveRKT()
    {
        return $this->where('status', 'active')->first();
    }

    /**
     * Get RKT with programs
     */
    public function getRKTWithPrograms($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('rencana_kerja_tahunan rkt');
        $builder->select('rkt.*, COUNT(DISTINCT pk.id) as jumlah_program, COUNT(DISTINCT rk.id) as jumlah_kegiatan');
        $builder->join('program_kerja pk', 'pk.rkt_id = rkt.id', 'left');
        $builder->join('rencana_kegiatan rk', 'rk.program_kerja_id = pk.id', 'left');
        $builder->where('rkt.id', $id);
        $builder->groupBy('rkt.id');
        
        return $builder->get()->getRowArray();
    }
}
