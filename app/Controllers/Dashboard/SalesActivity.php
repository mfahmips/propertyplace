<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\AbsensiSalesModel;
use App\Models\PameranSalesModel;
use App\Models\KomisiSalesModel;
use App\Models\BookingModel;
use App\Models\DeveloperModel;
use App\Models\PropertyModel;
use App\Models\PropertyTypeModel;
use App\Models\SettingsModel;
use Dompdf\Dompdf;
use Dompdf\Options;
use CodeIgniter\Exceptions\PageNotFoundException;




class SalesActivity extends BaseController
{
    protected $absensiModel;
    protected $pameranModel;
    protected $komisiModel;
    protected $booking;

    public function __construct()
    {
        $this->absensiModel = new AbsensiSalesModel();
        $this->pameranModel = new PameranSalesModel();
        $this->komisiModel  = new KomisiSalesModel();
        $this->booking = new BookingModel();
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

    // Data pengajuan komisi
    if ($userRole === 'admin') {
        $pengajuan = $this->komisiModel
            ->select("
                komisi_sales.*,
                users.name AS user_name,
                bookings.id   AS booking_code,
                bookings.buyer_name,
                bookings.unit_number,
                bookings.price,
                properties.title AS property_title,
                property_type.name AS type_name
            ")
            ->join('users', 'users.id = komisi_sales.user_id')
            ->join('bookings', 'bookings.id = komisi_sales.booking_id')
            ->join('properties', 'properties.id = bookings.property_id', 'left')
            ->join('property_type', 'property_type.id = bookings.type_id', 'left')
            ->orderBy('komisi_sales.tanggal_ajuan', 'DESC')
            ->findAll();
    } else {
        $pengajuan = $this->komisiModel
            ->where('user_id', $userId)
            ->orderBy('tanggal_ajuan', 'DESC')
            ->findAll();
    }

    // Dropdown: hanya booking milik sales yang sudah confirmed
    $bookings = [];
    if ($userRole !== 'admin') {
        $bookingModel = new \App\Models\BookingModel();
        $bookings = $bookingModel
        ->select('bookings.*, property_type.name as type_name, properties.title as property_title')
        ->join('property_type', 'property_type.id = bookings.type_id', 'left')
        ->join('properties', 'properties.id = bookings.property_id', 'left')
        ->where('bookings.reserved_by_user_id', $userId)
        ->where('bookings.status', 'confirmed')
        ->whereNotIn('bookings.id', function ($builder) {
            return $builder->select('booking_id')->from('komisi_sales');
        })
        ->orderBy('bookings.created_at', 'DESC')
        ->findAll();

        }

    return view('admin/sales/komisi', [
        'title'         => 'Pengajuan Komisi',
        'breadcrumb'    => [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Sales Activity'],
            ['label' => 'Komisi']
        ],
        'developers'     => [],
        'selectedDevId'  => null,
        'properties'     => $properties,
        'pengajuan'      => $pengajuan,
        'bookings'       => $bookings,
        'isAdmin'        => $userRole === 'admin',
    ]);
}


public function saveKomisi()
{
    $bookingId = (int) $this->request->getPost('booking_id');
    $userId    = session('id');

    // Pastikan booking milik user & sudah confirmed
    $bookingModel = new \App\Models\BookingModel();
    $booking = $bookingModel
        ->where('id', $bookingId)
        ->where('reserved_by_user_id', $userId)
        ->where('status', 'confirmed')
        ->first();

    if (!$booking) {
        return redirect()->back()->with('error', 'Booking tidak valid atau belum dikonfirmasi.');
    }

    // Cegah pengajuan ganda untuk booking yang sama
    $sudahAda = $this->komisiModel->where('booking_id', $bookingId)->first();
    if ($sudahAda) {
        return redirect()->back()->with('error', 'Komisi untuk booking ini sudah diajukan.');
    }

    $this->komisiModel->insert([
        'booking_id'    => $bookingId,
        'user_id'       => $userId,
        'status'        => 'menunggu',
        'tanggal_ajuan' => date('Y-m-d H:i:s'),
        'created_at'    => date('Y-m-d H:i:s'),
        'updated_at'    => date('Y-m-d H:i:s'),
    ]);

    return redirect()->back()->with('success', 'Pengajuan komisi berhasil dikirim.');
}


public function updateKomisi()
{
    $id             = $this->request->getPost('id');
    $status         = $this->request->getPost('status');
    $komisiPersen   = $this->request->getPost('komisi_persen');
    $komisiNominal  = $this->request->getPost('komisi_nominal');
    $catatan        = $this->request->getPost('catatan');

    if (!$id || !$status) {
        return redirect()->back()->with('error', 'Data tidak lengkap.');
    }

    $data = [
        'status'          => $status,
        'komisi_persen'   => $komisiPersen,
        'komisi_nominal'  => $komisiNominal,
        'catatan'         => $catatan,
        'tanggal_acc'     => date('Y-m-d H:i:s'),
        'updated_at'      => date('Y-m-d H:i:s'),
    ];

    $this->komisiModel->update($id, $data);

    return redirect()->back()->with('success', 'Komisi berhasil diperbarui oleh admin.');
}

public function cetakKomisi($id)
{
    // Ambil 1 record komisi + detail booking + user + properti/tipe
    $komisi = $this->komisiModel
        ->select("
            komisi_sales.id,
            komisi_sales.booking_id,
            komisi_sales.user_id,
            komisi_sales.komisi_persen,
            komisi_sales.komisi_nominal,
            komisi_sales.status,
            komisi_sales.tanggal_ajuan,
            komisi_sales.catatan,

            bookings.id            AS booking_code,
            bookings.buyer_name,
            bookings.unit_number,
            bookings.price,
            bookings.created_at    AS booking_date,

            properties.title       AS property_title,
            property_type.name     AS type_name,

            users.name             AS sales_name,
            users.username         AS sales_username
        ")
        ->join('bookings', 'bookings.id = komisi_sales.booking_id')
        ->join('properties', 'properties.id = bookings.property_id', 'left')
        ->join('property_type', 'property_type.id = bookings.type_id', 'left')
        ->join('users', 'users.id = komisi_sales.user_id', 'left')
        ->where('komisi_sales.id', (int) $id)
        ->first();

    if (!$komisi) {
        throw PageNotFoundException::forPageNotFound('Data pengajuan komisi tidak ditemukan.');
    }

    // Siapkan Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true); // allow load asset eksternal jika perlu
    $dompdf = new Dompdf($options);

    // Render view ke HTML
    $html = view('admin/sales/komisi_pdf', [
        'komisi' => $komisi,
        'admin'  => session('name') ?? 'Admin'
    ]);

    // Generate PDF
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output inline (buka di tab); ubah Attachment=>true jika ingin auto-download
    $filename = 'pengajuan_komisi_'.$komisi['booking_code'].'.pdf';
    return $this->response
        ->setContentType('application/pdf')
        ->setHeader('Content-Disposition', 'inline; filename="'.$filename.'"')
        ->setBody($dompdf->output());
}


public function cetakKomisiPreview($id)
{
    helper('text');

    // Ambil data komisi + relasi
    $komisi = $this->komisiModel 
        ->select('komisi_sales.*, bookings.*, bookings.id as booking_code, users.name as sales_name, users.username as sales_username, property_type.name as type_name, properties.title as property_title')
        ->join('bookings', 'bookings.id = komisi_sales.booking_id')
        ->join('users', 'users.id = komisi_sales.user_id')
        ->join('properties', 'properties.id = bookings.property_id', 'left')
        ->join('property_type', 'property_type.id = bookings.type_id', 'left')
        ->where('komisi_sales.id', $id)
        ->first();

    if (!$komisi) {
        return redirect()->back()->with('error', 'Data pengajuan tidak ditemukan.');
    }

    // Ambil data settings
    $settingsModel = new \App\Models\SettingsModel();
    $settings = $settingsModel->first();

    // Kirim ke view
    return view('admin/sales/komisi_pdf', [
        'komisi'       => $komisi,
        'admin'        => session('name'),
        'settings'     => $settings,
        'preview_mode' => true
    ]);
}



public function bookings()
{
    $propertyModel = new PropertyModel();
    $typeModel     = new PropertyTypeModel();
    $bookingModel  = new \App\Models\BookingModel();

    // Ambil semua data booking tanpa pengecualian
    $bookings = $bookingModel
        ->select('bookings.*, property_type.name as type_name, properties.title as property_title')
        ->join('property_type', 'property_type.id = bookings.type_id', 'left')
        ->join('properties', 'properties.id = bookings.property_id', 'left')
        ->orderBy('bookings.created_at', 'DESC')
        ->findAll();

    $data = [
        'title'      => 'Booking Unit',
        'bookings'   => $bookings,
        'properties' => $propertyModel->orderBy('title', 'ASC')->findAll(),
        'types'      => $typeModel->orderBy('name', 'ASC')->findAll()
    ];

    return view('admin/sales/bookings', $data);
}


public function saveBooking()
{
    $bookingModel  = new BookingModel();
    $propertyModel = new PropertyModel();
    $typeModel     = new PropertyTypeModel();

    $rules = [
        'property_id'     => 'required|is_natural_no_zero',
        'type_id'         => 'required|is_natural_no_zero',
        'buyer_name'      => 'required|min_length[3]',
        'buyer_phone'     => 'required|min_length[6]',
        'price'           => 'permit_empty|numeric',
        'deposit_amount'  => 'permit_empty|numeric',
        'deposit_receipt' => 'permit_empty|max_size[deposit_receipt,2048]|ext_in[deposit_receipt,jpg,jpeg,png,pdf]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('error', 'Validasi gagal: ' . implode(', ', $this->validator->getErrors()));
    }

    $propertyId = (int) $this->request->getPost('property_id');
    $typeId     = (int) $this->request->getPost('type_id');
    $unitNumber = trim($this->request->getPost('unit_number'));

    $prop = $propertyModel->find($propertyId);
    $type = $typeModel->where('property_id', $propertyId)->where('id', $typeId)->first();
    if (!$prop || !$type) {
        return redirect()->back()->withInput()->with('error', 'Property atau tipe unit tidak valid.');
    }

    // Cek double booking
    $isDoubleBooking = $bookingModel
        ->where([
            'property_id' => $propertyId,
            'type_id'     => $typeId,
            'unit_number' => $unitNumber
        ])
        ->whereIn('status', ['reserved', 'confirmed'])
        ->first();

    if ($isDoubleBooking) {
        return redirect()->back()->withInput()->with('error', 'Unit ini sudah dibooking.');
    }

    // Upload bukti deposit (opsional)
    $depositPath = null;
    $file = $this->request->getFile('deposit_receipt');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $newName = 'dp_' . time() . '_' . $file->getRandomName();
        $file->move(FCPATH . 'uploads/user/booking/', $newName);
        $depositPath = 'uploads/user/booking/' . $newName;
    }

    // Simpan booking
    $bookingModel->insert([
        'developer_id'         => $prop['developer_id'],
        'property_id'          => $propertyId,
        'type_id'              => $typeId,
        'unit_number'          => $unitNumber ?: null,
        'buyer_name'           => $this->request->getPost('buyer_name'),
        'buyer_phone'          => $this->request->getPost('buyer_phone'),
        'buyer_email'          => $this->request->getPost('buyer_email'),
        'price'                => $this->request->getPost('price'),
        'payment_plan'         => $this->request->getPost('payment_plan'),
        'deposit_amount'       => $this->request->getPost('deposit_amount'),
        'deposit_receipt'      => $depositPath,
        'status'               => 'reserved',
        'reserved_by_user_id'  => session('user_id'),
        'reserved_at'          => date('Y-m-d H:i:s'),
        'expires_at'           => date('Y-m-d H:i:s', strtotime('+48 hours'))
    ]);

    return redirect()->back()->with('success', 'Booking berhasil disimpan.');
}


public function updateBooking()
{
    $bookingModel = new BookingModel();

    $bookingId   = (int) $this->request->getPost('id');
    $newStatus   = $this->request->getPost('status');

    $allowedStatus = ['pending', 'reserved', 'confirmed', 'cancelled', 'expired'];
    if (!in_array($newStatus, $allowedStatus)) {
        return redirect()->back()->with('error', 'Status tidak valid.');
    }

    $booking = $bookingModel->find($bookingId);
    if (!$booking) {
        return redirect()->back()->with('error', 'Data booking tidak ditemukan.');
    }

    // Jika ubah ke confirmed, pastikan tidak konflik
    if ($newStatus === 'confirmed') {
        $exists = $bookingModel
            ->where('id !=', $bookingId)
            ->where('property_id', $booking['property_id'])
            ->where('type_id', $booking['type_id'])
            ->where('unit_number', $booking['unit_number'])
            ->whereIn('status', ['reserved', 'confirmed'])
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Unit sudah dikonfirmasi di booking lain.');
        }
    }

    $bookingModel->update($bookingId, [
        'status'     => $newStatus,
        'expires_at' => $newStatus === 'confirmed' ? null : $booking['expires_at'],
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    return redirect()->back()->with('success', 'Status booking diperbarui.');
}


public function getTypesByProperty($propertyId)
{
    $model = new PropertyTypeModel();
    $types = $model->where('property_id', $propertyId)->findAll();

    return $this->response->setJSON([
        'success' => true,
        'data'    => $types
    ]);
}




}
