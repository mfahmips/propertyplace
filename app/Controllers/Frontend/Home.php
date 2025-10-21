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

        // === Ambil filter dari form (GET request) ===
        $propertyId  = $this->request->getGet('property');
        $developerId = $this->request->getGet('developer');
        $location    = $this->request->getGet('location');

        // === Redirect otomatis ke /property/slug jika property dipilih ===
        if (!empty($propertyId)) {
            $property = $propertyModel->select('slug')->find($propertyId);
            if ($property && !empty($property['slug'])) {
                return redirect()->to(base_url('property/' . $property['slug']));
            }
        }

        // === Query dasar ===
        $propertyModel->select('properties.*');

        if (!empty($developerId)) {
            $propertyModel->where('developer_id', $developerId);
        }

        if (!empty($location)) {
            $propertyModel->join('property_details', 'property_details.property_id = properties.id', 'left');
            $propertyModel->where('property_details.location', $location);
        }

        $featured = $propertyModel->findAll();

        // === Format setiap properti ===
        foreach ($featured as &$property) {
            $images = $propertyImageModel
                ->where('property_id', $property['id'])
                ->orderBy('sort_order', 'ASC')
                ->findAll();

            $property['image'] = $images[1]['filename']
                ?? $images[0]['filename']
                ?? 'default.png';

            $developer = $developerModel->find($property['developer_id']);
            $property['developer_name'] = $developer['name'] ?? '-';

            $unit = $propertyTypeModel
                ->where('property_id', $property['id'])
                ->orderBy('building_area', 'DESC')
                ->first();

            $property['bedroom']  = $unit['bedrooms']  ?? '-';
            $property['bathroom'] = $unit['bathrooms'] ?? '-';
            $property['size']     = $unit['building_area'] ?? '-';

            $detail = $propertyDetailModel
                ->where('property_id', $property['id'])
                ->first();

            $property['description'] = $detail['description'] ?? 'Deskripsi belum tersedia';
            $property['price_text']  = $detail['price_text'] ?? 'Harga tidak tersedia';
            $property['price']       = $detail['price'] ?? 0;
            $property['location']    = $detail['location'] ?? '-';
        }

        // === Dropdown Data ===
        $developers = $developerModel
            ->select('id, name')
            ->orderBy('name', 'ASC')
            ->findAll();

        $properties = $propertyModel
            ->select('id, title, slug')
            ->orderBy('title', 'ASC')
            ->findAll();

        $locations = $propertyDetailModel
            ->select('DISTINCT(location)')
            ->where('location !=', '')
            ->orderBy('location', 'ASC')
            ->findAll();

        // === Data untuk View ===
        $data = [
            'featured'          => $featured,
            'properties'        => $properties,
            'settings'          => $settingsModel->first(),
            'developers'        => $developers,
            'locations'         => $locations,
            'filter_property'   => $propertyId,
            'filter_developer'  => $developerId,
            'filter_location'   => $location,
        ];

        return view('frontend/home', $data);
    }
}
