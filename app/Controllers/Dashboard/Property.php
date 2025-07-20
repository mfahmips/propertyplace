<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\PropertyImageModel;
use App\Models\DeveloperModel;
use App\Models\PropertyFloorPlanModel;
use App\Models\PropertyUnitTypeModel;
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

    public function index()
    {
        $perPage = 5;
        $properties = $this->propertyModel
            ->select('properties.*, developers.name as developer_name')
            ->join('developers', 'developers.id = properties.developer_id')
            ->paginate($perPage);

        $pager = $this->propertyModel->pager;
        $imageModel = new PropertyImageModel();
        $unitModel  = new PropertyUnitTypeModel();

        foreach ($properties as &$p) {
            $img = $imageModel->where('property_id', $p['id'])->first();
            $p['thumbnail'] = $img ? base_url('uploads/property/' . $img['filename']) : base_url('images/placeholder-80x60.png');
            $p['units'] = $unitModel->where('property_id', $p['id'])->findAll();
        }

        return view('admin/property/index', [
            'title' => 'Property Listing',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property']
            ],
            'properties' => $properties,
            'pager' => $pager,
        ]);
    }

    public function byDeveloper(string $slug)
    {
        $developer = (new DeveloperModel())->where('slug', $slug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        $perPage = 5;

        $properties = $this->propertyModel
            ->where('developer_id', $developer['id'])
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        $pager = $this->propertyModel->pager;
        $imageModel = new PropertyImageModel();
        $unitModel = new PropertyUnitTypeModel();

        foreach ($properties as &$p) {
            // Ambil semua gambar beserta id & filename untuk keperluan delete
            $imgs = $imageModel->where('property_id', $p['id'])->findAll();

            $p['images'] = $imgs;

            // Set thumbnail (gambar pertama) atau placeholder jika tidak ada
            $p['thumbnail'] = isset($imgs[0])
                ? base_url('uploads/property/' . $imgs[0]['filename'])
                : base_url('images/placeholder-80x60.png');

            // Ambil unit
            $p['units'] = $unitModel->where('property_id', $p['id'])->findAll();
        }

        return view('admin/property/index', [
            'title' => 'Properties by ' . $developer['name'],
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Developer', 'url' => base_url('dashboard/developer')],
                ['label' => $developer['name']]
            ],
            'properties' => $properties,
            'pager' => $pager,
            'filterDeveloper' => $developer,
        ]);
    }


    public function storeByDeveloper(string $devSlug)
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'price' => 'required|numeric',
            'price_text' => 'required|string|max_length[100]',
            'location' => 'required|in_list[Jabodetabek,Bekasi,Depok,Bogor,Tangerang,Jakarta]',
            'description' => 'required',
            'images' => 'permit_empty|is_image[images.*]|mime_in[images.*,image/jpg,image/jpeg,image/png,image/webp]|max_size[images.*,2048]|max_files[images,10]'
        ];

        if (!$this->validate($rules)) return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        if (!$developer) throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');

        $title = $this->request->getPost('title');
        $slug = generateUniqueSlug($title, $this->propertyModel);

        $this->propertyModel->insert([
            'title' => $title,
            'slug' => $slug,
            'developer_id' => $developer['id'],
            'price' => $this->request->getPost('price'),
            'price_text' => $this->request->getPost('price_text'),
            'location' => $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
        ]);

        $propertyId = $this->propertyModel->getInsertID();

        $files = $this->request->getFileMultiple('images');
        $imgModel = new PropertyImageModel();
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH.'uploads/property/', $newName);
                $imgModel->insert([
                    'property_id' => $propertyId,
                    'filename' => $newName,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect()->to(base_url("dashboard/developer/{$devSlug}/property"))->with('success', 'Property added successfully.');
    }

    public function updateByDeveloper(string $devSlug, string $propSlug)
    {
        helper('text'); // pastikan helper slug/text aktif

        $rules = [
            'title' => 'required|min_length[3]',
            'price' => 'required|numeric',
            'price_text' => 'required|string|max_length[100]',
            'location' => 'required|in_list[Jabodetabek,Bekasi,Depok,Bogor,Tangerang,Jakarta]',
            'description' => 'required',
            'images' => 'permit_empty|is_image[images.*]|mime_in[images.*,image/jpg,image/jpeg,image/png,image/webp]|max_size[images.*,2048]|max_files[images,10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        $property = $this->propertyModel
            ->where('slug', $propSlug)
            ->where('developer_id', $developer['id'])
            ->first();

        if (!$property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found or unauthorized');
        }

        $newTitle = $this->request->getPost('title');
        $slug = ($newTitle !== $property['title'])
            ? generateUniqueSlug($newTitle, $this->propertyModel)
            : $property['slug'];

        $updateData = [
            'title' => $newTitle,
            'slug' => $slug,
            'price' => $this->request->getPost('price'),
            'price_text' => $this->request->getPost('price_text'),
            'location' => $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
        ];

        $this->propertyModel->update($property['id'], $updateData);

        // Handle upload gambar tambahan
        $files = $this->request->getFileMultiple('images');
        $imgModel = new PropertyImageModel();

        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/property/', $newName);

                $imgModel->insert([
                    'property_id' => $property['id'],
                    'filename' => $newName,
                    'sort_order' => 0
                ]);
            }
        }

        return redirect()->to(base_url("dashboard/developer/{$devSlug}/property"))
                         ->with('success', 'Property updated successfully.');
    }


    public function deleteByDeveloper($devSlug, $id)
    {
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        $property = $this->propertyModel->find($id);

        if (!$property || $property['developer_id'] != $developer['id']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found or unauthorized');
        }

        // Hapus gambar fisik jika ada
        $imageModel = new \App\Models\PropertyImageModel();
        $images = $imageModel->where('property_id', $property['id'])->findAll();

        foreach ($images as $img) {
            $path = FCPATH . 'uploads/property/' . $img['filename'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Hapus gambar dari DB
        $imageModel->where('property_id', $property['id'])->delete();

        // Hapus property
        $this->propertyModel->delete($id);

        return redirect()->to(base_url("dashboard/developer/{$devSlug}/property"))
                         ->with('success', 'Property deleted successfully.');
    }


    public function deleteImageByDeveloper($devSlug, $imageId)
    {
        $imageModel = new \App\Models\PropertyImageModel();
        $image = $imageModel->find($imageId);

        if (!$image) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Image not found');
        }

        $property = $this->propertyModel->find($image['property_id']);
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();

        if (!$developer || !$property || $property['developer_id'] != $developer['id']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Unauthorized access');
        }

        $path = FCPATH . 'uploads/property/' . $image['filename'];
        if (file_exists($path)) {
            unlink($path);
        }

        $imageModel->delete($imageId);

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }




    public function detailByDeveloper($devSlug, $propSlug)
    {
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        $property = $this->propertyModel->where('slug', $propSlug)->first();

        if (!$property || !$developer || $property['developer_id'] != $developer['id']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Unauthorized access');
        }

        $unitModel = new PropertyUnitTypeModel();
        $documentModel = new PropertyDocumentModel();
        $floorplanModel = new PropertyFloorPlanModel();
        $detailModel = new PropertyDetailModel();

        $units = $unitModel->where('property_id', $property['id'])->findAll();
        $documents = $documentModel->where('property_id', $property['id'])->findAll();
        $floorplans = $floorplanModel->where('property_id', $property['id'])->findAll();
        $detail = $detailModel->where('property_id', $property['id'])->first();

        // ⬇️ Tambahkan ini agar tiap unit punya data floor plan
        foreach ($units as &$unit) {
            $unit['floor_plan'] = null;
            foreach ($floorplans as $fp) {
                if ($fp['unit_id'] == $unit['id']) {
                    $unit['floor_plan'] = $fp;
                    break;
                }
            }
        }

        return view('admin/property/detail/index', [
            'title' => 'Detail Property: ' . $property['title'],
            'property' => $property,
            'units' => $units, // ⬅️ Sekarang tiap unit sudah bawa floor plan
            'documents' => $documents,
            'floorplans' => $floorplans, // Jika masih mau kirim semua floor plan global
            'detail' => $detail,
            'filterDeveloper' => $developer,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Developer', 'url' => base_url('dashboard/developer')],
                ['label' => 'Property', 'url' => base_url('dashboard/developer/' . $devSlug . '/property')],
                ['label' => 'Detail']
            ]
        ]);
    }



    public function saveUnitByDeveloper($devSlug, $propSlug)
    {
        $devModel = new DeveloperModel();
        $propModel = new PropertyModel();
        $unitModel = new PropertyUnitTypeModel();

        // Validasi developer
        $developer = $devModel->where('slug', $devSlug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer tidak ditemukan');
        }

        // Validasi property milik developer ini
        $property = $propModel->where('slug', $propSlug)
                              ->where('developer_id', $developer['id'])
                              ->first();
        if (!$property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property tidak ditemukan');
        }

        // Ambil data dari form
        $data = $this->request->getPost([
            'id', 'name_unit', 'slug', 'type_unit', 'floors',
            'land_area', 'building_area', 'bedrooms', 'bathrooms', 'carport', 'elevator'
        ]);

        $data['property_id'] = $property['id'];

        // Auto generate slug jika kosong
        if (empty($data['slug'])) {
            helper('text');
            $data['slug'] = url_title($data['name_unit'], '-', true);
        }

        if (!empty($data['id'])) {
            // Edit Unit
            $unit = $unitModel->where('id', $data['id'])
                              ->where('property_id', $property['id'])
                              ->first();

            if (!$unit) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Unit tidak ditemukan atau bukan milik property ini');
            }

            $unitModel->update($data['id'], $data);
            $msg = 'Unit berhasil diupdate.';
        } else {
            // Tambah Unit
            $unitModel->insert($data);
            $msg = 'Unit berhasil ditambahkan.';
        }

        return redirect()->back()->with('success', $msg);
    }


    public function deleteUnitByDeveloper($devSlug, $propSlug, $id)
    {
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        $property = $this->propertyModel->where('slug', $propSlug)->first();

        if (!$property || !$developer || $property['developer_id'] != $developer['id']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Unauthorized access');
        }

        $unitModel = new PropertyUnitTypeModel();
        $floorPlanModel = new PropertyFloorPlanModel();

        // Cari floorplan yang terkait dengan unit ini
        $floorPlans = $floorPlanModel->where('unit_id', $id)->findAll();

        // Hapus file gambar floor plan jika ada
        foreach ($floorPlans as $fp) {
            $path = FCPATH . 'uploads/property/floorplan/' . $fp['image'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        // Hapus floor plan di database
        $floorPlanModel->where('unit_id', $id)->delete();

        // Hapus unit
        $unitModel->delete($id);

        return redirect()->back()->with('success', 'Unit dan floor plan terkait berhasil dihapus.');
    }





    public function storeDocumentByDeveloper($devSlug, $propSlug)
    {
        $property = $this->propertyModel->where('slug', $propSlug)->first();
        $rules = [
            'title' => 'required|min_length[3]',
            'type' => 'required|in_list[pdf,video]',
            'video_url' => 'permit_empty|valid_url',
            'file' => 'permit_empty|uploaded[file]|max_size[file,2048]|ext_in[file,pdf]'
        ];

        if (!$this->validate($rules)) return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

        $docModel = new PropertyDocumentModel();
        $data = [
            'property_id' => $property['id'],
            'title' => $this->request->getPost('title'),
            'type' => $this->request->getPost('type'),
        ];

        if ($data['type'] === 'pdf') {
            $file = $this->request->getFile('file');
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/property/documents/', $newName);
            $data['file_path'] = $newName;
        } else {
            $data['video_url'] = $this->request->getPost('video_url');
        }

        $docModel->insert($data);
        return redirect()->back()->with('success', 'Document berhasil ditambahkan.');
    }

    public function deleteDocumentByDeveloper($devSlug, $propSlug, $id)
    {
        $docModel = new PropertyDocumentModel();
        $document = $docModel->find($id);

        if ($document['type'] === 'pdf' && !empty($document['file_path'])) {
            $path = FCPATH . 'uploads/property/documents/' . $document['file_path'];
            if (file_exists($path)) unlink($path);
        }

        $docModel->delete($id);
        return redirect()->back()->with('success', 'Document berhasil dihapus.');
    }

    public function storeFloorPlanByDeveloper($devSlug, $propSlug)
    {
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        $property = $this->propertyModel->where('slug', $propSlug)
                                        ->where('developer_id', $developer['id'])
                                        ->first();

        $rules = [
            'name' => 'required|min_length[3]',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/property/floorplan/', $newName);

        $floorPlanModel = new PropertyFloorPlanModel();
        $floorPlanModel->insert([
            'property_id' => $property['id'],
            'unit_id' => $this->request->getPost('unit_id'), // Tambahkan ini
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'image' => $newName
        ]);

        return redirect()->back()->with('success', 'Floor plan berhasil ditambahkan.');
    }



    public function deleteFloorPlanByDeveloper($devSlug, $propSlug, $id)
    {
        $planModel = new PropertyFloorPlanModel();
        $plan = $planModel->find($id);

        $path = FCPATH . 'uploads/property/floorplan/' . $plan['image'];
        if (file_exists($path)) unlink($path);

        $planModel->delete($id);
        return redirect()->back()->with('success', 'Floor plan berhasil dihapus.');
    }
}
