<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\PropertyImageModel;
use App\Models\DeveloperModel;
use App\Models\PropertyFloorPlanModel;
use App\Models\PropertyUnitTypeModel;

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

        // Ambil property + developer
        $properties = $this->propertyModel
            ->select('properties.*, developers.name as developer_name')
            ->join('developers', 'developers.id = properties.developer_id')
            ->paginate($perPage);

        $pager = $this->propertyModel->pager;

        // Model tambahan
        $imageModel = new PropertyImageModel();
        $unitModel  = new PropertyUnitTypeModel();

        foreach ($properties as &$p) {
            // Ambil thumbnail
            $img = $imageModel->where('property_id', $p['id'])->first();
            $p['thumbnail'] = $img
                ? base_url('uploads/property/' . $img['filename'])
                : base_url('images/placeholder-80x60.png');

            // Ambil data unit sesuai field tabel Anda
            $p['units'] = $unitModel
                ->select('id, name_unit, slug, type_unit, floors, land_area, building_area, bedrooms, bathrooms, carport, elevator')
                ->where('property_id', $p['id'])
                ->findAll();
        }
        unset($p);

        return view('admin/property/index', [
            'title'      => 'Property Listing',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property'],
            ],
            'properties' => $properties,
            'pager'      => $pager,
        ]);
    }




    public function create()
    {
        $developers = model(DeveloperModel::class)->findAll();

        return view('admin/property/create', [
            'title' => 'Add Property',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property', 'url' => base_url('dashboard/property')],
                ['label' => 'Add Property']
            ],
            'developers' => $developers
        ]);
    }

    public function store()
    {
        $validationRule = [
            'images' => [
                'label' => 'Property Images',
                'rules' => 'permit_empty'
                    . '|is_image[images.*]'
                    . '|mime_in[images.*,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[images.*,2048]'
                    . '|max_files[images,10]',
            ]
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $developerId = $this->request->getPost('developer_id');
        $title       = $this->request->getPost('title');
        $slug        = generateUniqueSlug($title, $this->propertyModel);
        $priceText   = $this->request->getPost('price_text');
        $priceNumber = (int) str_replace(['.', ','], '', $priceText);


        $this->propertyModel->save([
            'title'        => $title,
            'slug'         => $slug,
            'developer_id' => $developerId,
            'price'        => $priceNumber,
            'price_text'   => $priceText,
            'description'  => $this->request->getPost('description'),
        ]);

        $propertyId = $this->propertyModel->getInsertID();

        $files = $this->request->getFileMultiple('images');
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/property/', $newName);

                (new PropertyImageModel())->save([
                    'property_id' => $propertyId,
                    'filename'    => $newName,
                    'created_at'  => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->to('/dashboard/property')->with('success', 'Property added successfully.');
    }

    public function edit($slug)
    {
        $property = $this->propertyModel->where('slug', $slug)->first();

        if (!$property) {
            return redirect()->to('/dashboard/property')->with('errors', ['Property not found.']);
        }

        $images     = (new PropertyImageModel())->where('property_id', $property['id'])->findAll();
        $developers = model(DeveloperModel::class)->findAll();
        $developer  = model(DeveloperModel::class)->find($property['developer_id']);

        return view('admin/property/edit', [
            'title' => 'Edit: ' . $property['title'],
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property', 'url' => base_url('dashboard/property')],
                ['label' => 'Edit Property']
            ],
            'property'       => $property,
            'propertyDetail' => $property,
            'images'         => $images,
            'developers'     => $developers,
            'developer'      => $developer,
        ]);
    }


    public function update($id)
    {
        $validationRule = [
            'images' => [
                'label' => 'Property Images',
                'rules' => 'permit_empty'
                    . '|is_image[images.*]'
                    . '|mime_in[images.*,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[images.*,2048]'
                    . '|max_files[images,10]',
            ]
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existing    = $this->propertyModel->find($id);
        $newTitle    = $this->request->getPost('title');
        $slug        = $existing['slug'];
        $developerId = $this->request->getPost('developer_id');
        $priceText   = $this->request->getPost('price_text');
        $priceNumber = (int) str_replace(['.', ','], '', $priceText);


        if ($newTitle !== $existing['title']) {
            $slug = generateUniqueSlug($newTitle, $this->propertyModel);
        }

        $this->propertyModel->update($id, [
            'title'        => $newTitle,
            'slug'         => $slug,
            'developer_id' => $developerId,
            'price'        => $priceNumber,
            'price_text'   => $priceText,
            'description'  => $this->request->getPost('description'),
        ]);

        $files = $this->request->getFileMultiple('images');
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/property/', $newName);

                (new PropertyImageModel())->save([
                    'property_id' => $id,
                    'filename'    => $newName,
                    'created_at'  => date('Y-m-d H:i:s')
                ]);
            }
        }

        return redirect()->to('/dashboard/property')->with('success', 'Property updated successfully.');
    }
 

    public function byDeveloper(string $slug)
    {
        $devModel  = model(DeveloperModel::class);
        $developer = $devModel->where('slug', $slug)->first();

        if (! $developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        $perPage = 5;

        $builder = $this->propertyModel
            ->where('developer_id', $developer['id'])
            ->orderBy('created_at', 'DESC');

        $properties = $builder->paginate($perPage);
        $pager      = $builder->pager;

        $imageModel = new PropertyImageModel();
        $unitModel  = new PropertyUnitTypeModel();

        foreach ($properties as &$p) {
            $imgs = $imageModel->where('property_id', $p['id'])->findAll();
            $urls = array_map(fn($r) => base_url('uploads/property/' . $r['filename']), $imgs);
            $p['thumbnail'] = $urls[0] ?? base_url('images/placeholder-80x60.png');
            $p['images']    = $urls;
            $p['units']     = $unitModel->where('property_id', $p['id'])->findAll();
        }
        unset($p);

        return view('admin/property/index', [
            'title'           => 'Properties by ' . $developer['name'],
            'breadcrumb'      => [
                ['label'=>'Dashboard', 'url'=>base_url('dashboard')],
                ['label'=>'Developer', 'url'=>base_url('dashboard/developer')],
                ['label'=>$developer['name']],
            ],
            'properties'      => $properties,
            'pager'           => $pager,
            'filterDeveloper' => $developer,
        ]);
    }

    public function createByDeveloper(string $devSlug)
    {
        $devModel   = model(DeveloperModel::class);
        $developer  = $devModel->where('slug', $devSlug)->first();

        if (! $developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        return view('admin/property/create_by_developer', [
            'title'      => 'Add Property for ' . $developer['name'],
            'breadcrumb' => [
                ['label'=>'Dashboard','url'=>base_url('dashboard')],
                ['label'=>'Developer','url'=>base_url('dashboard/developer')],
                ['label'=>'Property', 'url'=>base_url("dashboard/developer/{$devSlug}/property")],
                ['label'=>'Create Property'],
            ],
            'developer'  => $developer,
            'validation' => \Config\Services::validation(),
        ]);
    }

    public function storeByDeveloper(string $devSlug)
    {
        $rules = [
            'title'       => 'required|min_length[3]',
            'price'       => 'required|numeric',
            'price_text'  => 'required|string|max_length[100]',
            'description' => 'required',
        ];


        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $devModel  = model(DeveloperModel::class);
        $developer = $devModel->where('slug', $devSlug)->first();

        $title    = $this->request->getPost('title');
        $slugProp = generateUniqueSlug($title, $this->propertyModel);

        $this->propertyModel->insert([
            'title'        => $title,
            'slug'         => $slugProp,
            'developer_id' => $developer['id'],
            'price'        => $this->request->getPost('price'),
            'price_text'   => $this->request->getPost('price_text'),
            'description'  => $this->request->getPost('description'),
        ]);

        $propertyId = $this->propertyModel->getInsertID();

        $files = $this->request->getFileMultiple('images');
        $imgModel = new PropertyImageModel();
        foreach ($files as $file) {
            if ($file->isValid() && ! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH.'uploads/property/', $newName);
                $imgModel->insert([
                    'property_id'=> $propertyId,
                    'filename'   => $newName,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        return redirect()
                        ->to(base_url("dashboard/developer/{$devSlug}/property"))
                        ->with('success', 'Property added.');
    }

    public function editByDeveloper(string $devSlug, string $propSlug)
    {
        $devModel   = model(DeveloperModel::class);
        $developer  = $devModel->where('slug', $devSlug)->first();

        if (! $developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        $property = $this->propertyModel
            ->where('slug', $propSlug)
            ->where('developer_id', $developer['id'])
            ->first();

        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        $imgModel = new PropertyImageModel();
        $imgs = $imgModel->where('property_id', $property['id'])->orderBy('sort_order', 'ASC')->findAll();

        return view('admin/property/edit_by_developer', [
            'title'         => 'Edit Property: ' . $property['title'],
            'breadcrumb'    => [
                ['label'=>'Dashboard','url'=>base_url('dashboard')],
                ['label'=>'Developer','url'=>base_url('dashboard/developer')],
                ['label'=>'Property', 'url'=>base_url("dashboard/developer/{$devSlug}/property")],
                ['label'=>'Edit Property'],
            ],
            'developer'     => $developer,
            'property'      => $property,
            'images'        => $imgs,
            'validation'    => \Config\Services::validation(),
        ]);
    }

    public function updateByDeveloper(string $devSlug, string $propSlug)
    {
        helper('form');

        // Validasi input text
        $rules = [
            'title'       => 'required|min_length[3]',
            'price'       => 'required|numeric',
            'price_text'  => 'required|string|max_length[100]',
            'description' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('validation', $this->validator);
        }

        // Cek developer
        $devModel  = model(DeveloperModel::class);
        $developer = $devModel->where('slug', $devSlug)->first();
        if (! $developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        // Cek property
        $property = $this->propertyModel
            ->where('slug', $propSlug)
            ->where('developer_id', $developer['id'])
            ->first();
        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        // Update data property
        $this->propertyModel->update($property['id'], [
            'title'       => $this->request->getPost('title'),
            'price'       => $this->request->getPost('price'),
            'price_text'  => $this->request->getPost('price_text'),
            'description' => $this->request->getPost('description'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        // Upload Gambar
        $files = $this->request->getFileMultiple('images');
        $imgModel = new PropertyImageModel();

        if (!empty($files) && is_array($files)) {
            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved() && $file->getClientName() != '') {

                    // Validasi gambar langsung pakai CI built-in
                    $validationRules = [
                        'image' => [
                            'label' => 'Image',
                            'rules' => 'uploaded[image]'
                                . '|is_image[image]'
                                . '|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]'
                                . '|max_size[image,2048]',
                        ]
                    ];

                    // Buat data dummy untuk validator manual
                    $fileArray = ['image' => $file];
                    $validation = \Config\Services::validation();
                    $validation->reset();

                    if (! $validation->setRules($validationRules)->run($fileArray)) {
                        return redirect()->back()
                            ->withInput()
                            ->with('validation', $validation);
                    }

                    // Simpan file
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/property/', $newName);

                    // Simpan ke database
                    $imgModel->insert([
                        'property_id' => $property['id'],
                        'filename'    => $newName,
                        'sort_order'  => 0,
                    ]);
                }
            }
        }

        return redirect()
            ->to(base_url("developer/{$devSlug}/property"))
            ->with('success', 'Property updated successfully.');
    }






    public function delete($id)
    {
        $property = $this->propertyModel->find($id);

        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        $this->propertyModel->delete($id);

        // Ambil redirect slug jika ada
        $redirectSlug = $this->request->getGet('redirect');

        session()->setFlashdata('success', 'Property berhasil dihapus.');

        if ($redirectSlug) {
            return redirect()->to(base_url('dashboard/developer/' . $redirectSlug . '/property'));
        }

        return redirect()->to(base_url('dashboard/property'));
    }


    public function deleteImage($id)
    {
        $imageModel = new PropertyImageModel();
        $image = $imageModel->find($id);

        if ($image) {
            $path = FCPATH . 'uploads/property/' . $image['filename'];
            if (file_exists($path)) {
                unlink($path);
            }
            $imageModel->delete($id);
        }

        return redirect()->back()->with('success', 'Image deleted successfully.');
    }

    public function floorPlan(string $slug)
    {
        $property = $this->propertyModel->where('slug', $slug)->first();
        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        $floorPlanModel = new PropertyFloorPlanModel();
        $floorPlans = $floorPlanModel->where('property_id', $property['id'])->findAll();

        return view('admin/property/floor_plan', [
            'title'      => 'Manage Floor Plan - ' . $property['title'],
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property', 'url' => base_url('dashboard/property')],
                ['label' => $property['title']],
                ['label' => 'Floor Plan']
            ],
            'property'   => $property,
            'floorPlans' => $floorPlans
        ]);
    }


    public function deleteFloorPlan(string $slug, int $id)
    {
        $planModel = new PropertyFloorPlanModel();
        $plan = $planModel->find($id);

        if ($plan) {
            $path = FCPATH . 'uploads/property/floorplan/' . $plan['image'];
            if (file_exists($path)) {
                unlink($path);
            }
            $planModel->delete($id);
        }

        return redirect()->to(base_url("dashboard/property/{$slug}/floorplan"))->with('success', 'Floor plan deleted.');
    }

    public function documents($slug)
    {
        $property = $this->propertyModel->where('slug', $slug)->first();
        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found.');
        }

        $docModel = new \App\Models\PropertyDocumentModel();

        // Ambil semua dokumen property ini
        $documents = $docModel->where('property_id', $property['id'])->findAll();

        // Cek apakah sedang edit dokumen tertentu
        $editId = $this->request->getGet('edit');
        $document = null;
        if ($editId) {
            $document = $docModel->where('id', $editId)
                                 ->where('property_id', $property['id'])
                                 ->first();
        }

        return view('admin/property/documents', [
            'title'      => 'Documents - ' . $property['title'],
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property', 'url' => base_url('dashboard/property')],
                ['label' => $property['title']],
                ['label' => 'Documents']
            ],
            'property'   => $property,
            'documents'  => $documents,
            'document'   => $document // nullable jika tidak sedang edit
        ]);
    }


    public function updateDocument(string $slug, int $id)
    {
        $property = $this->propertyModel->where('slug', $slug)->first();
        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        $docModel = new PropertyDocumentModel();
        $document = $docModel->find($id);
        if (! $document || $document['property_id'] != $property['id']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Document not found');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'type'  => 'required|in_list[pdf,video]',
            'video_url' => 'permit_empty|valid_url',
            'file' => 'permit_empty|max_size[file,2048]|ext_in[file,pdf]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title' => $this->request->getPost('title'),
            'type'  => $this->request->getPost('type'),
        ];

        if ($data['type'] === 'pdf') {
            $file = $this->request->getFile('file');
            if ($file && $file->isValid() && ! $file->hasMoved()) {
                // Delete old file
                if (! empty($document['file_path'])) {
                    $oldPath = FCPATH . 'uploads/property/documents/' . $document['file_path'];
                    if (file_exists($oldPath)) unlink($oldPath);
                }

                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/property/documents/', $newName);
                $data['file_path'] = $newName;
                $data['video_url'] = null;
            }
        } else {
            $data['video_url'] = $this->request->getPost('video_url');
            $data['file_path'] = null;
        }

        $docModel->update($id, $data);

        return redirect()
            ->to(base_url("dashboard/property/{$slug}/documents"))
            ->with('success', 'Document updated successfully.');
    }

    public function deleteDocument(string $slug, int $id)
    {
        $property = $this->propertyModel->where('slug', $slug)->first();
        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        $docModel = new \App\Models\PropertyDocumentModel();
        $document = $docModel->find($id);

        if (! $document || $document['property_id'] != $property['id']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Document not found');
        }

        // Hapus file jika bertipe pdf
        if ($document['type'] === 'pdf' && ! empty($document['file_path'])) {
            $filePath = FCPATH . 'uploads/property/documents/' . $document['file_path'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $docModel->delete($id);

        return redirect()
            ->to(base_url("dashboard/property/{$slug}/documents"))
            ->with('success', 'Document deleted successfully.');
    }

    public function detail($slug)
    {
        $property = model(\App\Models\PropertyModel::class)
            ->where('slug', $slug)
            ->first();

        if (!$property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        // Ambil detail lama (optional)
        $details = model(\App\Models\PropertyDetailModel::class)
            ->where('property_id', $property['id'])
            ->first();

        // Ambil semua unit dari property_unit_type
        $unitModel = model(\App\Models\PropertyUnitTypeModel::class);
        $units = $unitModel
            ->where('property_id', $property['id'])
            ->orderBy('name_unit', 'ASC')
            ->findAll();

        return view('admin/property/detail/index', [
            'title'      => 'Property Detail: ' . $property['title'],
            'property'   => $property,
            'details'    => $details, // bisa Anda hapus jika tidak dipakai lagi
            'units'      => $units,   // kirim data unit
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property', 'url' => base_url('dashboard/property')],
                ['label' => 'Detail'],
            ],
        ]);
    }



    public function updateDetail($slug)
    {
        $property = model('App\Models\PropertyModel')->where('slug', $slug)->first();
        if (!$property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        $detailModel = new \App\Models\PropertyDetailModel();

        $data = [
            'type'      => $this->request->getPost('type'),
            'purpose'   => $this->request->getPost('purpose'),
            'rooms'     => $this->request->getPost('rooms'),
            'bedrooms'  => $this->request->getPost('bedrooms'),
            'bathrooms' => $this->request->getPost('bathrooms'),
            'sqft'      => $this->request->getPost('sqft'),
            'wifi'      => $this->request->getPost('wifi') ? 1 : 0,
            'elevator'  => $this->request->getPost('elevator') ? 1 : 0,
            'parking'   => $this->request->getPost('parking') ? 1 : 0,
        ];

        $existing = $detailModel->where('property_id', $property['id'])->first();

        if ($existing) {
            $detailModel->update($existing['id'], $data);
        } else {
            $data['property_id'] = $property['id'];
            $detailModel->insert($data);
        }

        return redirect()->back()->with('success', 'Detail updated.');
    }

    public function storeFloorPlanFromDetail(string $slug)
    {
        return $this->storeFloorPlan($slug);
    }

    public function storeDocumentFromDetail(string $slug)
    {
        return $this->storeDocument($slug);
    }

    public function storeFloorPlan(string $slug)
    {
        $property = $this->propertyModel->where('slug', $slug)->first();
        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        $rules = [
            'name'        => 'required|min_length[3]',
            'description' => 'permit_empty',
            'image'       => 'uploaded[image]|is_image[image]|max_size[image,2048]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/property/floorplan/', $newName);

        $model = new PropertyFloorPlanModel();
        $model->insert([
            'property_id' => $property['id'],
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'image'       => $newName
        ]);

        return redirect()->to(base_url("dashboard/property/{$slug}/floorplan"))->with('success', 'Floor plan added successfully.');
    }

    public function storeDocument(string $slug)
    {
        $property = $this->propertyModel->where('slug', $slug)->first();
        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'type'  => 'required|in_list[pdf,video]',
            'video_url' => 'permit_empty|valid_url',
            'file' => 'permit_empty|uploaded[file]|max_size[file,2048]|ext_in[file,pdf]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $docModel = new PropertyDocumentModel();
        $data = [
            'property_id' => $property['id'],
            'title'       => $this->request->getPost('title'),
            'type'        => $this->request->getPost('type'),
        ];

        if ($data['type'] === 'pdf') {
            $file = $this->request->getFile('file');
            if ($file && $file->isValid() && ! $file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/property/documents/', $newName);
                $data['file_path'] = $newName;
            }
        } else {
            $data['video_url'] = $this->request->getPost('video_url');
        }

        $docModel->insert($data);

        return redirect()
            ->to(base_url("dashboard/property/{$slug}/documents"))
            ->with('success', 'Document added successfully.');
    }

    public function unitTypes($slug = null)
    {
        $unitModel     = new \App\Models\PropertyUnitTypeModel();
        $propertyModel = new \App\Models\PropertyModel();

        $properties = $propertyModel->findAll();
        $selectedProperty = null;
        $units = [];

        if ($slug) {
            $selectedProperty = $propertyModel->where('slug', $slug)->first();
            if ($selectedProperty) {
                $units = $unitModel->where('property_id', $selectedProperty['id'])->findAll();
            }
        } else {
            $units = $unitModel->findAll();
        }

        return view('admin/property/unit/index', [
            'title'        => 'Daftar Unit Type',
            'properties'   => $properties,
            'units'        => $units,
            'selectedId'   => $selectedProperty['id'] ?? null,
            'selectedSlug' => $slug,
            'breadcrumb'   => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property',  'url' => base_url('dashboard/property')],
                ['label' => 'Unit Type']
            ]
        ]);
    }




    public function saveUnit()
    {
        $unitModel = new \App\Models\PropertyUnitTypeModel();

        $data = $this->request->getPost([
            'id', 'property_id', 'name_unit', 'slug', 'type_unit', 'floors',
            'land_area', 'building_area', 'bedrooms', 'bathrooms',
            'carport', 'elevator'
        ]);

        $id = $data['id'] ?? null;

        if (!empty($id)) {
            // Ambil data lama dari database
            $existing = $unitModel->find($id);

            // Cek apakah kombinasi yang membentuk slug berubah
            $oldSlugSource = strtolower(trim($existing['name_unit'] . '-' . $existing['land_area'] . '-' . $existing['building_area']));
            $newSlugSource = strtolower(trim($data['name_unit'] . '-' . $data['land_area'] . '-' . $data['building_area']));

            if ($oldSlugSource !== $newSlugSource) {
                // Jika berubah, generate ulang slug
                $data['slug'] = generateUniqueSlug($newSlugSource, $unitModel);
            } else {
                // Jika tidak berubah, pakai slug lama
                unset($data['slug']);
            }

            $unitModel->update($id, $data);
            session()->setFlashdata('success', 'Unit berhasil diperbarui.');
        } else {
            // Untuk insert baru, pastikan slug dibuat jika kosong
            if (empty($data['slug']) && !empty($data['name_unit'])) {
                $slugSource = $data['name_unit'] . '-' . $data['land_area'] . '-' . $data['building_area'];
                $data['slug'] = generateUniqueSlug($slugSource, $unitModel);
            }

            $unitModel->insert($data);
            session()->setFlashdata('success', 'Unit baru berhasil ditambahkan.');
        }

        return redirect()->back();
    }





    public function deleteUnit($id)
    {
        $unitModel = new \App\Models\PropertyUnitTypeModel();
        $unitModel->delete($id);

        session()->setFlashdata('success', 'Unit berhasil dihapus.');
        return redirect()->back();
    }



}
