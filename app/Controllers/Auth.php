<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function loginForm()
    {
        return view('auth/login');
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

        // login manual
        session()->set([
            'id'       => $user['id'],
            'name'     => $user['name'],
            'email'    => $user['email'],
            'slug'     => $user['slug'],
            'foto'     => $user['foto'],
            'role'     => $user['role'],
            'logged_in'=> true, // ← penting
        ]);


        // Sementara untuk debugging:
        // dd(session()->get()); // sudah benar, tidak usah pakai $user di sini

        return redirect()->to('/dashboard');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
