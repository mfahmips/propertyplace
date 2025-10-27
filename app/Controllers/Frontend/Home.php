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
        $propertyId   = $this->request->getGet('property');
        $developerKey = $this->request->getGet('developer'); // bisa slug atau id tergantung input
        $location     = $this->request->getGet('location');

        // === Redirect otomatis ke /property/slug jika property dipilih ===
        if (!empty($propertyId)) {
            $property = $propertyModel->select('slug')->find($propertyId);
            if ($property && !empty($property['slug'])) {
                return redirect()->to(base_url('property/' . $property['slug']));
            }
        }

        // === Query dasar ===
        $propertyModel->select('properties.*');

        // 🔹 Filter developer (bisa id atau slug)
        if (!empty($developerKey)) {
            // Cek apakah input adalah slug
            $developer = $developerModel
                ->select('id')
                ->groupStart()
                    ->where('id', $developerKey)
                    ->orWhere('slug', $developerKey)
                ->groupEnd()
                ->first();

            if ($developer) {
                $propertyModel->where('developer_id', $developer['id']);
            }
        }

        // 🔹 Filter lokasi (optional)
        if (!empty($location)) {
            $propertyModel
                ->join('property_details', 'property_details.property_id = properties.id', 'left')
                ->where('property_details.location', $location);
        }

        $featured = $propertyModel->findAll();

        // === Format setiap properti ===
        foreach ($featured as &$property) {
            // Ambil gambar properti
            $images = $propertyImageModel
                ->where('property_id', $property['id'])
                ->orderBy('sort_order', 'ASC')
                ->findAll();

            $property['image'] = $images[1]['filename']
                ?? $images[0]['filename']
                ?? 'default.png';

            // Ambil nama developer
            $developer = $developerModel->find($property['developer_id']);
            $property['developer_name'] = $developer['name'] ?? '-';

            // Ambil unit (type)
            $unit = $propertyTypeModel
                ->where('property_id', $property['id'])
                ->orderBy('building_area', 'DESC')
                ->first();

            $property['bedroom']  = $unit['bedrooms']  ?? '-';
            $property['bathroom'] = $unit['bathrooms'] ?? '-';
            $property['size']     = $unit['building_area'] ?? '-';

            // Ambil detail properti
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
            ->select('id, name, slug') // 🟢 tambahkan slug agar tidak undefined
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
            'filter_developer'  => $developerKey,
            'filter_location'   => $location,
        ];

        return view('frontend/home', $data);
    }

public function developer($slug)
{
    $developerModel = new \App\Models\DeveloperModel();
    $propertyModel  = new \App\Models\PropertyModel();

    // Ambil developer berdasarkan slug
    $developer = $developerModel->where('slug', $slug)->first();
    if (!$developer) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Developer tidak ditemukan');
    }

    // JOIN ke tabel detail dan tipe
    $properties = $propertyModel
        ->select('
            properties.id,
            properties.title,
            properties.slug,
            properties.thumbnail,
            property_details.price,
            property_details.price_text,
            property_details.location,
            property_details.type,
            property_details.purpose,
            property_type.floors,
            property_type.land_area,
            property_type.building_area,
            property_type.bedrooms,
            property_type.bathrooms
        ')
        ->join('property_details', 'property_details.property_id = properties.id', 'left')
        ->join('property_type', 'property_type.property_id = properties.id', 'left')
        ->where('properties.developer_id', $developer['id'])
        ->orderBy('properties.created_at', 'DESC')
        ->findAll();

    return view('frontend/developer', [
        'developer'  => $developer,
        'properties' => $properties,
        'title'      => $developer['name'] . ' Properties | PropertyPlace'
    ]);
}




}
