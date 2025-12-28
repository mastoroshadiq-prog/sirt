<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriIuranModel extends Model
{
    protected $table = 'kategori_iuran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_kategori',
        'nominal_default',
        'deskripsi',
        'is_active'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_kategori' => 'required|min_length[3]|max_length[100]',
        'nominal_default' => 'required|decimal',
    ];

    protected $validationMessages = [
        'nama_kategori' => [
            'required' => 'Nama kategori harus diisi',
        ],
        'nominal_default' => [
            'required' => 'Nominal default harus diisi',
        ],
    ];

    /**
     * Get active categories
     */
    public function getActiveCategories(): array
    {
        return $this->where('is_active', 1)->findAll();
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(int $id): bool
    {
        $category = $this->find($id);
        if ($category) {
            return $this->update($id, ['is_active' => !$category['is_active']]);
        }
        return false;
    }
}
