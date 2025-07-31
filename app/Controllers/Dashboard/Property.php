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

   public function index()
{
    $perPage = 5;

    $properties = $this->propertyModel
        ->select('properties.*, developers.name as developer_name, property_details.location, property_details.price, property_details.price_text, property_details.description')
        ->join('developers', 'developers.id = properties.developer_id')
        ->join('property_details', 'property_details.property_id = properties.id', 'left')
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

    return view('admin/property/index', [
        'title' => 'Property Listing',
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Property']
        ],
        'properties' => $properties,
        'pager' => $pager,
        'filterDeveloper' => null,
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

    // Ambil title & slug
    $title = $this->request->getPost('title');
    $slug  = generateUniqueSlug($title, $this->propertyModel);

    // Proses upload thumbnail (jika ada)
    $thumbnailName = null;
    $thumbnail = $this->request->getFile('thumbnail');
    if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
        $thumbnailName = $thumbnail->getRandomName();
        $thumbnail->move(FCPATH . 'uploads/property/thumbnail/', $thumbnailName);
    }

    // Insert ke tabel `properties` saja (tanpa field detail)
    $this->propertyModel->insert([
        'title'        => $title,
        'slug'         => $slug,
        'developer_id' => $developer['id'],
        'thumbnail'    => $thumbnailName,
    ]);

    // Ambil ID property terakhir
    $propertyId = $this->propertyModel->getInsertID();

    // Simpan ke tabel `property_details` (semua field terkait detail)
    $detailModel = new \App\Models\PropertyDetailModel();
    $detailModel->insert([
        'property_id'  => $propertyId,
        'price'        => $this->request->getPost('price'),
        'price_text'   => $this->request->getPost('price_text'),
        'location'     => $this->request->getPost('location'),
        'description'  => $this->request->getPost('description'),
    ]);

    return redirect()->to(base_url("dashboard/developer/{$devSlug}/property"))
                     ->with('success', 'Property added successfully.');
}


public function updateByDeveloper(string $devSlug, string $propSlug)
{
    helper(['text', 'slug']);

    $rules = [
        'title'     => 'required|min_length[3]',
        'thumbnail' => 'permit_empty|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]|max_size[thumbnail,2048]',
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
        'slug'  => $slug,
    ];

    // Upload thumbnail baru jika ada
    $thumbnail = $this->request->getFile('thumbnail');
    if ($thumbnail && $thumbnail->isValid() && !$thumbnail->hasMoved()) {
        $thumbnailName = $thumbnail->getRandomName();
        $thumbnail->move(FCPATH . 'uploads/property/thumbnail/', $thumbnailName);

        // Hapus thumbnail lama (jika ada)
        if (!empty($property['thumbnail'])) {
            $oldPath = FCPATH . 'uploads/property/thumbnail/' . $property['thumbnail'];
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $updateData['thumbnail'] = $thumbnailName;
    }

    $this->propertyModel->update($property['id'], $updateData);

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

    // Hapus file thumbnail jika ada
    if (!empty($property['thumbnail'])) {
        $thumbPath = FCPATH . 'uploads/property/thumbnail/' . $property['thumbnail'];
        if (file_exists($thumbPath)) {
            unlink($thumbPath);
        }
    }

    // Hapus detail property (jika ada)
    $detailModel = new \App\Models\PropertyDetailModel();
    $detailModel->where('property_id', $property['id'])->delete();

    // Hapus property dari DB
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

    // Inisialisasi model
    $typeModel       = new \App\Models\PropertyTypeModel();
    $documentModel   = new \App\Models\PropertyDocumentModel();
    $typeImagesModel = new \App\Models\PropertyTypeImagesModel();
    $detailModel     = new \App\Models\PropertyDetailModel();
    $imageModel      = new \App\Models\PropertyImageModel(); // untuk galeri gambar

    // Ambil data detail property (berisi field price, location, etc)
    $detail = $detailModel->where('property_id', $property['id'])->first();

    // Ambil gambar properti dari tabel property_images
    $images = $imageModel->where('property_id', $property['id'])->findAll();

    // Ambil semua tipe dan type images
    $types      = $typeModel->where('property_id', $property['id'])->findAll();
    $documents  = $documentModel->where('property_id', $property['id'])->findAll();
    $typeImages = $typeImagesModel->where('property_id', $property['id'])->findAll();

    // Gabungkan type dengan gambar masing-masing
    foreach ($types as &$type) {
        $type['type_image'] = null;
        foreach ($typeImages as $img) {
            if ($img['type_id'] == $type['id']) {
                $type['type_image'] = $img;
                break;
            }
        }
    }

    return view('admin/property/detail/index', [
        'title'          => 'Detail Property: ' . $property['title'],
        'property'       => $property,
        'detail'         => $detail,         // berisi price, price_text, location, description
        'types'          => $types,
        'documents'      => $documents,
        'typeimagess'    => $typeImages,
        'images'         => $images,         // gambar tambahan dari tabel property_images
        'filterDeveloper'=> $developer,
        'breadcrumb'     => [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'Developer', 'url' => base_url('dashboard/developer')],
            ['label' => 'Property', 'url' => base_url("dashboard/developer/{$devSlug}/property")],
            ['label' => 'Detail']
        ]
    ]);
}


