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
        'name', 'slug', 'email', 'password', 'role', 'is_active', 'foto'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Validation untuk INSERT (default)
     */
    protected $validationRules = [
        'name'      => 'required|min_length[3]',
        'email'     => 'required|valid_email|is_unique[users.email]',
        'password'  => 'required|min_length[6]',
        'role'      => 'required|in_list[admin,karyawan,customer]',
        'is_active' => 'required|in_list[0,1]',
        'foto'      => 'permit_empty|uploaded[foto]|is_image[foto]|max_size[foto,2048]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah digunakan oleh user lain.',
        ],
        'password' => [
            'min_length' => 'Password minimal 6 karakter.',
            'required'   => 'Password wajib diisi.',
        ],
        'foto' => [
            'is_image'  => 'File harus berupa gambar.',
            'max_size'  => 'Ukuran maksimal gambar 2MB.',
        ]
    ];

    protected $skipValidation = false;

    /**
     * Custom validation untuk UPDATE user.
     * - Email unik kecuali untuk user yang sedang diupdate
     * - Password optional saat update
     */
    public function getUpdateRules($id)
    {
        return [
            'name'     => 'required|min_length[3]',
            'email'    => "required|valid_email|is_unique[users.email,id,{$id}]",
            'password' => 'permit_empty|min_length[6]',
            'role'     => 'required|in_list[admin,karyawan,customer]',
            'foto'     => 'permit_empty'
        ];
    }

}
