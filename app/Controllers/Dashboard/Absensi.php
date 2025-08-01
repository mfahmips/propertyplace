<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\AbsensiSalesModel;

class Absensi extends BaseController
{
    protected $absensiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiSalesModel();
    }

    public function index()
    {

        $absenToday = $this->absensiModel
            ->where('user_id', session('id'))
            ->where('tanggal', date('Y-m-d'))
            ->first();

        return view('admin/sales/absen', [
        'title' => 'Absensi Sales',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Absensi']
        ],
        'absenToday' => $absenToday
    ]);

    }

    public function masuk()
    {
        if (session('role') !== 'sales') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $lokasi = $this->request->getPost('lokasi_pameran');
        if (empty($lokasi)) {
            return redirect()->back()->with('error', 'Lokasi pameran wajib diisi.');
        }

        $file = $this->request->getFile('foto_masuk');
        $namaFoto = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move('uploads/absensi', $namaFoto);
        }

        $this->absensiModel->save([
            'user_id'         => session('id'),
            'tanggal'         => date('Y-m-d'),
            'waktu_masuk'     => date('H:i:s'),
            'foto_masuk'      => $namaFoto,
            'lokasi_pameran'  => $lokasi,
            'status'          => 'masuk'
        ]);

        return redirect()->back()->with('success', 'Selamat bertugas, tetap semangat, yakin closing!');
    }

    public function pulang()
    {
        if (session('role') !== 'sales') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        $absen = $this->absensiModel
            ->where('user_id', session('id'))
            ->where('tanggal', date('Y-m-d'))
            ->first();

        if (!$absen) {
            return redirect()->back()->with('error', 'Anda belum melakukan absen masuk.');
        }

        $file = $this->request->getFile('foto_pulang');
        $namaFoto = $absen['foto_pulang'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move('uploads/absensi', $namaFoto);
        }

        $this->absensiModel->update($absen['id'], [
            'waktu_keluar'       => date('H:i:s'),
            'foto_pulang'        => $namaFoto,
            'database_pameran'   => $this->request->getPost('database_pameran'),
            'status'             => 'pulang'
        ]);

        return redirect()->back()->with('success', 'Terima kasih, absen pulang berhasil.');
    }
}
