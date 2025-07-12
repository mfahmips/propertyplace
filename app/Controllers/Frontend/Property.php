<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\DeveloperModel;

class Property extends BaseController
{
   public function index()
    {
        $request = \Config\Services::request();
        $keyword = $request->getGet('keyword');
        $city = $request->getGet('city');
        $developer = $request->getGet('developer');

        $propertyModel = new \App\Models\PropertyModel();
        $builder = $propertyModel->select('properties.slug as property_slug, properties.*, developers.name as developer_name, developers.slug as developer_slug')
                         ->join('developers', 'developers.id = properties.developer_id');


        if ($keyword) {
            $builder = $builder->groupStart()
                ->like('properties.title', $keyword)
                ->orLike('properties.description', $keyword)
                ->groupEnd();
        }

        if ($city) {
            $builder = $builder->where('developers.location', $city);
        }

        if ($developer) {
            $builder = $builder->where('properties.developer_id', $developer);
        }

        $data['properties'] = $builder->findAll();

        $data['active_keyword'] = $keyword ?? '';
        $data['active_city'] = $city ?? '';
        $data['active_developer'] = $developer ?? '';

        $data['cities'] = (new DeveloperModel())->distinct()->select('location')->orderBy('location')->findColumn('location');
        $data['developers'] = (new DeveloperModel())->findAll();

        return view('frontend/property/index', $data);
    }


    public function detail($slug)
    {
        $propertyModel   = new \App\Models\PropertyModel();
        $imageModel      = new \App\Models\PropertyImageModel();
        $developerModel  = new \App\Models\DeveloperModel();

        // Cari property berdasarkan slug
        $property = $propertyModel->where('slug', $slug)->first();

        if (! $property) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Properti tidak ditemukan.");
        }

        // Ambil developer dari relasi
        $developer = $developerModel->find($property['developer_id']);

        // Ambil semua gambar
        $images = $imageModel->where('property_id', $property['id'])->findAll();

        // Kirim data ke view
        return view('frontend/property/detail', [
            'property'  => $property,
            'images'    => $images,
            'developer' => $developer
        ]);
    }



}
