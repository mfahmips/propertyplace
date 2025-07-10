<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class Contact extends BaseController
{
    public function index()
    {
        return view('frontend/contact');
    }

    public function submit()
    {
        $request = \Config\Services::request();

        $name = $request->getPost('name');
        $email = $request->getPost('email');
        $subject = $request->getPost('subject');
        $message = $request->getPost('message');

        if (!$name || !$email || !$message) {
            return redirect()->back()->with('error', 'Semua field harus diisi.');
        }

        // Di sini kamu bisa kirim email atau simpan ke database

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim.');
    }
}
