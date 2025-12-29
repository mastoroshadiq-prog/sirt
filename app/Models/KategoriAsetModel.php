<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriAsetModel extends Model
{
    protected $table = 'kategori_aset';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_kategori',
        'prefix_kode',
        'deskripsi'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_kategori' => 'required|min_length[3]|max_length[100]',
        'prefix_kode' => 'required|max_length[10]',
    ];

    /**
     * Get all categories (no is_active filter since column doesn't exist)
     */
    public function getActiveCategories()
    {
        return $this->orderBy('nama_kategori', 'ASC')
                    ->findAll();
    }

    /**
     * Get category with asset count
     */
    public function getCategoriesWithCount()
    {
        return $this->select('kategori_aset.*, COUNT(aset_inventaris.id) as jumlah_aset')
                    ->join('aset_inventaris', 'aset_inventaris.kategori_aset_id = kategori_aset.id', 'left')
                    ->groupBy('kategori_aset.id')
                    ->findAll();
    }
}
