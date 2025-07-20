<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\SettingsModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->settingsModel = new SettingsModel();
    }

    public function loginForm()
    {
        // Ambil settings dari tabel settings
        $settings = $this->settingsModel->getSettings(['site_name', 'site_icon']);

        return view('auth/login', [
            'site_name' => $settings['site_name'] ?? 'PropertyPlace',
            'site_icon'    => $settings['site_icon'] ?? 'uploads/settings/default-favicon.png'
        ]);
    }

    public function login()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah.');
        }

        if ((int) $user['is_active'] !== 1) {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif.');
        }

        // Set session login
        session()->set([
            'id'        => $user['id'],
            'name'      => $user['name'],
            'email'     => $user['email'],
            'slug'      => $user['slug'],
            'foto'      => $user['foto'],
            'role'      => $user['role'],
            'logged_in' => true
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
