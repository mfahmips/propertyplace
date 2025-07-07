<?php

namespace App\Controllers\Frontend;
use App\Controllers\BaseController;
use App\Models\PropertyModel;

class Property extends BaseController
{
    public function index()
    {
        $model = new PropertyModel();
        $data['properties'] = $model->findAll();

        return view('frontend/layouts/header')
            . view('frontend/property_list', $data)
            . view('frontend/layouts/footer');
    }

    public function detail($slug)
    {
        $model = new PropertyModel();
        $data['property'] = $model->where('slug', $slug)->first();

        if (!$data['property']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('frontend/layouts/header')
            . view('frontend/property_detail', $data)
            . view('frontend/layouts/footer');
    }
}
