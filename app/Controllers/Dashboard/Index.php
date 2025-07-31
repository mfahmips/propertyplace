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

        // Ambil user dari session
        $user = [
            'id'    => session('id'),
            'name'  => session('name'),
            'email' => session('email'),
            'slug'  => session('slug'),
            'foto'  => session('foto'),
            'role'  => session('role'),
        ];

        // Jika bukan sales (misal admin/management), tampilkan dashboard admin
        $jumlahPenjualan = (int) ($this->penjualanModel->selectSum('total')->first()['total'] ?? 0);

        $data = [
            'title'           => 'Dashboard',
            'breadcrumb'      => [['label' => 'Dashboard']],
            'username'        => $user['name'],
            'foto'            => $user['foto'],
            'totalProperty'   => $this->propertyModel->countAll(),
            'totalUser'       => $this->userModel->countAll(),
            'totalPenjualan'  => $jumlahPenjualan,
            'totalDeveloper'  => $this->developerModel->countAll(),
        ];

        return view('admin/index', $data);
    }
}
