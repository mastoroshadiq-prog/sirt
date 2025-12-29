<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalRondaModel extends Model
{
    protected $table = 'jadwal_ronda';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'tanggal',
        'shift',
        'shift_custom',
        'lokasi_pos',
        'catatan',
        'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'tanggal' => 'required|valid_date',
        'shift' => 'required',
        'lokasi_pos' => 'required',
    ];

    /**
     * Get jadwal minggu ini
     */
    public function getJadwalMingguIni()
    {
        $startOfWeek = date('Y-m-d', strtotime('monday this week'));
        $endOfWeek = date('Y-m-d', strtotime('sunday this week'));
        
        return $this->where('tanggal >=', $startOfWeek)
                    ->where('tanggal <=', $endOfWeek)
                    ->orderBy('tanggal', 'ASC')
                    ->findAll();
    }

    /**
     * Get jadwal by month
     */
    public function getJadwalByMonth(int $bulan, int $tahun)
    {
        return $this->where('MONTH(tanggal)', $bulan)
                    ->where('YEAR(tanggal)', $tahun)
                    ->orderBy('tanggal', 'ASC')
                    ->findAll();
    }
}
