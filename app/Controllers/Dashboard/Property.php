<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\PropertyImageModel;
use App\Models\DeveloperModel;
use App\Models\PropertyTypeImagesModel;
use App\Models\PropertyTypeModel;
use App\Models\PropertyDetailModel;
use App\Models\PropertyDocumentModel;

class Property extends BaseController
{
    protected $propertyModel;

    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
        helper(['number', 'my_helper']);
    }

    /**
     * =====================================================
     * PROPERTY LIST (GLOBAL — untuk Admin / Sales)
     * =====================================================
     */
    public function index()
    {
        $perPage     = 8;
        $search      = $this->request->getGet('search');
        $developerId = $this->request->getGet('developer_id');
        $city        = $this->request->getGet('city');

        // Base query property + join
        $propertyQuery = $this->propertyModel
            ->select('
                properties.*,
                developers.name AS developer_name,
                property_details.location,
                property_details.price,
                property_details.price_text,
                property_details.description
            ')
            ->join('developers', 'developers.id = properties.developer_id')
            ->join('property_details', 'property_details.property_id = properties.id', 'left')
            ->orderBy('properties.title', 'ASC');

        // Filter pencarian
        if (!empty($search)) {
            $propertyQuery->like('properties.title', $search);
        }

        if (!empty($developerId)) {
            $propertyQuery->where('properties.developer_id', $developerId);
        }

        if (!empty($city)) {
            $propertyQuery->like('property_details.location', $city);
        }

        // Pagination
        $properties = $propertyQuery->paginate($perPage, 'property');
        $pager = $this->propertyModel->pager;

        // Load model tambahan
        $typeModel = new PropertyTypeModel();
        $typeImageModel = new PropertyTypeImagesModel();

        // Tambahkan data type dan thumbnail ke setiap properti
        foreach ($properties as &$p) {
            // Thumbnail
            $p['thumbnail_url'] = !empty($p['thumbnail'])
                ? base_url('uploads/property/thumbnail/' . $p['thumbnail'])
                : base_url('images/placeholder-80x60.png');

            // Ambil semua type untuk properti
            $types = $typeModel
                ->where('property_id', $p['id'])
                ->select('id, name, slug, type_unit')
                ->findAll();

            // Tambahkan gambar untuk setiap type
            foreach ($types as &$type) {
                $type['images'] = $typeImageModel
                    ->where('property_id', $p['id'])
                    ->where('type_id', $type['id'])
                    ->findAll();
            }

            $p['Types'] = $types;
        }

        // Developer dropdown untuk filter
        $developerModel = new DeveloperModel();
        $developers = $developerModel->findAll();

        return view('admin/property/index', [
            'title'           => 'Property Listing',
            'breadcrumb'      => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property'],
            ],
            'properties'      => $properties,
            'pager'           => $pager,
            'developers'      => $developers,
            'search'          => $search,
            'developerId'     => $developerId,
            'city'            => $city,
            'filterDeveloper' => !empty($developerId) ? $developerModel->find($developerId) : null,
        ]);
    }
}
