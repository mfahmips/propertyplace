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
    // HALAMAN LOGIN + REGISTER
    // ====================
    public function index()
    {
        // Redirect jika sudah login
        if (session()->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $settings = $this->settingsModel->getSettings(['site_name', 'site_icon', 'site_logo']);

        // Deteksi apakah URL saat ini adalah /register
        $isRegister = uri_string() === 'register';

        return view('auth/index', [
            'settings'   => $settings,
            'site_name'  => $settings['site_name'] ?? 'PropertyPlace',
            'isRegister' => $isRegister
        ]);
    }

    // ====================
    // PROSES LOGIN
    // ====================
    public function login()
    {
        $login    = trim($this->request->getPost('email')); // email atau username
        $password = trim($this->request->getPost('password'));

        if (empty($login) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Email / Username dan Password wajib diisi.');
        }

        // Tentukan apakah login pakai email atau username
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user  = $this->userModel->where($field, $login)->first();

        if (!$user) {
            return redirect()->back()->withInput()->with('error', ucfirst($field) . ' tidak ditemukan.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password salah.');
        }

        // ✅ Hapus blokir login ketika is_active = 0
        // User tetap bisa login, tapi nanti dibatasi oleh InactiveUserFilter

        // Set session login
        session()->set([
            'id'        => $user['id'],
            'name'      => $user['name'],
            'email'     => $user['email'],
            'username'  => $user['username'],
            'slug'      => $user['slug'],
            'foto'      => $user['foto'] ?? null,
            'gender'    => $user['gender'],
            'role'      => $user['role'] ?? 'sales',
            'is_active' => (int) $user['is_active'], // ⬅️ tambahkan ini agar filter bisa bekerja
            'logged_in' => true
        ]);

        // Jika belum aktif, tampilkan peringatan setelah login
        if ((int) $user['is_active'] !== 1) {
            return redirect()
                ->to('/dashboard')
                ->with('warning', 'Akun Anda belum disetujui oleh admin.');
        }

        return redirect()->to('/dashboard');
    }


    // ====================
    // PROSES REGISTER
    // ====================
    public function register()
    {
        $name        = trim($this->request->getPost('name'));
        $username    = trim($this->request->getPost('username'));
        $email       = trim($this->request->getPost('email'));
        $password    = trim($this->request->getPost('password'));
        $re_password = trim($this->request->getPost('re_password'));

        // Validasi dasar
        if (empty($name) || empty($username) || empty($email) || empty($password) || empty($re_password)) {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
        }

        if ($password !== $re_password) {
            return redirect()->back()->withInput()->with('error', 'Konfirmasi password tidak cocok.');
        }

        // Pastikan email & username unik
        if ($this->userModel->where('email', $email)->orWhere('username', $username)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email atau Username sudah digunakan.');
        }

        $slug = strtolower(url_title($username, '-', true));

        // Simpan data user baru
        $this->userModel->insert([
            'name'       => $name,
            'username'   => $username,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'slug'       => $slug,
            'role'       => 'sales',
            'is_active'  => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil! Silakan login.');
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
