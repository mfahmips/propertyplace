<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\SettingsModel;

class About extends BaseController
{
    public function index()
    {
        $settingsModel = new SettingsModel();
        $settings = $settingsModel->first();

        return view('frontend/about', [
            'settings' => $settings
        ]);
    }
}
