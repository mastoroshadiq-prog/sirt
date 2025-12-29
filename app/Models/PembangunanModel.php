<?php

namespace App\Models;

use CodeIgniter\Model;

class PembangunanModel extends Model
{
    protected $table = 'pembangunan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'rkt_id',
        'nama_proyek',
        'lokasi',
        'deskripsi',
        'manfaat',
        'estimasi_biaya',
        'sumber_dana',
        'timeline_mulai',
        'timeline_selesai',
        'priority',
        'status',
        'progress_fisik',
        'realisasi_biaya',
        'pic_user_id',
        'kendala'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_proyek' => 'required|min_length[5]',
        'lokasi' => 'required',
        'estimasi_biaya' => 'required|decimal',
        'timeline_mulai' => 'required|valid_date',
        'timeline_selesai' => 'required|valid_date',
    ];

    /**
     * Get active projects
     */
    public function getActiveProjects()
    {
        return $this->whereIn('status', ['approved', 'survey', 'pelaksanaan'])
                    ->orderBy('priority', 'ASC')
                    ->orderBy('timeline_mulai', 'ASC')
                    ->findAll();
    }

    /**
     * Get projects by priority
     */
    public function getByPriority($priority)
    {
        return $this->where('priority', $priority)
                    ->orderBy('timeline_mulai', 'ASC')
                    ->findAll();
    }

    /**
     * Get project stats
     */
    public function getStats()
    {
        $db = \Config\Database::connect();
        $builder = $db->table($this->table);
        
        $stats = [
            'total' => $this->countAll(),
            'proposal' => $this->where('status', 'proposal')->countAllResults(false),
            'on_progress' => $this->whereIn('status', ['survey', 'pelaksanaan'])->countAllResults(false),
            'selesai' => $this->where('status', 'selesai')->countAllResults(false),
        ];
        
        $builder->selectSum('estimasi_biaya', 'total_budget');
        $budget = $builder->get()->getRowArray();
        $stats['total_budget'] = $budget['total_budget'] ?? 0;
        
        return $stats;
    }
}
