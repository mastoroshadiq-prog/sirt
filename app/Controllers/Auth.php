<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url', 'cookie']);
    }

    /**
     * Display login form
     */
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Process login
     */
    public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        $user = $this->userModel->verifyCredentials($username, $password);

        if ($user) {
            // Set session
            $sessionData = [
                'user_id' => $user['id'],
                'username' => $user['username'],
                'role' => $user['role'],
                'nama_lengkap' => $user['nama_lengkap'],
                'logged_in' => true,
            ];
            session()->set($sessionData);

            // Set remember me cookie if checked
            if ($remember) {
                // Cookie valid for 30 days
                set_cookie('si_rt_remember', $user['id'], 30 * 24 * 60 * 60);
            }

            // Log login activity
            log_message('info', "User {$username} logged in successfully");

            return redirect()->to('/dashboard')->with('success', 'Login berhasil! Selamat datang, ' . $user['nama_lengkap']);
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Username atau password salah!');
        }
    }

    /**
     * Logout
     */
    public function logout()
    {
        $username = session()->get('username');
        
        // Destroy session
        session()->destroy();
        
        // Delete remember me cookie
        delete_cookie('si_rt_remember');

        // Log logout activity
        log_message('info', "User {$username} logged out");

        return redirect()->to('/auth/login')->with('success', 'Logout berhasil');
    }

    /**
     * Display change password form
     */
    public function changePassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        return view('auth/change_password');
    }

    /**
     * Process password change
     */
    public function updatePassword()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $rules = [
            'current_password' => 'required',
            'new_password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $userId = session()->get('user_id');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        // Verify current password
        $user = $this->userModel->find($userId);
        if (!password_verify($currentPassword, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Password lama tidak sesuai');
        }

        // Update password
        if ($this->userModel->updatePassword($userId, $newPassword)) {
            log_message('info', "User {$user['username']} changed password");
            return redirect()->to('/dashboard')->with('success', 'Password berhasil diubah');
        } else {
            return redirect()->back()->with('error', 'Gagal mengubah password');
        }
    }
}
