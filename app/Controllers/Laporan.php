<?php

namespace App\Controllers;

use App\Models\TransaksiKeuanganModel;
use App\Models\WargaModel;
use App\Models\KegiatanModel;
use App\Models\JadwalRondaModel;

class Laporan extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    /**
     * Dashboard Laporan
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Laporan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
        ];

        return view('laporan/dashboard', $data);
    }

    /**
     * Laporan Keuangan
     */
    public function keuangan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $transaksiModel = new TransaksiKeuanganModel();
        $transaksi = $transaksiModel->getTransaksiByMonth($bulan, $tahun);
        
        $totalMasuk = 0;
        $totalKeluar = 0;
        
        foreach ($transaksi as $tr) {
            $totalMasuk += $tr['masuk'];
            $totalKeluar += $tr['keluar'];
        }
        
       $saldo = $totalMasuk - $totalKeluar;

        $data = [
            'title' => 'Laporan Keuangan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'transaksi' => $transaksi,
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo' => $saldo,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('laporan/keuangan', $data);
    }

    /**
     * Laporan Warga
     */
    public function warga()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $wargaModel = new WargaModel();
        
        $totalWarga = $wargaModel->countAll();
        $totalLakiLaki = $wargaModel->where('jenis_kelamin', 'L')->countAllResults();
        $totalPerempuan = $wargaModel->where('jenis_kelamin', 'P')->countAllResults();
        
        $data = [
            'title' => 'Laporan Warga',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'total_warga' => $totalWarga,
            'total_laki_laki' => $totalLakiLaki,
            'total_perempuan' => $totalPerempuan,
        ];

        return view('laporan/warga', $data);
    }

    /**
     * Laporan Kegiatan
     */
    public function kegiatan()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $kegiatanModel = new KegiatanModel();
        $kegiatan = $kegiatanModel->getMonthlyKegiatan($bulan, $tahun);

        $data = [
            'title' => 'Laporan Kegiatan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'kegiatan' => $kegiatan,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('laporan/kegiatan', $data);
    }

    /**
     * Laporan Ronda
     */
    public function ronda()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $bulan = $this->request->getGet('bulan') ?? date('m');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $jadwalModel = new JadwalRondaModel();
        $jadwal = $jadwalModel->getJadwalByMonth($bulan, $tahun);

        $data = [
            'title' => 'Laporan Ronda',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'jadwal' => $jadwal,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ];

        return view('laporan/ronda', $data);
    }
}
