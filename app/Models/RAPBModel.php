<?php

namespace App\Models;

use CodeIgniter\Model;

class RAPBModel extends Model
{
    protected $table = 'rapb';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'rkt_id',
        'tahun',
        'total_target_pendapatan',
        'total_rencana_belanja',
        'buffer_persen',
        'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get RAPB with realisasi
     */
    public function getRAPBWithRealisasi($id)
    {
        $db = \Config\Database::connect();
        
        // Get RAPB data
        $rapb = $this->find($id);
        
        if (!$rapb) {
            return null;
        }
        
        // Get realisasi pendapatan (from transaksi_keuangan)
        $builder = $db->table('transaksi_keuangan');
        $builder->selectSum('masuk', 'total_masuk');
        $builder->where('YEAR(tanggal)', $rapb['tahun']);
        $realisasiPendapatan = $builder->get()->getRowArray();
        
        // Get realisasi belanja
        $builder = $db->table('transaksi_keuangan');
        $builder->selectSum('keluar', 'total_keluar');
        $builder->where('YEAR(tanggal)', $rapb['tahun']);
        $realisasiBelanja = $builder->get()->getRowArray();
        
        $rapb['realisasi_pendapatan'] = $realisasiPendapatan['total_masuk'] ?? 0;
        $rapb['realisasi_belanja'] = $realisasiBelanja['total_keluar'] ?? 0;
        $rapb['persen_pendapatan'] = $rapb['total_target_pendapatan'] > 0 
            ? ($rapb['realisasi_pendapatan'] / $rapb['total_target_pendapatan']) * 100 
            : 0;
        $rapb['persen_belanja'] = $rapb['total_rencana_belanja'] > 0 
            ? ($rapb['realisasi_belanja'] / $rapb['total_rencana_belanja']) * 100 
            : 0;
        
        return $rapb;
    }

    /**
     * Get active RAPB
     */
    public function getActiveRAPB()
    {
        return $this->where('status', 'active')->first();
    }
}
