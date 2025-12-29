<?php

namespace App\Controllers;

use App\Models\RencanaKerjaTahunanModel;
use App\Models\RAPBModel;
use App\Models\PembangunanModel;
use App\Models\ProgramKerjaModel;
use App\Models\RencanaKegiatanModel;

class Perencanaan extends BaseController
{
    protected $rktModel;
    protected $rapbModel;
    protected $pembangunanModel;
    protected $programModel;
    protected $kegiatanModel;

    public function __construct()
    {
        $this->rktModel = new RencanaKerjaTahunanModel();
        $this->rapbModel = new RAPBModel();
        $this->pembangunanModel = new PembangunanModel();
        $this->programModel = new ProgramKerjaModel();
        $this->kegiatanModel = new RencanaKegiatanModel();
        helper(['form', 'url']);
    }

    /**
     * Dashboard Perencanaan
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $activeRKT = $this->rktModel->getActiveRKT();
        $activeRAPB = $this->rapbModel->getActiveRAPB();
        $projectStats = $this->pembangunanModel->getStats();
        
        // Get RKT summary if exists
        $rktSummary = null;
        if ($activeRKT) {
            $rktSummary = $this->rktModel->getRKTWithPrograms($activeRKT['id']);
        }

        // Get RAPB realisasi if exists  
        $rapbRealisasi = null;
        if ($activeRAPB) {
            $rapbRealisasi = $this->rapbModel->getRAPBWithRealisasi($activeRAPB['id']);
        }

        // Get active projects
        $activeProjects = $this->pembangunanModel->getActiveProjects();

        $data = [
            'title' => 'Perencanaan & Penganggaran',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'active_rkt' => $activeRKT,
            'rkt_summary' => $rktSummary,
            'active_rapb' => $activeRAPB,
            'rapb_realisasi' => $rapbRealisasi,
            'project_stats' => $projectStats,
            'active_projects' => $activeProjects,
        ];

        return view('perencanaan/dashboard', $data);
    }

    /**
     * RKT Management
     */
    public function rkt()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $listRKT = $this->rktModel->orderBy('tahun', 'DESC')->findAll();

        $data = [
            'title' => 'Rencana Kerja Tahunan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_rkt' => $listRKT,
        ];

