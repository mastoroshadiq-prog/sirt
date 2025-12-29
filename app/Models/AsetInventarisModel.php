<?php

namespace App\Models;

use CodeIgniter\Model;

class AsetInventarisModel extends Model
{
    protected $table = 'aset_inventaris';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'kategori_aset_id',
        'kode_register',
        'nama_aset',
        'merek_tipe',
        'tahun_perolehan',
        'nilai_perolehan',
        'kondisi',
        'lokasi',
        'keterangan',
        'foto_utama'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'kategori_aset_id' => 'required|numeric',
        'nama_aset' => 'required|min_length[3]',
        'tahun_perolehan' => 'required|numeric|exact_length[4]',
    ];

    /**
     * Get aset with category info
     */
    public function getAsetWithCategory(int $limit = null)
    {
        $builder = $this->select('aset_inventaris.*, kategori_aset.nama_kategori, kategori_aset.prefix_kode')
                        ->join('kategori_aset', 'kategori_aset.id = aset_inventaris.kategori_aset_id')
                        ->orderBy('aset_inventaris.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }

    /**
     * Get aset by category
     */
    public function getAsetByCategory(int $kategoriId)
    {
        return $this->select('aset_inventaris.*, kategori_aset.nama_kategori')
                    ->join('kategori_aset', 'kategori_aset.id = aset_inventaris.kategori_aset_id')
                    ->where('aset_inventaris.kategori_aset_id', $kategoriId)
                    ->findAll();
    }

    /**
     * Get statistics by condition
     */
    public function getStatsByCondition(): array
    {
        return $this->select('kondisi, COUNT(*) as total')
                    ->groupBy('kondisi')
                    ->findAll();
    }

    /**
     * Get total asset value
     */
    public function getTotalValue(): int
    {
        $result = $this->selectSum('nilai_perolehan', 'total')->first();
        return $result['total'] ?? 0;
    }

    /**
     * Generate kode register
     */
    public function generateKodeRegister(string $kodePrefix): string
    {
        $year = date('Y');
        $lastAset = $this->like('kode_register', "$kodePrefix/$year", 'after')
                         ->orderBy('kode_register', 'DESC')
                         ->first();
        
        if ($lastAset) {
            $parts = explode('/', $lastAset['kode_register']);
            $lastNumber = (int)end($parts);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return sprintf("%s/%s/%04d", $kodePrefix, $year, $newNumber);
    }

    /**
     * Search aset
     */
    public function searchAset(string $keyword)
    {
        return $this->select('aset_inventaris.*, kategori_aset.nama_kategori')
                    ->join('kategori_aset', 'kategori_aset.id = aset_inventaris.kategori_aset_id')
                    ->groupStart()
                        ->like('aset_inventaris.nama_aset', $keyword)
                        ->orLike('aset_inventaris.kode_register', $keyword)
                        ->orLike('kategori_aset.nama_kategori', $keyword)
                    ->groupEnd()
                    ->findAll();
    }
}
