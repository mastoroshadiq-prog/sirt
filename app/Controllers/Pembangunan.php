<?php

namespace App\Controllers;

use App\Models\PembangunanModel;

class Pembangunan extends BaseController
{
    protected $pembangunanModel;

    public function __construct()
    {
        $this->pembangunanModel = new PembangunanModel();
        helper(['form', 'url']);
    }

    /**
     * Dashboard Pembangunan
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $priorityFilter = $this->request->getGet('priority');
        $statusFilter = $this->request->getGet('status');

        if ($priorityFilter) {
            $listProyek = $this->pembangunanModel->getByPriority($priorityFilter);
        } elseif ($statusFilter) {
            $listProyek = $this->pembangunanModel->where('status', $statusFilter)
                                                  ->orderBy('timeline_mulai', 'ASC')
                                                  ->findAll();
        } else {
            $listProyek = $this->pembangunanModel->orderBy('priority', 'ASC')
                                                  ->orderBy('timeline_mulai', 'ASC')
                                                  ->findAll();
        }

        $stats = $this->pembangunanModel->getStats();

        $data = [
            'title' => 'Pembangunan & Infrastruktur',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'list_proyek' => $listProyek,
            'stats' => $stats,
            'priority_filter' => $priorityFilter,
            'status_filter' => $statusFilter,
        ];

        return view('pembangunan/dashboard', $data);
    }

    /**
     * Detail Proyek
     */
    public function detail(int $id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $proyek = $this->pembangunanModel->find($id);

        if (!$proyek) {
            return redirect()->to('/pembangunan')->with('error', 'Proyek tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Proyek',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'proyek' => $proyek,
        ];

        return view('pembangunan/detail', $data);
    }
}
