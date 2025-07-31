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

    // ====================
    // FORM LOGIN
    // ====================
    public function loginForm()
    {
        // Ambil settings dari tabel settings
        $settings = $this->settingsModel->getSettings(['site_name', 'site_icon']);

        return view('auth/login', [
            'site_name' => $settings['site_name'] ?? 'PropertyPlace',
            'site_icon' => $settings['site_icon'] ?? 'uploads/settings/default-favicon.png'
        ]);
    }

    // ====================
    // PROSES LOGIN
    // ====================
    public function login()
    {
        $login    = trim($this->request->getPost('email')); // Bisa berupa email atau username
        $password = trim($this->request->getPost('password'));

        // Deteksi apakah input adalah email
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Cari user berdasarkan email atau username
        $user = $this->userModel->where($field, $login)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', ucfirst($field) . ' tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            dd([
                'input'       => $password,
                'hash_in_db'  => $user['password'],
                'verified'    => password_verify($password, $user['password']),
                'hash_length' => strlen($user['password']),
            ]);
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

    // ====================
    // LOGOUT
    // ====================
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
