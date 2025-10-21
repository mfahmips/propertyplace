<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\DeveloperModel;
use App\Models\PropertyImageModel;
use App\Models\PropertyDetailModel;
use App\Models\PropertyTypeModel;

class Property extends BaseController
{
    public function index()
    {
        $request = \Config\Services::request();

        // Ambil parameter GET
        $keyword   = $request->getGet('keyword');
        $city      = $request->getGet('city');
        $developer = $request->getGet('developer');

        $propertyModel = new PropertyModel();

        // === Query dasar ===
        $builder = $propertyModel
            ->select('
                properties.id,
                properties.title,
                properties.slug AS property_slug,
                developers.name AS developer_name,
                developers.slug AS developer_slug,
                property_details.location,
                property_details.price,
                property_details.price_text
            ')
            ->join('developers', 'developers.id = properties.developer_id', 'left')
            ->join('property_details', 'property_details.property_id = properties.id', 'left');

        // === Filter pencarian ===
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('properties.title', $keyword)
                ->orLike('property_details.location', $keyword)
                ->groupEnd();
        }

        if (!empty($city)) {
            $builder->where('property_details.location', $city);
        }

        if (!empty($developer)) {
            $builder->where('properties.developer_id', $developer);
        }

        // === Ambil hasil ===
        $properties = $builder->orderBy('properties.title', 'ASC')->findAll();

        // === Lengkapi data gambar utama ===
        $imageModel = new PropertyImageModel();
        foreach ($properties as &$property) {
            $image = $imageModel
                ->where('property_id', $property['id'])
                ->orderBy('sort_order', 'ASC')
                ->first();

            $property['image'] = $image['filename'] ?? 'default.png';
        }

        // === Data dropdown untuk filter ===
        $propertyDetailModel = new PropertyDetailModel();
        $developerModel = new DeveloperModel();

        $data = [
            'properties'       => $properties,
            'active_keyword'   => $keyword ?? '',
            'active_city'      => $city ?? '',
            'active_developer' => $developer ?? '',
            'cities'           => $propertyDetailModel->distinct()->select('location')->orderBy('location', 'ASC')->findColumn('location'),
            'developers'       => $developerModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('frontend/property/index', $data);
    }

    public function detail($slug)
    {
        $propertyModel   = new PropertyModel();
        $imageModel      = new PropertyImageModel();
        $developerModel  = new DeveloperModel();
        $detailModel     = new PropertyDetailModel();
        $typeModel       = new PropertyTypeModel(); // 🟢 Tambahkan model tipe properti

        // Cari properti berdasarkan slug
        $property = $propertyModel
            ->select('
                properties.*,
                developers.name AS developer_name,
                developers.slug AS developer_slug,
                property_details.location,
                property_details.price,
                property_details.price_text,
                property_details.description
            ')
            ->join('developers', 'developers.id = properties.developer_id', 'left')
            ->join('property_details', 'property_details.property_id = properties.id', 'left')
            ->where('properties.slug', $slug)
            ->first();

        if (!$property) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Properti tidak ditemukan.");
        }

        // Ambil semua gambar properti
        $images = $imageModel
            ->where('property_id', $property['id'])
            ->orderBy('sort_order', 'ASC')
            ->findAll();

        // 🟢 Ambil semua tipe unit properti
        $propertyTypes = $typeModel
            ->where('property_id', $property['id'])
            ->orderBy('building_area', 'ASC')
            ->findAll();

        // Kirim data ke view
        return view('frontend/property/detail', [
            'property'  => $property,
            'images'    => $images,
            'types'     => $propertyTypes, // 🟢 kirim data tipe properti
        ]);
    }
}
