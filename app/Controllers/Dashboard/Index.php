<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\UserModel;
use App\Models\PenjualanModel;
use App\Models\DeveloperModel;
use App\Models\PropertyTypeModel;

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

        // Hitung total penjualan
        $jumlahPenjualan = (int) ($this->penjualanModel->selectSum('total')->first()['total'] ?? 0);

        // Ambil semua developer untuk dropdown
        $developerId = $this->request->getGet('developer_id');
        $developers = $this->developerModel->findAll();

        // Builder properti dengan join ke developers
        $builder = $this->propertyModel
            ->select('properties.*, developers.name as developer_name, property_details.price_text, property_details.description')
            ->join('developers', 'developers.id = properties.developer_id', 'left')
            ->join('property_details', 'property_details.property_id = properties.id', 'left');

        if (!empty($developerId)) {
            $builder->where('properties.developer_id', $developerId);
        }

        $properties = $builder->paginate(4, 'property'); // gunakan alias "property" untuk pagination
        $pager = $this->propertyModel->pager;

        // Ambil types untuk tiap property
        $typeModel = new PropertyTypeModel();
        foreach ($properties as &$property) {
            $property['Types'] = $typeModel
                ->where('property_id', $property['id'])
                ->findAll();
        }
        unset($property); // clean reference

        $data = [
            'title'             => 'Dashboard',
            'breadcrumb'        => [['label' => 'Dashboard']],
            'username'          => $user['name'],
            'foto'              => $user['foto'],
            'totalProperty'     => $this->propertyModel->countAll(),
            'totalUser'         => $this->userModel->countAll(),
            'totalPenjualan'    => $jumlahPenjualan,
            'totalDeveloper'    => $this->developerModel->countAll(),
            'profileIncomplete' => $profileIncomplete,
            'user'              => $user,
            'developers'        => $developers,
            'developerId'       => $developerId,
            'properties'        => $properties,
            'pager'             => $pager,
        ];

        return view('admin/index', $data);
    }
}
