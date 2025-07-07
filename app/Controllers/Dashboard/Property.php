<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\PropertyModel;
use App\Models\PropertyImageModel;

class Property extends BaseController
{
    protected $propertyModel;

    public function __construct()
    {
        $this->propertyModel = new PropertyModel();
        helper(['number', 'my_helper']); // pastikan helper custom dimuat
    }

    public function index()
    {
        $perPage    = 5;
        $properties = $this->propertyModel->paginate($perPage);
        $pager      = $this->propertyModel->pager;
        $imageModel = new PropertyImageModel();

        foreach ($properties as &$p) {
            // Ambil gambar pertama sebagai thumbnail
            $img = $imageModel
                ->where('property_id', $p['id'])
                ->first();

            $p['thumbnail'] = $img
                ? base_url('uploads/property/' . $img['filename'])
                : base_url('images/placeholder-80x60.png');
        }
        unset($p);

        return view('admin/property/index', [
            'title'      => 'Property Listing',
            'breadcrumb' => [
                ['label'=>'Dashboard','url'=>base_url('dashboard')],
                ['label'=>'Property'],
            ],
            'properties' => $properties,
            'pager'      => $pager,
        ]);
    }



    public function create()
    {
        return view('admin/property/create', [
            'title' => 'Add Property',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property', 'url' => base_url('dashboard/property')],
                ['label' => 'Add Property']
            ],
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

        $title = $this->request->getPost('title');
        $slug = generateUniqueSlug($title, $this->propertyModel);

        $this->propertyModel->save([
            'title'       => $title,
            'slug'        => $slug,
            'location'    => $this->request->getPost('location'),
            'price'       => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
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

        $images = (new PropertyImageModel())->where('property_id', $property['id'])->findAll();

        return view('admin/property/edit', [
            'title' => ''.$property['title'],
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Property', 'url' => base_url('dashboard/property')],
                ['label' => 'Edit Property']
            ],
            'property' => $property,
            'images' => $images
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

        $existing = $this->propertyModel->find($id);
        $newTitle = $this->request->getPost('title');
        $slug     = $existing['slug'];

        if ($newTitle !== $existing['title']) {
            $slug = generateUniqueSlug($newTitle, $this->propertyModel);
        }

        $this->propertyModel->update($id, [
            'title'       => $newTitle,
            'slug'        => $slug,
            'location'    => $this->request->getPost('location'),
            'price'       => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
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
    $devModel  = model('App\Models\DeveloperModel');
    $developer = $devModel->where('slug', $slug)->first();
    if (! $developer) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
    }

    // ambil properti seperti biasa…
    $perPage    = 5;
    $builder    = $this->propertyModel
                       ->where('developer_id', $developer['id'])
                       ->orderBy('created_at','DESC');
    $properties = $builder->paginate($perPage);
    $pager      = $builder->pager;

    // assign thumbnail & images…
    $imageModel = new \App\Models\PropertyImageModel();
    foreach ($properties as &$p) {
        $imgs = $imageModel->where('property_id', $p['id'])->findAll();
        $urls = array_map(fn($r)=>base_url('uploads/property/'.$r['filename']), $imgs);
        $p['thumbnail'] = $urls[0] ?? base_url('images/placeholder-80x60.png');
        $p['images']    = $urls;
    }
    unset($p);

    return view('admin/property/index', [
        'title'           => 'Properties by ' . $developer['name'],
        'breadcrumb'      => [
            ['label'=>'Dashboard', 'url'=>base_url('dashboard')],
            ['label'=>'Developer',  'url'=>base_url('dashboard/developer')],
            ['label'=>$developer['name']],
        ],
        'properties'      => $properties,
        'pager'           => $pager,
        // ← kirim di sini
        'filterDeveloper' => $developer,
    ]);
}


    public function createByDeveloper(string $slug)
    {
        // Cari developer via slug
        $devModel   = model('App\Models\DeveloperModel');
        $developer  = $devModel->where('slug', $slug)->first();
        if (! $developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        // Load view form, kirim developer-nya
        return view('admin/property/create_by_developer', [
            'title'      => 'Add Property for ' . $developer['name'],
            'breadcrumb' => [
                ['label'=>'Dashboard','url'=>base_url('dashboard')],
                ['label'=>'Developer','url'=>base_url('dashboard/developer')],
                ['label'=>$developer['name'],'url'=>base_url('dashboard/property/developer/'.$slug)],
                ['label'=>'Create Property'],
            ],
            'developer'  => $developer,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function storeByDeveloper(string $slug)
    {
        // Validasi sama seperti store()
        $rules = [
            'title'        => 'required|min_length[3]',
            'location'     => 'required',
            'price'        => 'required|numeric',
            'description'  => 'required',
            'images'       => 'permit_empty'
                              .'|is_image[images.*]'
                              .'|max_size[images.*,2048]'
                              .'|max_files[images,10]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors',$this->validator->getErrors());
        }

        // Temukan developer id
        $devModel   = model('App\Models\DeveloperModel');
        $developer  = $devModel->where('slug', $slug)->first();

        // Simpan property
        $title      = $this->request->getPost('title');
        $slugProp   = generateUniqueSlug($title, $this->propertyModel);
        $this->propertyModel->insert([
            'title'        => $title,
            'slug'         => $slugProp,
            'developer_id' => $developer['id'],
            'location'     => $this->request->getPost('location'),
            'price'        => $this->request->getPost('price'),
            'description'  => $this->request->getPost('description'),
        ]);
        $propertyId = $this->propertyModel->getInsertID();

        // Upload images
        $files = $this->request->getFileMultiple('images');
        $imgModel = new \App\Models\PropertyImageModel();
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
            ->to(base_url('dashboard/property/developer/'.$slug))
            ->with('success','Property added.');
    }


    public function editByDeveloper(string $devSlug, string $propSlug)
    {
        $devModel   = model('App\Models\DeveloperModel');
        $developer  = $devModel->where('slug', $devSlug)->first();
        if (! $developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        // Cari property by slug & developer_id
        $property = $this->propertyModel
            ->where('slug', $propSlug)
            ->where('developer_id', $developer['id'])
            ->first();
        if (! $property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found');
        }

        // Ambil semua gambar untuk preview
        $imgModel = new \App\Models\PropertyImageModel();
        $imgs     = $imgModel->where('property_id', $property['id'])->findAll();
        $urls     = array_map(
            fn($row)=> base_url('uploads/property/' . $row['filename']),
            $imgs
        );

        return view('admin/property/edit_by_developer', [
            'title'         => 'Edit Property: ' . $property['title'],
            'breadcrumb'    => [
                ['label'=>'Dashboard','url'=>base_url('dashboard')],
                ['label'=>'Developer','url'=>base_url('dashboard/developer')],
                ['label'=>$developer['name'],
                 'url'=>base_url("dashboard/property/developer/{$devSlug}")],
                ['label'=>'Edit Property'],
            ],
            'developer'     => $developer,
            'property'      => $property,
            'propertyImages'=> $urls,
            'validation'    => \Config\Services::validation(),
        ]);
    }

    public function updateByDeveloper(string $devSlug, string $propSlug)
    {
        helper('form');

        // Validasi field
        $rules = [
            'title'       => 'required|min_length[3]',
            'location'    => 'required',
            'price'       => 'required|numeric',
            'description' => 'required',
            'images'      => 'permit_empty'
                            .'|is_image[images.*]'
                            .'|max_size[images.*,2048]'
                            .'|max_files[images,10]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()
                             ->withInput()
                             ->with('validation', $this->validator);
        }

        // Temukan developer & property
        $devModel  = model('App\Models\DeveloperModel');
        $developer = $devModel->where('slug', $devSlug)->first();
        $property  = $this->propertyModel
            ->where('slug', $propSlug)
            ->where('developer_id', $developer['id'])
            ->first();

        // Siapkan data update
        $data = [
            'title'       => $this->request->getPost('title'),
            'location'    => $this->request->getPost('location'),
            'price'       => $this->request->getPost('price'),
            'description' => $this->request->getPost('description'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ];

        // Upload gambar baru (jika ada)
        $files = $this->request->getFileMultiple('images');
        $imgModel = new \App\Models\PropertyImageModel();
        foreach ($files as $file) {
            if ($file->isValid() && ! $file->hasMoved()) {
                $name = $file->getRandomName();
                $file->move(FCPATH . 'uploads/property/', $name);
                // simpan record baru
                $imgModel->insert([
                    'property_id'=> $property['id'],
                    'filename'   => $name,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        // Update data property (slug tidak berubah)
        $this->propertyModel->update($property['id'], $data);

        return redirect()
            ->to(base_url("dashboard/property/developer/{$devSlug}"))
            ->with('success','Property updated successfully.');
    }

    public function delete($id)
    {
        $imageModel = new PropertyImageModel();
        $images = $imageModel->where('property_id', $id)->findAll();

        foreach ($images as $img) {
            $path = FCPATH . 'uploads/property/' . $img['filename'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $imageModel->where('property_id', $id)->delete();
        $this->propertyModel->delete($id);

        return redirect()->to('/dashboard/property')->with('success', 'Property deleted successfully.');
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
}
