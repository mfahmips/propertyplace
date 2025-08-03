<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\AbsensiSalesModel;
use App\Models\PameranSalesModel;
use App\Models\KomisiSalesModel;
use App\Models\DeveloperModel;
use App\Models\PropertyModel;

class SalesActivity extends BaseController
{
    protected $absensiModel;
    protected $pameranModel;
    protected $komisiModel;

    public function __construct()
    {
        $this->absensiModel = new AbsensiSalesModel();
        $this->pameranModel = new PameranSalesModel();
        $this->komisiModel  = new KomisiSalesModel();
    }

    public function absensi()
{
    $role = session('role');
    $userId = session('id');

    if ($role === 'admin') {
        $absensi = $this->absensiModel
            ->select('absensi_sales.*, users.name')
            ->join('users', 'users.id = absensi_sales.user_id')
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    } else {
        $absensi = $this->absensiModel
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'DESC')
            ->findAll();
    }

    $absenToday = $this->absensiModel
        ->where('user_id', $userId)
        ->where('tanggal', date('Y-m-d'))
        ->first();

    return view('admin/sales/absen', [
        'title' => 'Absensi Sales',
        'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Sales Activity'],
                ['label' => 'Absensi']
            ],
        'absensi' => $absensi,
        'absenToday' => $absenToday,
        'lokasiPameran' => $this->pameranModel->where('status', 'aktif')->findAll(),
        'riwayatAbsen' => $absensi
    ]);
}


public function absenMasuk()
{
    if (session('role') !== 'sales') {
        return redirect()->back()->with('error', 'Akses ditolak.');
    }

    $base64Foto = $this->request->getPost('foto_base64_masuk');
    $fotoFileName = $this->saveBase64ToFile($base64Foto, 'checkin', 'masuk');

    $this->absensiModel->save([
        'user_id'         => session('id'),
        'tanggal'         => date('Y-m-d'),
        'waktu_masuk'     => date('H:i:s'),
        'foto_masuk'      => $fotoFileName,
        'lokasi_pameran'  => $this->request->getPost('lokasi_pameran'),
        'status'          => $this->request->getPost('status') ?? 'masuk',
    ]);

    return redirect()->back()->with('success', 'Absen masuk berhasil.');
}


public function absenPulang()
{
    if (session('role') !== 'sales') {
        return redirect()->back()->with('error', 'Akses ditolak.');
    }

    $absen = $this->absensiModel
        ->where('user_id', session('id'))
        ->where('tanggal', date('Y-m-d'))
        ->first();

    if (!$absen) {
        return redirect()->back()->with('error', 'Belum absen masuk.');
    }

    $base64Foto = $this->request->getPost('foto_base64_pulang');
    $fotoFileName = $this->saveBase64ToFile($base64Foto, 'checkout', 'pulang');

    $this->absensiModel->update($absen['id'], [
        'waktu_keluar'      => date('H:i:s'),
        'foto_pulang'       => $fotoFileName,
        'database_pameran'  => $this->request->getPost('database_pameran'),
        'status'            => 'pulang',
    ]);

    return redirect()->back()->with('success', 'Absen pulang berhasil.');
}



private function saveBase64ToFile($base64String, $folder = 'checkin', $prefix = 'foto')
{
    if (empty($base64String)) return null;

    $data = explode(',', $base64String);
    if (count($data) !== 2) return null;

    $decodedImage = base64_decode($data[1]);
    $filename = $prefix . '_' . time() . '_' . uniqid() . '.jpg';
    $uploadDir = FCPATH . 'uploads/user/absensi/' . $folder . '/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    file_put_contents($uploadDir . $filename, $decodedImage);

    return $filename; // ⬅ hanya nama file
}



public function pameran()
{
    return view('admin/sales/pameran', [
        'title' => 'Data Pameran',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Sales Activity'],
            ['label' => 'Pameran']
        ],
        'pameran' => $this->pameranModel
            ->orderBy('created_at', 'DESC')
            ->findAll()
    ]);
}


public function savePameran()
{
    $id = $this->request->getPost('id');
    $data = [
        'lokasi' => $this->request->getPost('lokasi'),
        'status' => $this->request->getPost('status') ?? 'aktif'
    ];

    if ($id) {
        $this->pameranModel->update($id, $data);
        $msg = 'Data pameran diperbarui.';
    } else {
        $this->pameranModel->save($data);
        $msg = 'Data pameran ditambahkan.';
    }

    return redirect()->back()->with('success', $msg);
}


public function deletePameran($id)
{
    $this->pameranModel->delete($id);
    return redirect()->back()->with('success', 'Pameran berhasil dihapus.');
}


public function komisi()
{
    $propertyModel = new PropertyModel();
    $properties = $propertyModel->findAll();

    $userRole = session('role');
    $userId   = session('id');

    if ($userRole === 'admin') {
        // Admin melihat semua pengajuan + nama user
        $pengajuan = $this->komisiModel
            ->select('komisi_sales.*, users.name as user_name')
            ->join('users', 'users.id = komisi_sales.user_id')
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();
    } else {
        // Sales hanya melihat miliknya
        $pengajuan = $this->komisiModel
            ->where('user_id', $userId)
            ->orderBy('tanggal_pengajuan', 'DESC')
            ->findAll();
    }

    return view('admin/sales/komisi', [
        'title' => 'Pengajuan Komisi',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Sales Activity'],
            ['label' => 'Komisi']
        ],
        'developers'     => [], // Optional
        'selectedDevId'  => null,
        'properties'     => $properties,
        'pengajuan'      => $pengajuan,
        'isAdmin'        => $userRole === 'admin', // Kirim flag role ke view
    ]);
}


public function saveKomisi()
{
    $file = $this->request->getFile('file_bukti');
    $fileName = null;

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $fileName = $file->getRandomName();
        $file->move('uploads/user/komisi', $fileName);
    }

    $propertyId  = $this->request->getPost('property_id');
    $property    = (new \App\Models\PropertyModel())->find($propertyId);
    $developerId = $property['developer_id'] ?? null;

    $this->komisiModel->save([
        'user_id'            => session('id'),
        'property_id'        => $propertyId,
        'developer_id'       => $developerId,
        'harga'              => $this->request->getPost('harga'),
        'keterangan'         => $this->request->getPost('keterangan'),
        'file_bukti'         => $fileName,
        'status'             => 'diajukan',
        'tanggal_pengajuan' => date('Y-m-d H:i:s')
    ]);

    return redirect()->back()->with('success', 'Pengajuan komisi berhasil dikirim.');
}

public function updateKomisi()
{
    $id = $this->request->getPost('id');
    $status = $this->request->getPost('status');
    $komisi = $this->request->getPost('komisi');

    if (!$id || !$status) {
        return redirect()->back()->with('error', 'Data tidak lengkap.');
    }

    // Pastikan status valid
    $validStatus = ['diajukan', 'diproses', 'disetujui', 'ditolak', 'cair'];
    if (!in_array($status, $validStatus)) {
        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    // Simpan ke database
    $this->komisiModel->update($id, [
        'status' => $status,
        'komisi' => $komisi
    ]);

    return redirect()->back()->with('success', 'Data komisi berhasil diperbarui.');
}


}
