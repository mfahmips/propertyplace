<?php 

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\{
    DeveloperModel,
    PropertyModel,
    PropertyDetailModel,
    PropertyDocumentModel,
    PropertyImageModel,
    PropertyTypeModel,
    PropertyTypeImagesModel
};
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Developer extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DeveloperModel();
        $this->propertyModel = new PropertyModel();
    }

   public function index()
    {
        $developerModel = new \App\Models\DeveloperModel();
        $propertyModel  = new \App\Models\PropertyModel();

        // Ambil daftar developer dengan pagination
        $devs = $developerModel->orderBy('name', 'ASC')->paginate(5, 'developers');

        // Untuk setiap developer, ambil properti mereka beserta detail-nya
        foreach ($devs as &$d) {
            $d['properties'] = $propertyModel
                ->select('properties.id, properties.title, property_details.location, property_details.price_text')
                ->join('property_details', 'property_details.property_id = properties.id', 'left')
                ->where('properties.developer_id', $d['id'])
                ->findAll();
        }

        $data = [
            'title' => 'Developers',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Developer'],
            ],
            'devs'  => $devs,
            'pager' => $developerModel->pager
        ];

        return view('admin/developer/index', $data);
    }



    public function create()
    {
        $data = [
            'title'      => 'Add Developer',
            'breadcrumb' => [
                ['label'=>'Dashboard','url'=>base_url('dashboard')],
                ['label'=>'Developer','url'=>base_url('dashboard/developer')],
                ['label'=>'Create'],
            ],
        ];
        return view('admin/developer/create', $data);
    }

    public function store()
    {
        helper('form');

        $validationRule = [
            'name'     => 'required|min_length[3]',
            'logo'     => [
                'label' => 'Developer Logo',
                'rules' => 'uploaded[logo]'
                         . '|is_image[logo]'
                         . '|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]'
                         . '|max_size[logo,2048]',
            ],
        ];
        if (! $this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $targetDir = FCPATH . 'uploads/developer/';
        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $file = $this->request->getFile('logo');
        $filename = $file->getRandomName();
        $file->move($targetDir, $filename);

        $name = $this->request->getPost('name');
        $slug = url_title($name, '-', true);

        // Cek slug unik
        $i = 1;
        $baseSlug = $slug;
        while ($this->model->where('slug', $slug)->first()) {
            $slug = $baseSlug . '-' . $i++;
        }

        $this->model->insert([
            'name'       => $name,
            'slug'       => $slug,
            'logo'       => $filename,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(base_url('dashboard/developer'))
                         ->with('success', 'Developer added successfully.');
    }

    public function edit($id)
    {
        $dev = $this->model->find($id);
        if (! $dev) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        $data = [
            'title'      => 'Edit Developer',
            'breadcrumb' => [
                ['label'=>'Dashboard','url'=>base_url('dashboard')],
                ['label'=>'Developer','url'=>base_url('dashboard/developer')],
                ['label'=>'Edit'],
            ],
            'dev'        => $dev,
        ];
        return view('admin/developer/edit', $data);
    }

    public function update($id)
    {
        helper('form');

        $validationRule = [
            'name' => 'required|min_length[3]',
            'logo' => [
                'label' => 'Developer Logo',
                'rules' => 'permit_empty'
                    . '|is_image[logo]'
                    . '|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]'
                    . '|max_size[logo,2048]',
            ],
        ];

        if (! $this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $name = $this->request->getPost('name');
        $slug = url_title($name, '-', true);

        // Cek slug unik
        $baseSlug = $slug;
        $i = 1;
        while (($dev = $this->model->where('slug', $slug)->first()) && $dev['id'] != $id) {
            $slug = $baseSlug . '-' . $i++;
        }

        $data = [
            'name'       => $name,
            'slug'       => $slug,
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Cek apakah file logo baru di-upload
        $file = $this->request->getFile('logo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $targetDir = FCPATH . 'uploads/developer/';

            // Buat folder jika belum ada
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Ambil logo lama dan hapus jika ada
            $oldLogo = $this->model->find($id)['logo'] ?? null;
            if ($oldLogo && file_exists($targetDir . $oldLogo)) {
                unlink($targetDir . $oldLogo);
            }

            // Simpan logo baru
            $newName = $file->getRandomName();
            $file->move($targetDir, $newName);
            $data['logo'] = $newName;
        }

        // Update ke database
        $this->model->update($id, $data);

        return redirect()->to(base_url('dashboard/developer'))
                         ->with('success', 'Developer updated successfully.');
    }


    public function delete($id)
    {
        $dev = $this->model->find($id);
        if ($dev) {
            // Hapus file logo jika ada
            $targetDir = FCPATH . 'uploads/developer/';
            if (! empty($dev['logo']) && file_exists($targetDir . $dev['logo'])) {
                unlink($targetDir . $dev['logo']);
            }

            $this->model->delete($id);
        }

        return redirect()->to(base_url('dashboard/developer'))
                         ->with('success','Developer deleted.');
    }


    public function property(string $slug)
    {
        $developer = (new DeveloperModel())->where('slug', $slug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        $perPage = 5;

        $properties = $this->propertyModel
            ->select('properties.*, property_details.location, property_details.price, property_details.price_text, property_details.description')
            ->join('property_details', 'property_details.property_id = properties.id', 'left')
            ->where('properties.developer_id', $developer['id'])
            ->orderBy('properties.title', 'ASC')
            ->paginate($perPage);

        $pager = $this->propertyModel->pager;
        $typeModel = new PropertyTypeModel();

        foreach ($properties as &$p) {
            $p['thumbnail_url'] = !empty($p['thumbnail'])
                ? base_url('uploads/property/thumbnail/' . $p['thumbnail'])
                : base_url('images/placeholder-80x60.png');

            $p['Types'] = $typeModel
                ->where('property_id', $p['id'])
                ->select('id, name, slug')
                ->findAll();
        }

        return view('admin/developer/property', [
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


    public function storeProperty(string $devSlug)
    {
        $rules = [
            'title'     => 'required|min_length[3]',
            'thumbnail' => 'permit_empty|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]|max_size[thumbnail,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Ambil developer berdasarkan slug
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        // Ambil title & slug unik
        $title = $this->request->getPost('title');
        $slug  = generateUniqueSlug($title, $this->propertyModel);

        // Upload thumbnail (jika ada)
        $thumbnailName = null;
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move(FCPATH . 'uploads/property/thumbnail/', $thumbnailName);
        }

        // Simpan ke tabel properties
        $this->propertyModel->insert([
            'title'        => $title,
            'slug'         => $slug,
            'developer_id' => $developer['id'],
            'thumbnail'    => $thumbnailName,
        ]);

        // Ambil ID property terakhir
        $propertyId = $this->propertyModel->getInsertID();

        // Simpan detail properti dasar
        $detailModel = new \App\Models\PropertyDetailModel();
        $detailModel->insert([
            'property_id'  => $propertyId,
            'price'        => $this->request->getPost('price'),
            'price_text'   => $this->request->getPost('price_text'),
            'location'     => $this->request->getPost('location'),
            'description'  => $this->request->getPost('description'),
        ]);

        return redirect()->to(base_url("dashboard/developer/{$devSlug}"))
                         ->with('success', 'Property added successfully.');
    }



    // UPDATE PROPERTY
    public function updateProperty(string $devSlug, string $propSlug)
    {
        helper(['text', 'slug']);

        $rules = [
            'title'     => 'required|min_length[3]',
            'thumbnail' => 'permit_empty|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]|max_size[thumbnail,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validasi developer
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        // Ambil property berdasarkan slug dan developer
        $property = $this->propertyModel
            ->where('slug', $propSlug)
            ->where('developer_id', $developer['id'])
            ->first();

        if (!$property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found or unauthorized');
        }

        // Cek jika judul berubah → ubah slug juga
        $newTitle = $this->request->getPost('title');
        $slug = ($newTitle !== $property['title'])
            ? generateUniqueSlug($newTitle, $this->propertyModel)
            : $property['slug'];

        $updateData = [
            'title' => $newTitle,
            'slug'  => $slug,
        ];

        // Upload thumbnail baru (jika ada)
        $thumbnail = $this->request->getFile('thumbnail');
        if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
            $thumbnailName = $thumbnail->getRandomName();
            $thumbnail->move(FCPATH . 'uploads/property/thumbnail/', $thumbnailName);

            // Hapus thumbnail lama
            if (!empty($property['thumbnail'])) {
                $oldPath = FCPATH . 'uploads/property/thumbnail/' . $property['thumbnail'];
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $updateData['thumbnail'] = $thumbnailName;
        }

        $this->propertyModel->update($property['id'], $updateData);

        return redirect()->to(base_url("dashboard/developer/{$devSlug}"))
                         ->with('success', 'Property updated successfully.');
    }



    // DELETE PROPERTY
    public function deleteProperty(string $devSlug, int $id)
    {
        // Cek developer
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer not found');
        }

        // Cek property
        $property = $this->propertyModel->find($id);
        if (!$property || $property['developer_id'] != $developer['id']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property not found or unauthorized');
        }

        // Hapus file thumbnail (jika ada)
        if (!empty($property['thumbnail'])) {
            $thumbPath = FCPATH . 'uploads/property/thumbnail/' . $property['thumbnail'];
            if (file_exists($thumbPath)) {
                unlink($thumbPath);
            }
        }

        // Hapus detail property
        $detailModel = new \App\Models\PropertyDetailModel();
        $detailModel->where('property_id', $property['id'])->delete();

        // Hapus property dari DB
        $this->propertyModel->delete($id);

        return redirect()->to(base_url("dashboard/developer/{$devSlug}"))
                         ->with('success', 'Property deleted successfully.');
    }


    // 🖼️ DELETE IMAGE PROPERTY
    public function deleteImageProperty($devSlug, $imageId)
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



    // 🏠 DETAIL PROPERTY
    public function detailProperty($devSlug, $propSlug)
    {
        $developer = (new \App\Models\DeveloperModel())->where('slug', $devSlug)->first();
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

        // Model inisialisasi
        $typeModel       = new \App\Models\PropertyTypeModel();
        $documentModel   = new \App\Models\PropertyDocumentModel();
        $typeImagesModel = new \App\Models\PropertyTypeImagesModel();
        $detailModel     = new \App\Models\PropertyDetailModel();
        $imageModel      = new \App\Models\PropertyImageModel();

        $detail    = $detailModel->where('property_id', $property['id'])->first();
        $images    = $imageModel->where('property_id', $property['id'])->findAll();
        $types     = $typeModel->where('property_id', $property['id'])->findAll();
        $documents = $documentModel->where('property_id', $property['id'])->findAll();
        $typeImages = $typeImagesModel->where('property_id', $property['id'])->findAll();

        // Hubungkan tipe dengan gambar
        foreach ($types as &$type) {
            $type['type_image'] = null;
            foreach ($typeImages as $img) {
                if ($img['type_id'] == $type['id']) {
                    $type['type_image'] = $img;
                    break;
                }
            }
        }

        return view('admin/developer/detail/index', [
            'title'           => 'Detail Property: ' . $property['title'],
            'property'        => $property,
            'detail'          => $detail,
            'types'           => $types,
            'documents'       => $documents,
            'typeimagess'     => $typeImages,
            'images'          => $images,
            'filterDeveloper' => $developer,
            'breadcrumb'      => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Developer', 'url' => base_url('dashboard/developer')],
                ['label' => 'Property', 'url' => base_url("dashboard/developer/{$devSlug}")],
                ['label' => 'Detail']
            ]
        ]);
    }



    // 💾 SAVE DETAIL PROPERTY
    public function saveDetailProperty($devSlug, $propSlug)
    {
        helper(['form']);

        $rules = [
            'price'       => 'required|numeric',
            'price_text'  => 'required|string|max_length[100]',
            'location'    => 'required|in_list[Jakarta,Bogor,Depok,Tangerang,Bekasi]',
            'type'        => 'permit_empty|string|max_length[100]',
            'purpose'     => 'permit_empty|string|max_length[100]',
            'description' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $developer = (new \App\Models\DeveloperModel())->where('slug', $devSlug)->first();
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

        $detailModel = new \App\Models\PropertyDetailModel();

        $data = [
            'property_id'  => $property['id'],
            'price'        => $this->request->getPost('price'),
            'price_text'   => $this->request->getPost('price_text'),
            'location'     => $this->request->getPost('location'),
            'type'         => $this->request->getPost('type'),
            'purpose'      => $this->request->getPost('purpose'),
            'description'  => $this->request->getPost('description'),
        ];

        $detailId = $this->request->getPost('id');
        if ($detailId) {
            $detailModel->update($detailId, $data);
        } else {
            $detailModel->insert($data);
        }

        return redirect()->to(base_url("dashboard/developer/{$devSlug}/{$propSlug}"))
                         ->with('success', 'Detail properti berhasil disimpan.');
    }



    // 🧱 SAVE TYPE PROPERTY
    public function saveTypeProperty($devSlug, $propSlug)
    {
        $devModel   = new DeveloperModel();
        $propModel  = new PropertyModel();
        $typeModel  = new PropertyTypeModel();

        $developer = $devModel->where('slug', $devSlug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer tidak ditemukan');
        }

        $property = $propModel->where('slug', $propSlug)
                              ->where('developer_id', $developer['id'])
                              ->first();
        if (!$property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property tidak ditemukan');
        }

        $data = $this->request->getPost([
            'id', 'name', 'slug', 'type_unit', 'floors',
            'land_area', 'building_area', 'bedrooms',
            'bathrooms', 'carport', 'elevator'
        ]);
        $data['property_id'] = $property['id'];

        if (empty($data['slug'])) {
            helper('text');
            $data['slug'] = url_title($data['name'], '-', true);
        }

        if (!empty($data['id'])) {
            $type = $typeModel->where('id', $data['id'])
                              ->where('property_id', $property['id'])
                              ->first();

            if (!$type) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Type tidak ditemukan atau bukan milik property ini');
            }

            $typeModel->update($data['id'], $data);
            $msg = 'Type berhasil diupdate.';
        } else {
            $typeModel->insert($data);
            $msg = 'Type berhasil ditambahkan.';
        }

        return redirect()->back()->with('success', $msg);
    }



    // ❌ DELETE TYPE PROPERTY
    public function deleteTypeProperty($devSlug, $propSlug, $id)
    {
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        $property  = $this->propertyModel->where('slug', $propSlug)->first();

        if (!$property || !$developer || $property['developer_id'] != $developer['id']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Unauthorized access');
        }

        $typeModel        = new PropertyTypeModel();
        $typeImagesModel  = new PropertyTypeImagesModel();

        $typeImages = $typeImagesModel->where('type_id', $id)->findAll();

        foreach ($typeImages as $img) {
            $path = FCPATH . 'uploads/property/typeimages/' . $img['image'];
            if (is_file($path)) unlink($path);
        }

        $typeImagesModel->where('type_id', $id)->delete();
        $typeModel->delete($id);

        return redirect()->back()->with('success', 'Type dan semua gambar terkait berhasil dihapus.');
    }



    // 📄 STORE DOCUMENT PROPERTY
    public function storeDocumentProperty($devSlug, $propSlug)
    {
        $property = $this->propertyModel->where('slug', $propSlug)->first();
        $rules = [
            'title' => 'required|min_length[3]',
            'type' => 'required|in_list[pdf,video]',
            'video_url' => 'permit_empty|valid_url',
            'file' => 'permit_empty|uploaded[file]|max_size[file,2048]|ext_in[file,pdf]'
        ];

        if (!$this->validate($rules))
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());

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



    // ❌ DELETE DOCUMENT PROPERTY
    public function deleteDocumentProperty($devSlug, $propSlug, $id)
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



    // 🧩 STORE TYPE IMAGES PROPERTY
    public function storeTypeImagesProperty($devSlug, $propSlug)
    {
        $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
        if (!$developer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer tidak ditemukan');
        }

        $property = $this->propertyModel
            ->where('slug', $propSlug)
            ->where('developer_id', $developer['id'])
            ->first();

        if (!$property) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Property tidak ditemukan');
        }

        $rules = [
            'type_id' => 'required|numeric',
            'name_floor' => 'required|min_length[3]',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $image = $this->request->getFile('image');
        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/property/typeimages/', $newName);

        $typeImagesModel = new \App\Models\PropertyTypeImagesModel();
        $typeImagesModel->insert([
            'property_id' => $property['id'],
            'type_id' => $this->request->getPost('type_id'),
            'name_floor' => $this->request->getPost('name_floor'),
            'image' => $newName
        ]);

        return redirect()->back()->with('success', 'Floor plan berhasil ditambahkan.');
    }



    // ❌ DELETE TYPE IMAGE PROPERTY
    public function deleteTypeImagesProperty($devSlug, $propSlug, $id)
    {
        $planModel = new \App\Models\PropertyTypeImagesModel();
        $plan = $planModel->find($id);

        if (!$plan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Floor plan tidak ditemukan.');
        }

        $path = FCPATH . 'uploads/property/typeimages/' . $plan['image'];
        if (file_exists($path)) unlink($path);

        $planModel->delete($id);

        return redirect()->back()->with('success', 'Floor plan berhasil dihapus.');
    }

    public function exportProperty($slug = null)
{
    if (empty($slug)) {
        return redirect()->back()->with('error', 'Slug developer tidak ditemukan.');
    }

    // 🔹 Ambil developer berdasarkan slug
    $developerModel = new DeveloperModel();
    $developer = $developerModel->where('slug', $slug)->first();

    if (!$developer) {
        return redirect()->back()->with('error', 'Developer tidak valid.');
    }

    $developerId = $developer['id'];

    // 🔹 Daftar model yang akan diexport
    $models = [
        'properties'           => new PropertyModel(),
        'property_details'     => new PropertyDetailModel(),
        'property_documents'   => new PropertyDocumentModel(),
        'property_images'      => new PropertyImageModel(),
        'property_type'        => new PropertyTypeModel(),
        'property_type_images' => new PropertyTypeImagesModel(),
    ];

    $spreadsheet = new Spreadsheet();
    $isFirst = true;

    // 🔹 Preload semua property slug untuk efisiensi
    $propertySlugs = $models['properties']
        ->select('id, slug')
        ->where('developer_id', $developerId)
        ->findAll();
    $slugMap = array_column($propertySlugs, 'slug', 'id');

    // 🔹 Loop tiap tabel model
    foreach ($models as $sheetName => $model) {
        if (empty($model->table)) continue;

        // Filter data berdasarkan developer_id
        if ($model->db->fieldExists('developer_id', $model->table)) {
            $data = $model->where('developer_id', $developerId)->findAll();
        } else {
            // Filter berdasarkan property_id
            if (in_array($sheetName, [
                'property_details', 'property_documents', 'property_images', 'property_type', 'property_type_images'
            ])) {
                $propertyIds = array_keys($slugMap);
                if (empty($propertyIds)) continue;
                $data = $model->whereIn('property_id', $propertyIds)->findAll();
            } else {
                $data = [];
            }
        }

        if (empty($data)) continue;

        // 🔹 Ganti kolom ID menjadi slug
        foreach ($data as &$row) {
            if (isset($row['developer_id'])) {
                $row['developer_slug'] = $developer['slug'];
                unset($row['developer_id']);
            }
            if (isset($row['property_id'])) {
                $row['property_slug'] = $slugMap[$row['property_id']] ?? null;
                unset($row['property_id']);
            }
        }

        // 🔹 Buat sheet baru
        $sheet = $isFirst ? $spreadsheet->getActiveSheet() : $spreadsheet->createSheet();
        $isFirst = false;

        // Bersihkan nama sheet agar tidak error (maks 31 karakter)
        $cleanSheetName = ucwords(str_replace('_', ' ', $sheetName));
        $sheet->setTitle(substr(preg_replace('/[\\\\\\/?*\\[\\]:]/', '', $cleanSheetName), 0, 31));

        // Header & data
        $headers = array_keys(reset($data));
        $sheet->fromArray([$headers], null, 'A1');
        $sheet->fromArray($data, null, 'A2');
    }

    // 🔹 Buat nama file tanpa tanggal & waktu
    $devName = ucwords(str_replace(['-', '_'], ' ', $developer['slug']));
    $devName = str_replace(' ', '', $devName);
    $fileName = 'ListingProperty_' . $devName . '.xlsx';

    // 🔹 Output ke browser
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}



public function importProperty($slug = null)
{
    if (empty($slug)) {
        return redirect()->back()->with('error', 'Slug developer tidak ditemukan.');
    }

    $developerModel = new DeveloperModel();
    $developer = $developerModel->where('slug', $slug)->first();

    if (!$developer) {
        return redirect()->back()->with('error', 'Developer tidak valid.');
    }

    $developerId = $developer['id'];

    $file = $this->request->getFile('file');
    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'File tidak valid atau gagal diupload.');
    }

    $spreadsheet = IOFactory::load($file->getTempName());

    $models = [
        'properties'           => new PropertyModel(),
        'property_details'     => new PropertyDetailModel(),
        'property_documents'   => new PropertyDocumentModel(),
        'property_images'      => new PropertyImageModel(),
        'property_type'        => new PropertyTypeModel(),
        'property_type_images' => new PropertyTypeImagesModel(),
    ];

    foreach ($spreadsheet->getAllSheets() as $sheet) {
        $sheetName = $sheet->getTitle();

        if (!isset($models[$sheetName])) {
            continue;
        }

        $rows = $sheet->toArray(null, true, true, true);
        if (count($rows) < 2) continue;

        // Baris pertama adalah header
        $headers = array_values($rows[1]);
        unset($rows[1]);

        $data = [];
        foreach ($rows as $row) {
            $item = [];
            foreach ($headers as $index => $field) {
                $colLetter = chr(65 + $index);
                if (!empty($field) && isset($row[$colLetter])) {
                    $item[$field] = $row[$colLetter];
                }
            }

            // Tambahkan developer_id jika kolom ada
            if (isset($models[$sheetName]->allowedFields)
                && in_array('developer_id', $models[$sheetName]->allowedFields)
            ) {
                $item['developer_id'] = $developerId;
            }

            if (!empty($item)) {
                $data[] = $item;
            }
        }

        // Hapus data lama milik developer ini sebelum import
        if (!empty($data)) {
            if ($models[$sheetName]->db->fieldExists('developer_id', $models[$sheetName]->table)) {
                $models[$sheetName]->where('developer_id', $developerId)->delete();
            }

            $models[$sheetName]->insertBatch($data);
        }
    }

    return redirect()->back()->with('success', 'Data properti developer berhasil diimport.');
}


}
