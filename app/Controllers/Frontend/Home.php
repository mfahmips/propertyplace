<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\PropertyImageModel;
use App\Models\PropertyTypeModel;
use App\Models\SettingsModel;
use App\Models\DeveloperModel;
use App\Models\PropertyDetailModel;

class Home extends BaseController
{
    public function index()
    {
        $propertyModel       = new PropertyModel();
        $propertyImageModel  = new PropertyImageModel();
        $propertyTypeModel   = new PropertyTypeModel();
        $propertyDetailModel = new PropertyDetailModel();
        $settingsModel       = new SettingsModel();
        $developerModel      = new DeveloperModel();

        $featured = $propertyModel->findAll();

        foreach ($featured as &$property) {
            // Gambar slider: ke-2 jika ada, fallback ke pertama, lalu default
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

            // Nama developer
            $developer = $developerModel->find($property['developer_id']);
            $property['developer_name'] = $developer ? $developer['name'] : '-';

            // Unit dengan building_area terbesar
            $unit = $propertyTypeModel
                        ->where('property_id', $property['id'])
                        ->orderBy('building_area', 'DESC')
                        ->first();

            $property['bedroom']  = $unit['bedrooms']  ?? '-';
            $property['bathroom'] = $unit['bathrooms'] ?? '-';
            $property['size']     = $unit['building_area'] ?? '-';

            // Detail: price, price_text, location, description
            $detail = $propertyDetailModel
                        ->where('property_id', $property['id'])
                        ->first();

            $property['description'] = $detail['description'] ?? 'Deskripsi belum tersedia';
            $property['price_text']  = $detail['price_text'] ?? 'Harga tidak tersedia';
            $property['price']       = $detail['price'] ?? 0;
        }

        $data = [
            'featured'   => $featured,
            'properties' => $featured,
            'settings'   => $settingsModel->first(),
            'developers' => $developerModel->orderBy('name', 'ASC')->findAll(),
        ];

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
