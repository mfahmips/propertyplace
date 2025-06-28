<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class Index extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'breadcrumb' => [
                ['label' => 'Dashboard']
            ],
        ];

        return view('admin/index', $data);
    }
}
