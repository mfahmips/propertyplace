<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Manajemen User',
            'breadcrumb' => [['label' => 'Dashboard'], ['label' => 'User']],
            'users'      => $this->userModel->findAll(),
            'roles'      => ['admin', 'sales', 'management'],
            'errors'     => session()->getFlashdata('validation') ? session()->getFlashdata('validation')->getErrors() : []
        ];

        return view('admin/user/index', $data);
    }


    public function store()
{
    $rules = [
        'name'     => 'required|min_length[3]',
        'username' => 'required|alpha_dash|is_unique[users.username]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'role'     => 'required|in_list[admin,sales,management]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->to('/dashboard/user')->withInput()->with('validation', \Config\Services::validation());
    }

    if (!$this->userModel->save([
        'name'     => $this->request->getPost('name'), // ← INI WAJIB ADA
        'username' => $this->request->getPost('username'),
        'slug'     => url_title($this->request->getPost('username'), '-', true),
        'email'    => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'role'     => $this->request->getPost('role'),
        'is_active'=> 1
    ])) {
        return redirect()->to('/dashboard/user')->withInput()->with('errors', $this->userModel->errors());
    }

    return redirect()->to('/dashboard/user')->with('success', 'User berhasil ditambahkan');
}






    public function update($id)
{
    $user = $this->userModel->find($id);
    if (!$user) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User tidak ditemukan.");
    }

    $rules = $this->userModel->getUpdateRules($id);
    $rules['username'] = "required|alpha_dash|is_unique[users.username,id,{$id}]";

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('validation', \Config\Services::validation());
    }

    $slugBaru = url_title($this->request->getPost('name'), '-', true);
    $tglLahir = $this->request->getPost('date_of_birth');
    $tglFormatted = $tglLahir ? date('Y-m-d', strtotime(str_replace('/', '-', $tglLahir))) : null;

    // Gabungkan alamat split dari form
    $splitAddress = array_filter([
        $this->request->getPost('street'),
        $this->request->getPost('village'),
        $this->request->getPost('district'),
        $this->request->getPost('regency'),
        $this->request->getPost('province'),
        $this->request->getPost('country'),
        $this->request->getPost('zip')
    ]);
    $gabunganAlamat = implode(', ', $splitAddress);

    $data = [
        'id'              => $id,
        'name'            => $this->request->getPost('name'),
        'username'        => $this->request->getPost('username'),
        'slug'            => $slugBaru,
        'email'           => $this->request->getPost('email'),
        'role'            => $this->request->getPost('role'),
        'position'        => $this->request->getPost('position'),
        'gender'          => $this->request->getPost('gender'),
        'place_of_birth'  => $this->request->getPost('place_of_birth'),
        'date_of_birth'   => $tglFormatted,
        'address'         => $this->request->getPost('address') ?: $gabunganAlamat,
        'phone'           => $this->request->getPost('phone'),
        'facebook'        => $this->request->getPost('facebook'),
        'instagram'       => $this->request->getPost('instagram'),
        'tiktok'          => $this->request->getPost('tiktok')
    ];

    // Jika password diisi, update
    if ($this->request->getPost('password')) {
        $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
    }

    // Upload foto jika diganti
    $foto = $this->request->getFile('foto');
    if ($foto && $foto->isValid() && !$foto->hasMoved()) {
        $fotoName = $foto->getRandomName();
        $foto->move(FCPATH . 'uploads/user', $fotoName);

        if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/user/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/user/' . $user['foto']);
        }

        $data['foto'] = $fotoName;
    }

    $this->userModel->save($data);
    return redirect()->back()->with('success', 'Profil berhasil diperbarui');
}


    public function profile($slug = null)
{
    $sessionRole = session()->get('role');
    $sessionId   = session()->get('id');

    // Jika admin dan slug tersedia, ambil user berdasarkan slug
    if ($slug && $sessionRole === 'admin') {
        $user = $this->userModel->where('slug', $slug)->first();
    } else {
        // Selain admin atau tanpa slug, ambil berdasarkan session login
        $user = $this->userModel->find($sessionId);
    }

    if (!$user) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User tidak ditemukan.');
    }

    // Pisah address
    $addressParts = explode(',', $user['address']);
    $data = [
        'street'   => trim($addressParts[0] ?? ''),
        'village'  => trim($addressParts[1] ?? ''),
        'district' => trim($addressParts[2] ?? ''),
        'regency'  => trim($addressParts[3] ?? ''),
        'province' => trim($addressParts[4] ?? ''),
        'zip'      => trim($addressParts[5] ?? ''),
    ];

    return view('admin/user/profile', [
        'title'      => 'Profil ' . esc($user['name']),
        'breadcrumb' => [
            ['label' => 'Dashboard', 'url' => base_url('dashboard')],
            ['label' => 'User', 'url' => base_url('dashboard/user')],
            ['label' => 'Profil'],
        ],
        'user'       => (array) $user,
        'street'     => $data['street'],
        'village'    => $data['village'],
        'district'   => $data['district'],
        'regency'    => $data['regency'],
        'province'   => $data['province'],
        'zip'        => $data['zip'],
    ]);
}



    public function autosave()
    {
        $userId = $this->request->getPost('id') ?? session('id');
        $field  = $this->request->getPost('field');
        $value  = $this->request->getPost('value');

        // Daftar field yang diizinkan untuk autosave
        $allowed = [
            'name', 'username', 'phone', 'gender', 'place_of_birth', 'date_of_birth', 'position',
            'facebook', 'instagram', 'tiktok', 'address'
        ];

        if (!in_array($field, $allowed)) {
            return $this->response->setStatusCode(400)->setJSON(['message' => 'Field tidak diizinkan']);
        }

        // Validasi tambahan untuk username (optional)
        if ($field === 'username') {
            $exists = $this->userModel->where('username', $value)->where('id !=', $userId)->first();
            if ($exists) {
                return $this->response->setStatusCode(409)->setJSON(['message' => 'Username sudah digunakan']);
            }
        }

        // Simpan perubahan
        $this->userModel->update($userId, [$field => $value ?: null]);

        return $this->response->setJSON(['message' => 'Data berhasil disimpan']);
    }

    public function updatePassword()
    {
        $userId = session('id');

        $currentPassword = $this->request->getPost('current_password');
        $newPassword     = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        $user = $this->userModel->find($userId);
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Password saat ini salah.');
        }

        if ($newPassword !== $confirmPassword) {
            return redirect()->back()->with('error', 'Konfirmasi password tidak cocok.');
        }

        $this->userModel->update($userId, ['password' => password_hash($newPassword, PASSWORD_DEFAULT)]);
        return redirect()->back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updateRole($id)
    {
        if (session('role') !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $role = $this->request->getPost('role');
        $this->userModel->update($id, ['role' => $role]);

        return redirect()->back()->with('success', 'Role berhasil diperbarui');
    }

    public function updateStatus($id)
    {
        if (session('role') !== 'admin') {
            return redirect()->back()->with('error', 'Akses ditolak');
        }

        $status = $this->request->getPost('is_active') == 1 ? 1 : 0;
        $this->userModel->update($id, ['is_active' => $status]);

        return redirect()->back()->with('success', 'Status user diperbarui');
    }




    public function delete($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->to('/dashboard/user')->with('error', 'User tidak ditemukan.');

        if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/user/' . $user['foto'])) {
            unlink(FCPATH . 'uploads/user/' . $user['foto']);
        }

        $this->userModel->delete($id);
        return redirect()->to('/dashboard/user')->with('success', 'User berhasil dihapus');
    }

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
