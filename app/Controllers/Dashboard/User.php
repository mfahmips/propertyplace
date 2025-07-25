<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // INDEX + modal add/edit
    public function index()
    {
        $data = [
            'title'      => 'Manajemen User',
            'breadcrumb' => [['label' => 'Dashboard'], ['label' => 'User']],
            'users'      => $this->userModel->findAll(),
            'roles'      => ['admin', 'karyawan', 'customer'],
            'errors'     => session()->getFlashdata('validation') ? session()->getFlashdata('validation')->getErrors() : []
        ];

        return view('admin/user/index', $data);
    }

    // STORE USER (Tambah)
    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,karyawan,customer]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/dashboard/user')->withInput()->with('validation', \Config\Services::validation());
        }

        $fotoName = null;
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();

            $uploadPath = FCPATH . 'uploads/user/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $foto->move($uploadPath, $fotoName);
        }

        $slug = url_title($this->request->getPost('name'), '-', true);

        $this->userModel->save([
            'name'      => $this->request->getPost('name'),
            'slug'      => $slug,
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'      => $this->request->getPost('role'),
            'is_active' => 1,
            'foto'      => $fotoName
        ]);

        return redirect()->to('/dashboard/user')->with('success', 'User berhasil ditambahkan');
    }

    // UPDATE USER (Edit by ID)
   public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan.");
        }

        // Gunakan validasi custom dari model agar aman untuk update (email unik kecuali milik sendiri)
        $rules = $this->userModel->getUpdateRules($id);

        if (!$this->validate($rules)) {
            return redirect()->to('/dashboard/user')->withInput()->with('validation', \Config\Services::validation());
        }

        $slugBaru = url_title($this->request->getPost('name'), '-', true);

        // DATA yang akan diupdate WAJIB ada 'id' agar save() -> update, bukan insert!
        $data = [
            'id'    => $id, // ✅ INI YANG PENTING
            'name'  => $this->request->getPost('name'),
            'slug'  => $slugBaru,
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];

        // Optional update password
        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Upload foto jika ada
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/user', $fotoName);

            // Hapus foto lama jika ada
            if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/user/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/user/' . $user['foto']);
            }

            $data['foto'] = $fotoName;
        }

        // Pakai save agar update by ID, bukan insert baru
        $this->userModel->save($data);

        return redirect()->to('/dashboard/user')->with('success', 'User berhasil diupdate');
}



    // OPTIONAL: Halaman edit khusus (jika masih dipakai)
    public function edit($slug)
    {
        $user = $this->userModel->where('slug', $slug)->first();

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan.");
        }

        $data = [
            'title'      => 'Edit User',
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => base_url('dashboard')],
                ['label' => 'User', 'url' => base_url('dashboard/user')],
                ['label' => 'Edit']
            ],
            'user'       => $user,
            'roles'      => ['admin', 'karyawan', 'customer'],
            'validation' => \Config\Services::validation()
        ];

        return view('admin/user/edit', $data);
    }

    // PROFILE USER
    public function profile()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

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

    // DELETE USER
    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/dashboard/user')->with('error', 'User tidak ditemukan.');
        }

        if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/user/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/user/' . $user['foto']);
        }

        $this->userModel->delete($id);

        return redirect()->to('/dashboard/user')->with('success', 'User berhasil dihapus');
    }

    // DELETE FOTO
    public function deletePhoto($id)
    {
        $user = $this->userModel->find($id);

        if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/user/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/user/' . $user['foto']);
        }

        $this->userModel->update($id, ['foto' => null]);

        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }
}
