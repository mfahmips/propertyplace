<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\UserModel;
use App\Models\PenjualanModel;
use App\Models\DeveloperModel;
use App\Models\NotificationModel;
use App\Models\SettingsModel;

class Index extends BaseController
{
    protected $propertyModel;
    protected $userModel;
    protected $penjualanModel;
    protected $developerModel;

    public function __construct()
    {
        $this->propertyModel   = new PropertyModel();
        $this->userModel       = new UserModel();
        $this->penjualanModel  = new PenjualanModel();
        $this->developerModel  = new DeveloperModel();
    }

    public function index()
{
    if (!session()->get('logged_in')) {
        return redirect()->to('/login');
    }

    // Ambil user lengkap dari database
    $user = $this->userModel->find(session('id'));

    // Cek field yang wajib diisi
    $profileIncomplete =
        trim($user['place_of_birth'] ?? '') === '' ||
        trim($user['date_of_birth'] ?? '') === '' ||
        trim($user['gender'] ?? '') === '' ||
        trim($user['address'] ?? '') === '';

    $jumlahPenjualan = (int) ($this->penjualanModel->selectSum('total')->first()['total'] ?? 0);

    $data = [
        'title'            => 'Dashboard',
        'breadcrumb'       => [['label' => 'Dashboard']],
        'username'         => $user['name'],
        'foto'             => $user['foto'],
        'totalProperty'    => $this->propertyModel->countAll(),
        'totalUser'        => $this->userModel->countAll(),
        'totalPenjualan'   => $jumlahPenjualan,
        'totalDeveloper'   => $this->developerModel->countAll(),
        'profileIncomplete'=> $profileIncomplete,
        'user'             => $user, // kirim ke view jika butuh
    ];

    return view('admin/index', $data);
}


}
