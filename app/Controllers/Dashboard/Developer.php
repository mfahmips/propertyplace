<?php namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\DeveloperModel;

class Developer extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new DeveloperModel();
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
}
