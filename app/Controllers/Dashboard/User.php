<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\Images\Image;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ✅ INDEX USER
    public function index()
    {
        $data = [
            'title' => 'Manajemen User',
            'breadcrumb' => [['label' => 'Dashboard'], ['label' => 'User']],
            'users' => $this->userModel->findAll(),
        ];

        return view('admin/user/index', $data);
    }

    // ✅ FORM TAMBAH
    public function create()
    {
        $data = [
            'title'      => 'Tambah User',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'User', 'url' => base_url('dashboard/user')],
                ['label' => 'Tambah']
            ],
            'roles' => ['admin', 'karyawan', 'customer'],
            'validation' => \Config\Services::validation()
        ];

        return view('admin/user/create', $data);
    }


    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,karyawan,customer]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
        }

        $fotoName = null;
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();

            // Simpan sementara
            $tempPath = $foto->getTempName();

            // Crop 1:1 dan simpan
            \Config\Services::image()
                ->withFile($tempPath)
                ->fit(300, 300, 'center')
                ->save(FCPATH . 'uploads/user/' . $fotoName);
        }

        $slug = url_title($this->request->getPost('name'), '-', true);

        $this->userModel->save([
            'name'      => $this->request->getPost('name'),
            'slug'      => $slug,
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'      => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active') ?? 1,
            'foto'      => $fotoName
        ]);

        return redirect()->to('/dashboard/user')->with('success', 'User berhasil ditambahkan');
    }


    public function edit($slug)
    {
        // Ambil user berdasarkan slug
        $user = $this->userModel->where('slug', $slug)->first();

        // Jika tidak ditemukan, lempar error 404
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan.");
        }

        // Cek role user yang sedang login
        $isAdmin = session()->get('role') === 'admin';

        // Tentukan breadcrumb berdasarkan role
        $breadcrumb = $isAdmin
            ? [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'User', 'url' => base_url('dashboard/user')],
                ['label' => 'Edit']
            ]
            : [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'Profile', 'url' => base_url('dashboard/user/profile')],
                ['label' => 'Edit Profile']
            ];

        // Kirim data ke view
        $data = [
            'title'      => $isAdmin ? 'Edit User' : 'Edit Profile',
            'breadcrumb' => $breadcrumb,
            'user'       => $user,
            'roles'      => ['admin', 'karyawan', 'customer'],
            'validation' => \Config\Services::validation()
        ];

        return view('admin/user/edit', $data);
    }





    public function update($slug)
    {
        $user = $this->userModel->where('slug', $slug)->first();
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan.");
        }

        $id = $user['id'];

        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'     => 'required|in_list[admin,karyawan,customer]',
            'password' => 'permit_empty|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
        }

        $slugBaru = url_title($this->request->getPost('name'), '-', true);
        $fotoName = $user['foto'];

        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama
            if ($fotoName && file_exists(FCPATH . 'uploads/user/' . $fotoName)) {
                unlink(FCPATH . 'uploads/user/' . $fotoName);
            }

            $fotoName = $foto->getRandomName();
            $tempPath = $foto->getTempName();

            \Config\Services::image()
                ->withFile($tempPath)
                ->fit(300, 300, 'center')
                ->save(FCPATH . 'uploads/user/' . $fotoName);
        }

        $data = [
            'id'        => $id,
            'name'      => $this->request->getPost('name'),
            'slug'      => $slugBaru,
            'email'     => $this->request->getPost('email'),
            'role'      => session()->get('role') === 'admin' ? $this->request->getPost('role') : $user['role'],
            'is_active' => session()->get('role') === 'admin' ? $this->request->getPost('is_active') : $user['is_active'],
            'foto'      => $fotoName
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->skipValidation(true)->save($data);

        return redirect()->to('/dashboard/user')->with('success', 'User berhasil diperbarui');
    }


   public function profile()
    {
        $userId = session()->get('id'); // pastikan ID user disimpan saat login

        $user = $this->userModel->find($userId); // ambil user lengkap dari database

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan.');
        }

        $data = [
            'title'      => 'Profile Saya',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'User', 'url' => base_url('dashboard/user')],
                ['label' => 'Profile'],
            ],
            'user' => $user,
        ];

        return view('admin/user/profile', $data);
    }





    // ✅ HAPUS
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/dashboard/user')->with('error', 'User tidak ditemukan.');
        }

        // Hapus foto
        if ($user['foto'] && file_exists('uploads/user/' . $user['foto'])) {
            unlink('uploads/user/' . $user['foto']);
        }

        $this->userModel->delete($id);
        return redirect()->to('/dashboard/user')->with('success', 'User berhasil dihapus');
    }

    public function deletePhoto($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/dashboard/user')->with('error', 'User tidak ditemukan.');
        }

        if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/user/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/user/' . $user['foto']);
        }

        $this->userModel->update($id, ['foto' => null]);

        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }

}
