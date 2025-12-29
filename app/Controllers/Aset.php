<?php

namespace App\Controllers;

use App\Models\KategoriAsetModel;
use App\Models\AsetInventarisModel;

class Aset extends BaseController
{
    protected $kategoriModel;
    protected $asetModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriAsetModel();
        $this->asetModel = new AsetInventarisModel();
        helper(['form', 'url']);
    }

    /**
     * Dashboard Aset
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Get statistics
        $totalAset = $this->asetModel->countAll();
        $totalKategori = $this->kategoriModel->countAll();
        $totalNilai = $this->asetModel->getTotalValue();
        $statsByCondition = $this->asetModel->getStatsByCondition();
        
        // Get recent aset
        $recentAset = $this->asetModel->getAsetWithCategory(5);
        
        // Get categories with count
        $categoriesWithCount = $this->kategoriModel->getCategoriesWithCount();

        $data = [
            'title' => 'Manajemen Aset',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'total_aset' => $totalAset,
            'total_kategori' => $totalKategori,
            'total_nilai' => $totalNilai,
            'stats_condition' => $statsByCondition,
            'recent_aset' => $recentAset,
            'categories_count' => $categoriesWithCount,
        ];

        return view('aset/dashboard', $data);
    }

    /**
     * List Kategori
     */
    public function kategori()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $listKategori = $this->kategoriModel->getCategoriesWithCount();

        $data = [
            'title' => 'Kategori Aset',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_kategori' => $listKategori,
        ];

        return view('aset/kategori', $data);
    }

    /**
     * List Inventaris
     */
    public function inventaris()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $keyword = $this->request->getGet('search');
        $kategoriId = $this->request->getGet('kategori_id');
        
        if ($kategoriId) {
            $listAset = $this->asetModel->getAsetByCategory($kategoriId);
            $kategoriInfo = $this->kategoriModel->find($kategoriId);
        } elseif ($keyword) {
            $listAset = $this->asetModel->searchAset($keyword);
            $kategoriInfo = null;
        } else {
            $listAset = $this->asetModel->getAsetWithCategory();
            $kategoriInfo = null;
        }

        $data = [
            'title' => $kategoriInfo ? 'Inventaris: ' . $kategoriInfo['nama_kategori'] : 'Inventaris Aset',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_aset' => $listAset,
            'kategori_info' => $kategoriInfo,
        ];

        return view('aset/inventaris', $data);
    }

    /**
     * Form Add/Edit Aset
     */
    public function form(int $id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $aset = $id ? $this->asetModel->find($id) : null;
        $listKategori = $this->kategoriModel->getActiveCategories();

        $data = [
            'title' => $id ? 'Edit Aset' : 'Tambah Aset',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'aset' => $aset,
            'list_kategori' => $listKategori,
        ];

        return view('aset/form', $data);
    }

    /**
     * Save Aset
     */
    public function save()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        $kategoriId = $this->request->getPost('kategori_aset_id');
        
        // Generate kode register if new
        if (!$id) {
            $kategori = $this->kategoriModel->find($kategoriId);
            $kodeRegister = $this->asetModel->generateKodeRegister($kategori['prefix_kode']);
        } else {
            $kodeRegister = $this->request->getPost('kode_register');
        }
        
        $data = [
            'kategori_aset_id' => $kategoriId,
            'kode_register' => $kodeRegister,
            'nama_aset' => $this->request->getPost('nama_aset'),
            'merek_tipe' => $this->request->getPost('merek_tipe'),
            'tahun_perolehan' => $this->request->getPost('tahun_perolehan'),
            'nilai_perolehan' => $this->request->getPost('nilai_perolehan'),
            'kondisi' => $this->request->getPost('kondisi'),
            'lokasi' => $this->request->getPost('lokasi'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];

        if ($id) {
            // Update
            if ($this->asetModel->update($id, $data)) {
                return redirect()->to('/aset/inventaris')->with('success', 'Data aset berhasil diupdate');
            }
        } else {
            // Insert
            if ($this->asetModel->insert($data)) {
                return redirect()->to('/aset/inventaris')->with('success', 'Data aset berhasil ditambahkan');
            }
        }

        return redirect()->back()->withInput()->with('errors', $this->asetModel->errors());
    }
}
