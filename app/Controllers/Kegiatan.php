<?php

namespace App\Controllers;

use App\Models\KegiatanModel;

class Kegiatan extends BaseController
{
    protected $kegiatanModel;

    public function __construct()
    {
        $this->kegiatanModel = new KegiatanModel();
        helper(['form', 'url']);
    }

    /**
     * Dashboard Kegiatan
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Get statistics
        $totalKegiatan = $this->kegiatanModel->countAll();
        $upcomingKegiatan = $this->kegiatanModel->getUpcomingKegiatan(5);
        $statsByKategori = $this->kegiatanModel->getStatsByKategori();
        $totalAnggaran = $this->kegiatanModel->getTotalAnggaran();
        
        // Count by status
        $kegiatanModel2 = new KegiatanModel();
        $totalDirencanakan = $kegiatanModel2->where('status', 'direncanakan')->countAllResults();
        $totalSelesai = $this->kegiatanModel->where('status', 'selesai')->countAllResults();

        $data = [
            'title' => 'Kegiatan RT',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'total_kegiatan' => $totalKegiatan,
            'total_direncanakan' => $totalDirencanakan,
            'total_selesai' => $totalSelesai,
            'upcoming_kegiatan' => $upcomingKegiatan,
            'stats_kategori' => $statsByKategori,
            'total_anggaran' => $totalAnggaran,
        ];

        return view('kegiatan/dashboard', $data);
    }

    /**
     * List Kegiatan
     */
    public function list()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $keyword = $this->request->getGet('search');
        $statusFilter = $this->request->getGet('status');
        
        if ($keyword) {
            $listKegiatan = $this->kegiatanModel->searchKegiatan($keyword);
        } elseif ($statusFilter) {
            $listKegiatan = $this->kegiatanModel->getByStatus($statusFilter);
        } else {
            $listKegiatan = $this->kegiatanModel->orderBy('tanggal', 'DESC')->findAll();
        }

        $data = [
            'title' => 'Daftar Kegiatan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_kegiatan' => $listKegiatan,
            'status_filter' => $statusFilter,
        ];

        return view('kegiatan/list', $data);
    }

    /**
     * Form Kegiatan
     */
    public function form($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $kegiatan = null;
        if ($id) {
            $kegiatan = $this->kegiatanModel->find($id);
            if (!$kegiatan) {
                return redirect()->to('/kegiatan')->with('error', 'Kegiatan tidak ditemukan');
            }
        }

        // Load rencana kegiatan yang belum terhubung (atau yang sudah terhubung dengan kegiatan ini)
        $rencanaModel = new \App\Models\RencanaKegiatanModel();
        $db = \Config\Database::connect();
        $builder = $db->table('rencana_kegiatan rk');
        $builder->select('rk.*, pk.nama_program, rkt.tahun');
        $builder->join('program_kerja pk', 'pk.id = rk.program_kerja_id', 'left');
        $builder->join('rencana_kerja_tahunan rkt', 'rkt.id = pk.rkt_id', 'left');
        $builder->where('(rk.kegiatan_id IS NULL OR rk.kegiatan_id = ' . ($id ?? 0) . ')');
        $builder->where('rk.status !=', 'dibatalkan');
        $builder->orderBy('rkt.tahun', 'DESC');
        $builder->orderBy('rk.bulan_target', 'ASC');
        $rencanaKegiatan = $builder->get()->getResultArray();

        $data = [
            'title' => $id ? 'Edit Kegiatan' : 'Tambah Kegiatan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'kegiatan' => $kegiatan,
            'rencana_kegiatan' => $rencanaKegiatan,
        ];

        return view('kegiatan/form', $data);
    }

    /**
     * Save Kegiatan
     */
    public function save()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'kategori' => $this->request->getPost('kategori'),
            'tanggal' => $this->request->getPost('tanggal'),
            'lokasi' => $this->request->getPost('lokasi'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'anggaran' => $this->request->getPost('anggaran') ?? 0,
            'realisasi' => $this->request->getPost('realisasi') ?? 0,
            'status' => $this->request->getPost('status') ?? 'direncanakan',
            'user_id' => session()->get('user_id'),
        ];

        if ($id) {
            $this->kegiatanModel->update($id, $data);
            $savedId = $id;
        } else {
            $savedId = $this->kegiatanModel->insert($data);
        }

        // Update link ke rencana_kegiatan
        $rencana_id = $this->request->getPost('rencana_kegiatan_id');
        if ($rencana_id) {
            $rencanaModel = new \App\Models\RencanaKegiatanModel();
            
            // Update rencana_kegiatan dengan kegiatan_id
            $rencanaModel->update($rencana_id, [
                'kegiatan_id' => $savedId
            ]);

            // Auto-update status & progress based on kegiatan status
            $status = $data['status'];
            $updateRencana = [];
            
            if ($status == 'selesai') {
                $updateRencana['status'] = 'selesai';
                $updateRencana['progress_persen'] = 100;
            } elseif ($status == 'sedang_berjalan') {
                $updateRencana['status'] = 'berjalan';
                if (!$this->request->getPost('id')) { // New kegiatan
                    $updateRencana['progress_persen'] = 50; // Set to 50% when started
                }
            } elseif ($status == 'dibatalkan') {
                $updateRencana['status'] = 'dibatalkan';
            } else {
                $updateRencana['status'] = 'persiapan';
            }
            
            if (!empty($updateRencana)) {
                $rencanaModel->update($rencana_id, $updateRencana);
            }
        }
        
        return redirect()->to('/kegiatan')->with('success', 'Kegiatan berhasil disimpan dan terhubung dengan rencana');
    }

    /**
     * Detail Kegiatan
     */
    public function detail($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $kegiatan = $this->kegiatanModel->find($id);
        
        if (!$kegiatan) {
            return redirect()->to('/kegiatan')->with('error', 'Kegiatan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Kegiatan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'kegiatan' => $kegiatan,
        ];

        return view('kegiatan/detail', $data);
    }
}
