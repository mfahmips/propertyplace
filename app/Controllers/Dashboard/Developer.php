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
        $data = [
            'title'      => 'Developers',
            'breadcrumb' => [
                ['label'=>'Dashboard','url'=>base_url('dashboard')],
                ['label'=>'Developer'],
            ],
            'devs'       => $this->model->orderBy('name','ASC')->findAll(),
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

        // 1) Validasi
        $validationRule = [
            'name'     => 'required|min_length[3]',
            'location' => 'permit_empty',
            'logo'     => [
                'label' => 'Developer Logo',
                'rules' => 'uploaded[logo]'
                         . '|is_image[logo]'
                         . '|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]'
                         . '|max_size[logo,2048]',
            ],
        ];
        if (! $this->validate($validationRule)) {
            return redirect()->back()
                             ->withInput()
                             ->with('validation', $this->validator);
        }

        // 2) Persiapkan folder upload
        $targetDir = FCPATH . 'uploads/developer/';
        if (! is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        // 3) Proses upload logo
        $file     = $this->request->getFile('logo');
        $filename = $file->getRandomName();
        $file->move($targetDir, $filename);

        $name = $this->request->getPost('name');
        $slug = url_title($name, '-', true);

        // Jika slug sudah ada, tambahkan angka unik
        $i = 1;
        while ($this->model->where('slug', $slug)->first()) {
            $slug = url_title($name, '-', true) . '-' . $i++;
        }

        // 4) Simpan ke database
        $this->model->insert([
            'name'      => $this->request->getPost('name'),
            'slug'      => $slug,
            'location'  => $this->request->getPost('location'),
            'logo'      => $filename,
            'created_at'=> date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
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

        // 1) Validasi
        $validationRule = [
            'name'     => 'required|min_length[3]',
            'location' => 'permit_empty',
            'logo'     => [
                'label' => 'Developer Logo',
                'rules' => 'permit_empty'
                         . '|is_image[logo]'
                         . '|mime_in[logo,image/jpg,image/jpeg,image/png,image/webp]'
                         . '|max_size[logo,2048]',
            ],
        ];
        if (! $this->validate($validationRule)) {
            return redirect()->back()
                             ->withInput()
                             ->with('validation', $this->validator);
        }

        $name = $this->request->getPost('name');
        $slug = url_title($name, '-', true);

        // Pastikan slug unik (kecuali untuk record yang sama)
        $i = 1;
        while (($dev = $this->model->where('slug', $slug)->first()) && $dev['id'] != $id) {
            $slug = url_title($name, '-', true) . '-' . $i++;
        }

        $data = [
            'name'       => $name,
            'slug'       => $slug,
            'location'   => $this->request->getPost('location'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // 3) Proses logo baru jika di-upload
        $file = $this->request->getFile('logo');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $targetDir = FCPATH . 'uploads/developer/';
            if (! is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            // Hapus logo lama jika ada
            $old = $this->model->find($id)['logo'] ?? null;
            if ($old && file_exists($targetDir . $old)) {
                unlink($targetDir . $old);
            }

            // Simpan logo baru
            $newName = $file->getRandomName();
            $file->move($targetDir, $newName);
            $data['logo'] = $newName;
        }

        // 4) Simpan update
        $this->model->update($id, $data);

        return redirect()->to(base_url('dashboard/developer'))
                         ->with('success', 'Developer updated successfully.');
    }

    public function delete($id)
    {
        $dev = $this->model->find($id);
        if ($dev) {
            // hapus file logo
            if (! empty($dev['logo']) && file_exists(WRITEPATH.'uploads/developers/'.$dev['logo'])) {
                unlink(WRITEPATH.'uploads/developers/'.$dev['logo']);
            }
            $this->model->delete($id);
        }
        return redirect()
            ->to(base_url('dashboard/developer'))
            ->with('success','Developer deleted.');
    }
}
