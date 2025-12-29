<?php

namespace App\Controllers;

use App\Models\KartuKeluargaModel;
use App\Models\WargaModel;
use App\Models\MutasiWargaModel;

class Warga extends BaseController
{
    protected $kkModel;
    protected $wargaModel;
    protected $mutasiModel;

    public function __construct()
    {
        $this->kkModel = new KartuKeluargaModel();
        $this->wargaModel = new WargaModel();
        $this->mutasiModel = new MutasiWargaModel();
        helper(['form', 'url']);
    }

    /**
     * Dashboard Administrasi Warga
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Get statistics
        $totalKK = $this->kkModel->getTotalActiveKK();
        $totalWarga = $this->wargaModel->getTotalWargaAktif();
        $statsByGender = $this->wargaModel->getStatsByGender();
        $statsByAgama = $this->wargaModel->getStatsByAgama();
        $statsByUsia = $this->wargaModel->getStatsByUsia();
        
        // Get recent mutasi
        $recentMutasi = $this->mutasiModel->getMutasiWithWarga(5);
        
        // Get monthly mutasi stats
        $mutasiStats = $this->mutasiModel->getMonthlyStats(date('n'), date('Y'));

        $data = [
            'title' => 'Administrasi Warga',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'total_kk' => $totalKK,
            'total_warga' => $totalWarga,
            'stats_gender' => $statsByGender,
            'stats_agama' => $statsByAgama,
            'stats_usia' => $statsByUsia,
            'recent_mutasi' => $recentMutasi,
            'mutasi_stats' => $mutasiStats,
        ];

        return view('warga/dashboard', $data);
    }

    /**
     * List Kartu Keluarga
     */
    public function listKK()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $listKK = $this->kkModel->getActiveKKWithCount();

        $data = [
            'title' => 'Data Kartu Keluarga',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_kk' => $listKK,
        ];

        return view('warga/list_kk', $data);
    }

    /**
     * Form Add/Edit KK
     */
    public function formKK(int $id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $kk = $id ? $this->kkModel->find($id) : null;

        $data = [
            'title' => $id ? 'Edit Kartu Keluarga' : 'Tambah Kartu Keluarga',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'kk' => $kk,
        ];

        return view('warga/form_kk', $data);
    }

    /**
     * Save KK
     */
    public function saveKK()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'no_kk' => $this->request->getPost('no_kk'),
            'kepala_keluarga' => $this->request->getPost('kepala_keluarga'),
            'alamat' => $this->request->getPost('alamat'),
            'rt' => $this->request->getPost('rt'),
            'rw' => $this->request->getPost('rw'),
            'status' => $this->request->getPost('status') ?? 'aktif',
        ];

        if ($id) {
            // Update
            if ($this->kkModel->update($id, $data)) {
                return redirect()->to('/warga/kk')->with('success', 'Data KK berhasil diupdate');
            }
        } else {
            // Insert
            if ($this->kkModel->insert($data)) {
                return redirect()->to('/warga/kk')->with('success', 'Data KK berhasil ditambahkan');
            }
        }

        return redirect()->back()->withInput()->with('errors', $this->kkModel->errors());
    }

    /**
     * List Warga
     */
    public function listWarga()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $keyword = $this->request->getGet('search');
        $kkId = $this->request->getGet('kk_id');
        
        if ($kkId) {
            // Filter by KK
            $listWarga = $this->wargaModel->getWargaByKK($kkId);
            // Get KK info for title
            $kkInfo = $this->kkModel->find($kkId);
        } elseif ($keyword) {
            $listWarga = $this->wargaModel->searchWarga($keyword);
            $kkInfo = null;
        } else {
            $listWarga = $this->wargaModel->getWargaWithKK();
            $kkInfo = null;
        }

        $data = [
            'title' => $kkInfo ? 'Anggota KK: ' . $kkInfo['no_kk'] : 'Data Warga',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_warga' => $listWarga,
            'keyword' => $keyword,
            'kk_info' => $kkInfo,
        ];

        return view('warga/list_warga', $data);
    }

    /**
     * Form Add/Edit Warga
     */
    public function formWarga(int $id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $warga = $id ? $this->wargaModel->find($id) : null;
        $listKK = $this->kkModel->where('status', 'aktif')->findAll();

        $data = [
            'title' => $id ? 'Edit Data Warga' : 'Tambah Data Warga',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'warga' => $warga,
            'list_kk' => $listKK,
        ];

        return view('warga/form_warga', $data);
    }

    /**
     * Save Warga
     */
    public function saveWarga()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'kk_id' => $this->request->getPost('kk_id'),
            'nik' => $this->request->getPost('nik'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'tempat_lahir' => $this->request->getPost('tempat_lahir'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'agama' => $this->request->getPost('agama'),
            'pekerjaan' => $this->request->getPost('pekerjaan'),
            'status_perkawinan' => $this->request->getPost('status_perkawinan'),
            'status_keluarga' => $this->request->getPost('status_keluarga'),
            'status' => $this->request->getPost('status') ?? 'aktif',
        ];

        if ($id) {
            // Update
            if ($this->wargaModel->update($id, $data)) {
                return redirect()->to('/warga/list')->with('success', 'Data warga berhasil diupdate');
            }
        } else {
            // Insert & record mutasi
            if ($this->wargaModel->insert($data)) {
                $wargaId = $this->wargaModel->insertID();
                
                // Record as new resident
                $this->mutasiModel->insert([
                    'warga_id' => $wargaId,
                    'jenis_mutasi' => 'baru',
                    'tanggal_mutasi' => date('Y-m-d'),
                    'keterangan' => 'Pendaftaran warga baru',
                    'user_id' => session()->get('user_id'),
                ]);
                
                return redirect()->to('/warga/list')->with('success', 'Data warga berhasil ditambahkan');
            }
        }

        return redirect()->back()->withInput()->with('errors', $this->wargaModel->errors());
    }

    /**
     * Mutasi Warga
     */
    public function mutasi()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $mutasiList = $this->mutasiModel->getMutasiWithWarga(50);

        $data = [
            'title' => 'Mutasi Warga',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'mutasi_list' => $mutasiList,
        ];

        return view('warga/mutasi', $data);
    }
}
