<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $data = [
            'title' => 'Dashboard',
            'user' => [
                'nama_lengkap' => session()->get('nama_lengkap'),
                'role' => session()->get('role'),
            ],
        ];

        return view('dashboard/index', $data);
    }
}
