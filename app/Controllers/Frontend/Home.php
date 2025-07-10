<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\SettingsModel;
use App\Models\DeveloperModel;

class Home extends BaseController
{
    public function index()
    {
        $propertyModel = new PropertyModel();
        $settingsModel = new SettingsModel();
        $devModel = new DeveloperModel();

        $data['featured']   = $propertyModel->findAll();
        $data['settings']   = $settingsModel->first(); // Ambil pengaturan situs
        $data['developers'] = $devModel->orderBy('name', 'ASC')->findAll(); // Ambil semua developer

        return view('frontend/home', $data);
    }

    public function contact()
    {
        return view('frontend/contact');
    }

    public function sendContact()
    {
        $data = $this->request->getPost();

        // Validasi sederhana (bisa ditambah lebih lengkap)
        if (!$data['name'] || !$data['email'] || !$data['message']) {
            return redirect()->back()->with('error', 'Semua field harus diisi.');
        }

        // Simpan ke database (opsional) atau kirim email (jika sudah setup)
        // Misalnya disimpan ke database kontak (opsional):
        // $contactModel = new \App\Models\ContactModel();
        // $contactModel->save($data);

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim.');
    }

}
