<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\SettingsModel;

class Home extends BaseController
{
    public function index()
    {
        $propertyModel = new PropertyModel();
        $settingsModel = new SettingsModel();

        $data['featured'] = $propertyModel->findAll();
        $data['settings'] = $settingsModel->first(); // Ambil baris pertama

        return view('frontend/home', $data);
    }
}
