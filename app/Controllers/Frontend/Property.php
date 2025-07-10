<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\DeveloperModel;

class Property extends BaseController
{
    public function index()
    {
        $propertyModel = new PropertyModel();
        $developerModel = new DeveloperModel();

        // Ambil filter dari query string
        $developer = $this->request->getGet('developer');
        $location = $this->request->getGet('location');

        // Query builder
        $builder = $propertyModel;

        if ($developer) {
            $builder->where('developer_id', $developer);
        }

        if ($location) {
            $builder->like('location', $location);
        }

        $data['properties'] = $propertyModel->withDeveloper()->findAll();
        $data['developers'] = $developerModel->findAll();
        $data['active_developer'] = $developer;
        $data['active_location'] = $location;

        return view('frontend/property/index', $data);
    }

    public function detail($slug)
    {
        $propertyModel = new \App\Models\PropertyModel();
        $imageModel = new \App\Models\PropertyImageModel();

        $property = $propertyModel->where('slug', $slug)->first();
        if (!$property) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Properti tidak ditemukan.");
        }

        $images = $imageModel->where('property_id', $property['id'])->findAll();

        return view('frontend/property/detail', [
            'property' => $property,
            'images' => $images
        ]);
    }


}
