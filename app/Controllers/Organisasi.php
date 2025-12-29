<?php

namespace App\Controllers;

use App\Models\StrukturOrganisasiModel;

class Organisasi extends BaseController
{
    protected $organisasiModel;

    public function __construct()
    {
        $this->organisasiModel = new StrukturOrganisasiModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $pengurus = $this->organisasiModel->orderBy('urutan', 'ASC')
                                          ->orderBy('nama', 'ASC')
                                          ->findAll();

        $data = [
            'title' => 'Struktur Organisasi RT',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'pengurus' => $pengurus,
        ];

        return view('organisasi/index', $data);
    }

    public function form($id = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $pengurus = null;
        if ($id) {
            $pengurus = $this->organisasiModel->find($id);
        }

        $data = [
            'title' => $id ? 'Edit Pengurus' : 'Tambah Pengurus',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
            'pengurus' => $pengurus,
        ];

        return view('organisasi/form', $data);
    }

    public function save()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $id = $this->request->getPost('id');
        
        $data = [
            'nama' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'periode_mulai' => $this->request->getPost('periode_mulai'),
            'periode_selesai' => $this->request->getPost('periode_selesai'),
            'no_hp' => $this->request->getPost('no_hp'),
            'alamat' => $this->request->getPost('alamat'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
            'urutan' => $this->request->getPost('urutan') ?? 99,
        ];

        if ($id) {
            $this->organisasiModel->update($id, $data);
        } else {
            $this->organisasiModel->insert($data);
        }
        
        return redirect()->to('/organisasi')->with('success', 'Pengurus berhasil disimpan');
    }

    public function delete($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $this->organisasiModel->delete($id);
        return redirect()->to('/organisasi')->with('success', 'Pengurus berhasil dihapus');
    }
}
