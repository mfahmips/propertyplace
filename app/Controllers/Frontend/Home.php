<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\PropertyDetailModel;
use App\Models\DeveloperModel;
use App\Models\PropertyTypeModel;

class Home extends BaseController
{
    public function index()
    {
        $developerModel = new DeveloperModel();
        $propertyModel = new PropertyModel();
        $propertyDetailModel = new PropertyDetailModel();

        $developers = $developerModel->findAll();

        $properties = $propertyModel
            ->select('properties.*, property_details.price_text, property_details.location')
            ->join('property_details', 'property_details.property_id = properties.id', 'left')
            ->orderBy('properties.created_at', 'DESC')
            ->findAll();

        return view('frontend/home', [
            'developers' => $developers,
            'properties' => $properties,
            'active_developer' => '',
            'active_keyword' => ''
        ]);
    }

    public function developer($slug)
    {
        $developerModel = new DeveloperModel();
        $propertyModel = new PropertyModel();

        $developer = $developerModel->where('slug', $slug)->first();
        if (!$developer) {
            return view('errors/html/error_404', ['message' => 'Developer tidak ditemukan']);
        }

        $properties = $propertyModel
            ->select('
                properties.id,
                properties.title,
                properties.slug,
                properties.thumbnail,
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

    public function getPropertiesByDeveloper($slug)
{
    $propertyModel = new \App\Models\PropertyModel();
    $propertyDetailModel = new \App\Models\PropertyDetailModel();
    $developerModel = new \App\Models\DeveloperModel();

    $developer = $developerModel->where('slug', $slug)->first();

    if (!$developer) {
        log_message('debug', '❌ Developer tidak ditemukan: ' . $slug);
        return $this->response->setJSON(['error' => 'Developer not found']);
    }

    // Tes apakah developer ditemukan
    log_message('debug', '✅ Developer ditemukan: ' . json_encode($developer));

    // Jalankan query properti
    $properties = $propertyModel
        ->select('properties.id, properties.title, properties.slug, properties.thumbnail, property_details.price_text')
        ->join('property_details', 'property_details.property_id = properties.id', 'left')
        ->where('properties.developer_id', $developer['id'])
        ->orderBy('properties.id', 'DESC')
        ->findAll();

    // Log hasil
    log_message('debug', '📦 Properties ditemukan: ' . count($properties));
    log_message('debug', '🧩 Data: ' . json_encode($properties));

    return $this->response->setJSON($properties);
}

public function property($slug)
{
    $propertyModel = new \App\Models\PropertyModel();
    $developerModel = new \App\Models\DeveloperModel();

    // 🔹 Ambil data properti utama
    $property = $propertyModel
        ->select("
            properties.*,
            developers.name AS developer_name,
            developers.slug AS developer_slug,
            developers.logo AS developer_logo,
            property_details.price,
            property_details.price_text,
            property_details.location,
            property_details.type,
            property_details.purpose,
            property_details.description,
            pt.max_floors AS floors,
            pt.max_land_area AS land_area,
            pt.max_building_area AS building_area,
            pt.max_bedrooms AS bedrooms,
            pt.max_bathrooms AS bathrooms,
            pt.max_carport AS carport
        ")
        ->join('developers', 'developers.id = properties.developer_id', 'left')
        ->join('property_details', 'property_details.property_id = properties.id', 'left')
        ->join('(
            SELECT 
                property_id,
                MAX(floors) AS max_floors,
                MAX(land_area) AS max_land_area,
                MAX(building_area) AS max_building_area,
                MAX(bedrooms) AS max_bedrooms,
                MAX(bathrooms) AS max_bathrooms,
                MAX(carport) AS max_carport
            FROM property_type
            GROUP BY property_id
        ) AS pt', 'pt.property_id = properties.id', 'left')
        ->where('properties.slug', $slug)
        ->first();

    if (!$property) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Properti tidak ditemukan');
    }

    // 🔹 Ambil developer yang sama
    $developer = $developerModel->find($property['developer_id']);

    // 🔹 Ambil properti lain milik developer yang sama
    $relatedProperties = $propertyModel
        ->select("
            properties.id,
            properties.title,
            properties.slug,
            properties.thumbnail,
            property_details.price_text,
            property_details.location,
            pt.max_bedrooms AS bedrooms,
            pt.max_bathrooms AS bathrooms,
            pt.max_land_area AS land_area
        ")
        ->join('property_details', 'property_details.property_id = properties.id', 'left')
        ->join('(
            SELECT 
                property_id,
                MAX(bedrooms) AS max_bedrooms,
                MAX(bathrooms) AS max_bathrooms,
                MAX(land_area) AS max_land_area
            FROM property_type
            GROUP BY property_id
        ) AS pt', 'pt.property_id = properties.id', 'left')
        ->where('properties.developer_id', $property['developer_id'])
        ->where('properties.slug !=', $slug)
        ->orderBy('properties.id', 'DESC')
        ->findAll();

    $developers = $developerModel->findAll();

    return view('frontend/property/detail', [
        'property' => $property,
        'relatedProperties' => $relatedProperties,
        'title' => $property['title'] . ' | ' . ($property['developer_name'] ?? 'PropertyPlace'),
        'developers' => $developers
    ]);
}



}
