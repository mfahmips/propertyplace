<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\UserModel;
use App\Models\PenjualanModel;
use App\Models\DeveloperModel;

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

        // Ambil nama user dari session
        $username = session('name') ?? 'Guest';

        $jumlahPenjualan = (int) ($this->penjualanModel->selectSum('total')->first()['total'] ?? 0);

        $data = [
            'title'           => 'Dashboard',
            'breadcrumb'      => [['label' => 'Dashboard']],
            'username'        => $username,
            'foto'            => session('foto') ?? null, // ganti $userData yang tidak didefinisikan
            'totalProperty'   => $this->propertyModel->countAll(),
            'totalUser'       => $this->userModel->countAll(),
            'totalPenjualan'  => $jumlahPenjualan,
            'totalDeveloper'  => $this->developerModel->countAll(),
        ];

        return view('admin/index', $data);
    }
}
