<?php

namespace App\Controllers;

use App\Models\KasTransaksiModel;
use App\Models\KategoriIuranModel;
use App\Models\IuranPembayaranModel;
use App\Models\KartuKeluargaModel;

class Keuangan extends BaseController
{
    protected $kasModel;
    protected $kategoriIuranModel;
    protected $iuranModel;
    protected $kkModel;

    public function __construct()
    {
        $this->kasModel = new KasTransaksiModel();
        $this->kategoriIuranModel = new KategoriIuranModel();
        $this->iuranModel = new IuranPembayaranModel();
        $this->kkModel = new KartuKeluargaModel();
        helper(['form', 'url']);
    }

    /**
     * Dashboard Keuangan
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $bulan = $this->request->getGet('bulan') ?? date('n');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        // Get current saldo
        $saldoKas = $this->kasModel->getSaldoKas();

        // Get monthly summary
        $summary = $this->kasModel->getMonthlySummary($bulan, $tahun);
        
        // Get iuran by category
        $iuranByCategory = $this->iuranModel->getIuranByCategory($bulan, $tahun);

        // Get saldo trend
        $saldoTrend = $this->kasModel->getSaldoTrend(6);

        $data = [
            'title' => 'Dashboard Keuangan',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'saldo_kas' => $saldoKas,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'total_masuk' => $summary['total_masuk'],
            'total_keluar' => $summary['total_keluar'],
            'iuran_by_category' => $iuranByCategory,
            'saldo_trend' => $saldoTrend,
        ];

        return view('keuangan/dashboard', $data);
    }

    /**
     * Buku Kas
     */
    public function bukuKas()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $bulan = $this->request->getGet('bulan') ?? date('n');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $start = "$tahun-" . str_pad($bulan, 2, '0', STR_PAD_LEFT) . "-01";
        $end = date('Y-m-t', strtotime($start));

        $transaksi = $this->kasModel->getTransactionsByDateRange($start, $end);

        $data = [
            'title' => 'Buku Kas',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'bulan' => $bulan,
            'tahun' => $tahun,
            'transaksi' => $transaksi,
            'saldo_akhir' => $this->kasModel->getSaldoKas(),
        ];

        return view('keuangan/buku_kas', $data);
    }

    /**
     * Input Iuran - Form
     */
    public function inputIuran()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Get active KK
        $listKK = $this->kkModel->where('status', 'aktif')->findAll();
        
        // Get active categories
        $kategoriIuran = $this->kategoriIuranModel->getActiveCategories();

        $data = [
            'title' => 'Input Iuran Warga',
            'user' => [
                ' lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_kk' => $listKK,
            'kategori_iuran' => $kategoriIuran,
        ];

        return view('keuangan/input_iuran', $data);
    }

    /**
     * Process Input Iuran
     */
    public function storeIuran()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $kkId = $this->request->getPost('kk_id');
        $bulan = $this->request->getPost('bulan');
        $tahun = $this->request->getPost('tahun');
        $tanggalBayar = $this->request->getPost('tanggal_bayar');
        $kategoriIds = $this->request->getPost('kategori_iuran_id'); // Array
        $keterangan = $this->request->getPost('keterangan');

        if (empty($kategoriIds)) {
            return redirect()->back()->with('error', 'Pilih minimal 1 kategori iuran');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $totalBayar = 0;

        foreach ($kategoriIds as $kategoriId) {
            // Check if already paid
            if ($this->iuranModel->isAlreadyPaid($kkId, $kategoriId, $bulan, $tahun)) {
                continue;
            }

            // Get kategori nominal
            $kategori = $this->kategoriIuranModel->find($kategoriId);
            $nominal = $kategori['nominal_default'];

            // Check for custom nominal dari kk_iuran_setup
            $customNominal = $db->table('kk_iuran_setup')
                               ->where(['kk_id' => $kkId, 'kategori_iuran_id' => $kategoriId])
                               ->get()
                               ->getRowArray();
            
            if ($customNominal && $customNominal['nominal_custom']) {
                $nominal = $customNominal['nominal_custom'];
            }

            // Record payment
            $paymentData = [
                'kk_id' => $kkId,
                'kategori_iuran_id' => $kategoriId,
                'bulan' => $bulan,
                'tahun' => $tahun,
                'jumlah' => $nominal,
                'tanggal_bayar' => $tanggalBayar,
                'keterangan' => $keterangan,
                'user_id' => session()->get('user_id'),
            ];

            $this->iuranModel->recordPayment($paymentData);
            $totalBayar += $nominal;
        }

        $db->transComplete();

        if ($db->transStatus()) {
            return redirect()->to('/keuangan')->with('success', 'Iuran berhasil dicatat. Total: Rp ' . number_format($totalBayar, 0, ',', '.'));
        } else {
            return redirect()->back()->with('error', 'Gagal menyimpan data iuran');
        }
    }

    /**
     * Status Iuran
     */
    public function statusIuran()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $bulan = $this->request->getGet('bulan') ?? date('n');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $paymentStatus = $this->iuranModel->getMonthlyPaymentStatus($bulan, $tahun);

        $data = [
            'title' => 'Status Iuran Warga',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'bulan' => $bulan,
            'tahun' => $tahun,
            'payment_status' => $paymentStatus,
        ];

        return view('keuangan/status_iuran', $data);
    }
}
