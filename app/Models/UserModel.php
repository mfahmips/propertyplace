<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name', 'username', 'slug', 'email', 'password', 'role', 'position', 'is_active',
        'foto', 'gender', 'place_of_birth', 'date_of_birth', 'address',
        'phone', 'facebook', 'instagram', 'tiktok'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name'     => 'required|min_length[3]',
        'username' => 'required|alpha_dash|is_unique[users.username]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'role'     => 'required|in_list[admin,sales,management]',
        'position' => 'permit_empty|string|max_length[100]',
        'is_active'=> 'permit_empty|in_list[0,1]',
        'foto'     => 'permit_empty|is_image[foto]|max_size[foto,2048]',
        'phone'    => 'permit_empty|max_length[20]',
        'facebook' => 'permit_empty|regex_match[/^[a-zA-Z0-9_.]+$/]',
        'instagram'=> 'permit_empty|regex_match[/^[a-zA-Z0-9_.]+$/]',
        'tiktok'   => 'permit_empty|regex_match[/^[a-zA-Z0-9_.]+$/]',
        'gender'   => 'permit_empty|in_list[Laki-laki,Perempuan]',
        'place_of_birth' => 'permit_empty|string|max_length[100]',
        'date_of_birth'  => 'permit_empty|regex_match[/^\d{4}-\d{2}-\d{2}$/]',
        'address'  => 'permit_empty|string'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah digunakan.',
        ],
        'username' => [
            'is_unique'   => 'Username sudah digunakan.',
            'alpha_dash'  => 'Username hanya boleh huruf, angka, garis bawah, dan strip.',
        ],
        'password' => [
            'required'   => 'Password wajib diisi.',
            'min_length' => 'Password minimal 6 karakter.',
        ],
        'foto' => [
            'is_image' => 'File harus berupa gambar.',
            'max_size' => 'Ukuran maksimal foto 2MB.',
        ],
        'date_of_birth' => [
            'regex_match' => 'Format tanggal lahir harus YYYY-MM-DD.',
        ],
        'facebook' => [
            'regex_match' => 'Hanya boleh huruf, angka, titik, dan underscore.',
        ],
        'instagram' => [
            'regex_match' => 'Hanya boleh huruf, angka, titik, dan underscore.',
        ],
        'tiktok' => [
            'regex_match' => 'Hanya boleh huruf, angka, titik, dan underscore.',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Validation rules untuk update user (allow same email/username)
     *
     * @param int $id
     * @return array
     */
    public function getUpdateRules($id)
    {
        return [
            'name'     => 'required|min_length[3]',
            'username' => "required|alpha_dash|is_unique[users.username,id,{$id}]",
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
            'password' => 'permit_empty|min_length[6]',
            'role'     => 'required|in_list[admin,sales,management]',
            'position' => 'permit_empty|string|max_length[100]',
            'foto'     => 'permit_empty|is_image[foto]|max_size[foto,2048]',
            'phone'    => 'permit_empty|max_length[20]',
            'facebook' => 'permit_empty|regex_match[/^[a-zA-Z0-9_.]+$/]',
            'instagram'=> 'permit_empty|regex_match[/^[a-zA-Z0-9_.]+$/]',
            'tiktok'   => 'permit_empty|regex_match[/^[a-zA-Z0-9_.]+$/]',
            'gender'   => 'permit_empty|in_list[Laki-laki,Perempuan]',
            'place_of_birth' => 'permit_empty|string|max_length[100]',
            'date_of_birth'  => 'permit_empty|regex_match[/^\d{4}-\d{2}-\d{2}$/]',
            'address'  => 'permit_empty|string'
        ];
    }
}
