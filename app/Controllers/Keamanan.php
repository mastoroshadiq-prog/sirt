<?php

namespace App\Controllers;

use App\Models\AnggotaRondaModel;
use App\Models\JadwalRondaModel;
use App\Models\LaporanKejadianModel;

class Keamanan extends BaseController
{
    protected $anggotaModel;
    protected $jadwalModel;
    protected $laporanModel;

    public function __construct()
    {
        $this->anggotaModel = new AnggotaRondaModel();
        $this->jadwalModel = new JadwalRondaModel();
        $this->laporanModel = new LaporanKejadianModel();
        helper(['form', 'url']);
    }

    /**
     * Dashboard Keamanan
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $totalAnggota = $this->anggotaModel->where('status', 'aktif')->countAllResults();
        $jadwalMingguIni = $this->jadwalModel->getJadwalMingguIni();
        $laporanTerbaru = $this->laporanModel->orderBy('tanggal_waktu', 'DESC')->limit(5)->findAll();
        
        $data = [
            'title' => 'Keamanan & Ronda',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'total_anggota' => $totalAnggota,
            'jadwal_minggu_ini' => $jadwalMingguIni,
            'laporan_terbaru' => $laporanTerbaru,
        ];

        return view('keamanan/dashboard', $data);
    }

    /**
     * Anggota Ronda
     */
    public function anggota()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $listAnggota = $this->anggotaModel->orderBy('nama', 'ASC')->findAll();

        $data = [
            'title' => 'Anggota Ronda',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_anggota' => $listAnggota,
        ];

        return view('keamanan/anggota', $data);
    }

    /**
     * Jadwal Ronda
     */
    public function jadwal()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        
        $listJadwal = $this->jadwalModel->getJadwalByMonth($bulan, $tahun);

        $data = [
            'title' => 'Jadwal Ronda',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_jadwal' => $listJadwal,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('keamanan/jadwal', $data);
    }

    /**
     * Laporan Kejadian
     */
    public function laporan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $statusFilter = $this->request->getGet('status');
        
        if ($statusFilter) {
            $listLaporan = $this->laporanModel->where('status', $statusFilter)
                                             ->orderBy('tanggal_waktu', 'DESC')
                                             ->findAll();
        } else {
            $listLaporan = $this->laporanModel->orderBy('tanggal_waktu', 'DESC')->findAll();
        }

        $data = [
            'title' => 'Laporan Kejadian',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_laporan' => $listLaporan,
            'status_filter' => $statusFilter,
        ];

        return view('keamanan/laporan', $data);
    }

    /**
     * Detail Laporan
     */
    public function detailLaporan(int $id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $laporan = $this->laporanModel->find($id);
        
        if (!$laporan) {
            return redirect()->to('/keamanan/laporan')->with('error', 'Laporan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Laporan Kejadian',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'laporan' => $laporan,
        ];

        return view('keamanan/detail_laporan', $data);
    }

    // CRUD Anggota
    public function formAnggota($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $anggota = null;
        if ($id) {
            $anggota = $this->anggotaModel->find($id);
        }

        $data = [
            'title' => $id ? 'Edit Anggota' : 'Tambah Anggota',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'anggota' => $anggota,
        ];

        return view('keamanan/form_anggota', $data);
    }

    public function saveAnggota()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'is_koordinator' => $this->request->getPost('is_koordinator') ? 1 : 0,
            'status' => $this->request->getPost('status') ?? 'aktif',
        ];

        if ($id) {
            $this->anggotaModel->update($id, $data);
        } else {
            $this->anggotaModel->insert($data);
        }
        
        return redirect()->to('/keamanan/anggota')->with('success', 'Anggota berhasil disimpan');
    }

    // CRUD Jadwal
    public function formJadwal($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $jadwal = null;
        if ($id) {
            $jadwal = $this->jadwalModel->find($id);
        }

        $data = [
            'title' => $id ? 'Edit Jadwal' : 'Tambah Jadwal',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'jadwal' => $jadwal,
        ];

        return view('keamanan/form_jadwal', $data);
    }

    public function saveJadwal()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'tanggal' => $this->request->getPost('tanggal'),
            'shift' => $this->request->getPost('shift'),
            'shift_custom' => $this->request->getPost('shift_custom'),
            'lokasi_pos' => $this->request->getPost('lokasi_pos'),
            'catatan' => $this->request->getPost('catatan'),
            'status' => $this->request->getPost('status') ?? 'scheduled',
        ];

        if ($id) {
            $this->jadwalModel->update($id, $data);
        } else {
            $this->jadwalModel->insert($data);
        }
        
        return redirect()->to('/keamanan/jadwal')->with('success', 'Jadwal berhasil disimpan');
    }

    // CRUD Laporan
    public function formLaporan($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $laporan = null;
        if ($id) {
            $laporan = $this->laporanModel->find($id);
        }

        $data = [
            'title' => $id ? 'Edit Laporan' : 'Tambah Laporan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'laporan' => $laporan,
        ];

        return view('keamanan/form_laporan', $data);
    }

    public function saveLaporan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'tanggal_waktu' => $this->request->getPost('tanggal_waktu'),
            'jenis_kejadian' => $this->request->getPost('jenis_kejadian'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'lokasi' => $this->request->getPost('lokasi'),
            'tindakan' => $this->request->getPost('tindakan'),
            'status' => $this->request->getPost('status') ?? 'dilaporkan',
            'pelapor_id' => session()->get('user_id'),
        ];

        if ($id) {
            $this->laporanModel->update($id, $data);
        } else {
            $this->laporanModel->insert($data);
        }
        
        return redirect()->to('/keamanan/laporan')->with('success', 'Laporan berhasil disimpan');
    }
}