        return view('perencanaan/rkt', $data);
    }

    /**
     * RAPB Management
     */
    public function rapb()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $listRAPB = $this->rapbModel->orderBy('tahun', 'DESC')->findAll();

        $data = [
            'title' => 'RAPB',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_rapb' => $listRAPB,
        ];

        return view('perencanaan/rapb', $data);
    }

    /**
     * Monitoring Dashboard
     */
    public function monitoring()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $activeRAPB = $this->rapbModel->getActiveRAPB();
        
        if (!$activeRAPB) {
            return redirect()->to('/perencanaan')->with('error', 'Belum ada RAPB aktif');
        }

        $rapbRealisasi = $this->rapbModel->getRAPBWithRealisasi($activeRAPB['id']);

        $data = [
            'title' => 'Monitoring Anggaran',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'rapb' => $rapbRealisasi,
        ];

        return view('perencanaan/monitoring', $data);
    }

    /**
     * RKT Form
     */
    public function formRkt($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $rkt = null;
        if ($id) {
            $rkt = $this->rktModel->find($id);
        }

        $data = [
            'title' => $id ? 'Edit RKT' : 'Tambah RKT',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'rkt' => $rkt,
        ];

        return view('perencanaan/form_rkt', $data);
    }

    /**
     * Save RKT
     */
    public function saveRkt()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'tahun' => $this->request->getPost('tahun'),
            'visi' => $this->request->getPost('visi'),
            'misi' => $this->request->getPost('misi'),
            'periode_mulai' => $this->request->getPost('periode_mulai'),
            'periode_selesai' => $this->request->getPost('periode_selesai'),
            'status' => $this->request->getPost('status') ?? 'draft',
            'user_id' => session()->get('user_id'),
        ];

        if ($id) {
            $this->rktModel->update($id, $data);
        } else {
            $this->rktModel->insert($data);
        }
        
        return redirect()->to('/perencanaan/rkt')->with('success', 'RKT berhasil disimpan');
    }

    /**
     * RAPB Form
     */
    public function formRapb($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $rapb = null;
        if ($id) {
            $rapb = $this->rapbModel->find($id);
        }

        $listRKT = $this->rktModel->orderBy('tahun', 'DESC')->findAll();

        $data = [
            'title' => $id ? 'Edit RAPB' : 'Tambah RAPB',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'rapb' => $rapb,
            'list_rkt' => $listRKT,
        ];

        return view('perencanaan/form_rapb', $data);
    }

    /**
     * Save RAPB
     */
    public function saveRapb()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'rkt_id' => $this->request->getPost('rkt_id'),
            'tahun' => $this->request->getPost('tahun'),
            'total_target_pendapatan' => $this->request->getPost('total_target_pendapatan') ?? 0,
            'total_rencana_belanja' => $this->request->getPost('total_rencana_belanja') ?? 0,
            'buffer_persen' => $this->request->getPost('buffer_persen') ?? 10,
            'status' => $this->request->getPost('status') ?? 'draft',
        ];

        if ($id) {
            $this->rapbModel->update($id, $data);
        } else {
            $this->rapbModel->insert($data);
        }
        
        return redirect()->to('/perencanaan/rapb')->with('success', 'RAPB berhasil disimpan');
    }

    // Detail RKT
    public function detailRkt($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $rkt = $this->rktModel->find($id);
        if (!$rkt) {
            return redirect()->to('/perencanaan/rkt')->with('error', 'RKT tidak ditemukan');
        }

        $programKerja = $this->programModel->getByRKT($id);

        $data = [
            'title' => 'Detail RKT Tahun ' . $rkt['tahun'],
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'rkt' => $rkt,
            'program_kerja' => $programKerja,
        ];

        return view('perencanaan/detail_rkt', $data);
    }

    // CRUD Program Kerja
    public function formProgram($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $program = null;
        $rkt_id = $this->request->getGet('rkt_id');
        
        if ($id) {
            $program = $this->programModel->find($id);
            $rkt_id = $program['rkt_id'];
        }

        $rkt = $this->rktModel->find($rkt_id);
        
        // Load pengurus for dropdown
        $organisasiModel = new \App\Models\StrukturOrganisasiModel();
        $list_pengurus = $organisasiModel->getActivePengurus();

        $data = [
            'title' => $id ? 'Edit Program Kerja' : 'Tambah Program Kerja',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'program' => $program,
            'rkt' => $rkt,
            'list_pengurus' => $list_pengurus,
        ];

        return view('perencanaan/form_program', $data);
    }

    public function saveProgram()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        $rkt_id = $this->request->getPost('rkt_id');
        
        $data = [
            'rkt_id' => $rkt_id,
            'bidang' => $this->request->getPost('bidang'),
            'nama_program' => $this->request->getPost('nama_program'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'target_output' => $this->request->getPost('target_output'),
            'pj_program' => $this->request->getPost('pj_program'),
        ];

        if ($id) {
            $this->programModel->update($id, $data);
        } else {
            $this->programModel->insert($data);
        }
        
        return redirect()->to('/perencanaan/rkt/detail/' . $rkt_id)->with('success', 'Program kerja berhasil disimpan');
    }

    // Detail Program Kerja
    public function detailProgram($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $program = $this->programModel->getProgramWithKegiatan($id);
        if (!$program) {
            return redirect()->to('/perencanaan/rkt')->with('error', 'Program tidak ditemukan');
        }

        // Get rencana kegiatan with linked kegiatan data
        $db = \Config\Database::connect();
        $builder = $db->table('rencana_kegiatan rk');
        $builder->select('rk.*, k.id as kegiatan_id_linked, k.nama_kegiatan as kegiatan_nama, k.status as kegiatan_status, k.tanggal as kegiatan_tanggal, k.realisasi as kegiatan_realisasi');
        $builder->join('kegiatan k', 'k.id = rk.kegiatan_id', 'left');
        $builder->where('rk.program_kerja_id', $id);
        $builder->orderBy('rk.timeline', 'ASC');
        $builder->orderBy('rk.bulan_target', 'ASC');
        $rencanaKegiatan = $builder->get()->getResultArray();

        $data = [
            'title' => 'Detail Program Kerja',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'program' => $program,
            'rencana_kegiatan' => $rencanaKegiatan,
        ];

        return view('perencanaan/detail_program', $data);
    }

    // CRUD Rencana Kegiatan
    public function formKegiatan($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $kegiatan = null;
        $program_id = $this->request->getGet('program_id');
        
        if ($id) {
            $kegiatan = $this->kegiatanModel->find($id);
            $program_id = $kegiatan['program_kerja_id'];
        }

        $program = $this->programModel->find($program_id);

        $data = [
            'title' => $id ? 'Edit Rencana Kegiatan' : 'Tambah Rencana Kegiatan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'kegiatan' => $kegiatan,
            'program' => $program,
        ];

        return view('perencanaan/form_kegiatan', $data);
    }

    public function saveKegiatan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        $program_id = $this->request->getPost('program_kerja_id');
        
        $data = [
            'program_kerja_id' => $program_id,
            'nama_kegiatan' => $this->request->getPost('nama_kegiatan'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'timeline' => $this->request->getPost('timeline'),
            'bulan_target' => $this->request->getPost('bulan_target'),
            'target_peserta' => $this->request->getPost('target_peserta'),
            'expected_outcome' => $this->request->getPost('expected_outcome'),
            'status' => $this->request->getPost('status') ?? 'belum_mulai',
            'progress_persen' => $this->request->getPost('progress_persen') ?? 0,
        ];

        if ($id) {
            $this->kegiatanModel->update($id, $data);
        } else {
            $this->kegiatanModel->insert($data);
        }
        
        return redirect()->to('/perencanaan/program/detail/' . $program_id)->with('success', 'Rencana kegiatan berhasil disimpan');
    }
}
