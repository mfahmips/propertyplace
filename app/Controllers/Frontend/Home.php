<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\PropertyImageModel;
use App\Models\PropertyUnitTypeModel;
use App\Models\SettingsModel;
use App\Models\DeveloperModel;

class Home extends BaseController
{
    public function index()
    {
        $propertyModel = new PropertyModel();
        $propertyImageModel = new PropertyImageModel();
        $unitTypeModel = new PropertyUnitTypeModel();
        $settingsModel = new SettingsModel();
        $devModel = new DeveloperModel();

        $featured = $propertyModel->findAll();

        foreach ($featured as &$property) {
            // Ambil gambar ke-2 untuk slider, fallback ke pertama atau default
            $images = $propertyImageModel
                        ->where('property_id', $property['id'])
                        ->orderBy('sort_order', 'ASC')
                        ->findAll();

            if (isset($images[1])) {
                $property['image'] = $images[1]['filename'];
            } elseif (isset($images[0])) {
                $property['image'] = $images[0]['filename'];
            } else {
                $property['image'] = 'default.png';
            }

            // Ambil nama developer
            $developer = $devModel->find($property['developer_id']);
            $property['developer_name'] = $developer ? $developer['name'] : '-';

            // Ambil unit dengan building_area terbesar
            $unit = $unitTypeModel->where('property_id', $property['id'])
                        ->orderBy('building_area', 'DESC')
                        ->first();

            if ($unit) {
                $property['bedroom'] = $unit['bedrooms'];
                $property['bathroom'] = $unit['bathrooms'];
                $property['size'] = $unit['building_area'];
            } else {
                $property['bedroom'] = '-';
                $property['bathroom'] = '-';
                $property['size'] = '-';
            }
        }

        $data['featured']   = $featured;
        $data['properties'] = $featured;

        $data['settings']   = $settingsModel->first();
        $data['developers'] = $devModel->orderBy('name', 'ASC')->findAll();

        return view('frontend/home', $data);
    }

    public function contact()
    {
        return view('frontend/contact');
    }

    public function sendContact()
    {
        $data = $this->request->getPost();

        if (!$data['name'] || !$data['email'] || !$data['message']) {
            return redirect()->back()->with('error', 'Semua field harus diisi.');
        }

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim.');
    }
}