public function saveDetailByDeveloper($devSlug, $propSlug)
{
    helper(['form']);

    // Validasi input
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

    // Cek apakah ini update atau insert
    $detailId = $this->request->getPost('id');
    if ($detailId) {
        $detailModel->update($detailId, $data);
    } else {
        $detailModel->insert($data);
    }

    return redirect()->to(base_url("dashboard/developer/{$devSlug}/property/{$propSlug}/detail"))
                     ->with('success', 'Detail properti berhasil disimpan.');
}



    public function saveTypeByDeveloper($devSlug, $propSlug)
{
    $devModel   = new DeveloperModel();
    $propModel  = new PropertyModel();
    $typeModel  = new PropertyTypeModel();

    // Validasi developer
    $developer = $devModel->where('slug', $devSlug)->first();
    if (!$developer) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Developer tidak ditemukan');
    }

    // Validasi property milik developer
    $property = $propModel->where('slug', $propSlug)
                          ->where('developer_id', $developer['id'])
                          ->first();
    if (!$property) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Property tidak ditemukan');
    }

    // Ambil data dari form
    $data = $this->request->getPost([
        'id', 'name', 'slug', 'type_unit', 'floors',
        'land_area', 'building_area', 'bedrooms',
        'bathrooms', 'carport', 'elevator'
    ]);
    $data['property_id'] = $property['id'];

    // Generate slug jika kosong
    if (empty($data['slug'])) {
        helper('text');
        $data['slug'] = url_title($data['name'], '-', true);
    }

    if (!empty($data['id'])) {
        // Edit Type
        $type = $typeModel->where('id', $data['id'])
                          ->where('property_id', $property['id'])
                          ->first();

        if (!$type) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Type tidak ditemukan atau bukan milik property ini');
        }

        $typeModel->update($data['id'], $data);
        $msg = 'Type berhasil diupdate.';
    } else {
        // Tambah Type
        $typeModel->insert($data);
        $msg = 'Type berhasil ditambahkan.';
    }

    return redirect()->back()->with('success', $msg);
}




    public function deleteTypeByDeveloper($devSlug, $propSlug, $id)
{
    $developer = (new DeveloperModel())->where('slug', $devSlug)->first();
    $property  = $this->propertyModel->where('slug', $propSlug)->first();

    if (!$property || !$developer || $property['developer_id'] != $developer['id']) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Unauthorized access');
    }

    $typeModel        = new PropertyTypeModel();
    $typeImagesModel  = new PropertyTypeImagesModel();

    // Ambil semua type images yang terkait
    $typeImages = $typeImagesModel->where('type_id', $id)->findAll();

    // Hapus file gambar dari filesystem
    foreach ($typeImages as $img) {
        $path = FCPATH . 'uploads/property/typeimages/' . $img['image'];
        if (is_file($path)) {
            unlink($path);
        }
    }

    // Hapus data image dari DB
    $typeImagesModel->where('type_id', $id)->delete();

    // Hapus type
    $typeModel->delete($id);

    return redirect()->back()->with('success', 'Type dan semua gambar terkait berhasil dihapus.');
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

    public function storetypeimagesByDeveloper($devSlug, $propSlug)
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

        // Validasi input
        $rules = [
            'type_id' => 'required|numeric',
            'name_floor' => 'required|min_length[3]',
            'image' => 'uploaded[image]|is_image[image]|max_size[image,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload file
        $image = $this->request->getFile('image');
        $newName = $image->getRandomName();
        $image->move(FCPATH . 'uploads/property/typeimages/', $newName);

        // Simpan ke DB
        $typeImagesModel = new \App\Models\PropertyTypeImagesModel();
        $typeImagesModel->insert([
            'property_id' => $property['id'],
            'type_id' => $this->request->getPost('type_id'),
            'name_floor' => $this->request->getPost('name_floor'),
            'image' => $newName
        ]);

        return redirect()->back()->with('success', 'Floor plan berhasil ditambahkan.');
    }


    public function deletetypeimagesByDeveloper($devSlug, $propSlug, $id)
    {
        $planModel = new \App\Models\PropertyTypeImagesModel();
        $plan = $planModel->find($id);

        if (!$plan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Floor plan tidak ditemukan.');
        }

        // Hapus file fisik
        $path = FCPATH . 'uploads/property/typeimages/' . $plan['image'];
        if (file_exists($path)) {
            unlink($path);
        }

        // Hapus dari database
        $planModel->delete($id);

        return redirect()->back()->with('success', 'Floor plan berhasil dihapus.');
    }

}
