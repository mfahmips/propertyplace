<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // atau 'object' sesuai kebutuhan
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name', 'slug', 'email', 'password', 'role', 'is_active', 'foto'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validasi umum (untuk store baru, bukan update)
    protected $validationRules = [
        'name'      => 'required|min_length[3]',
        'email'     => 'required|valid_email|is_unique[users.email]',
        'password'  => 'required|min_length[6]',
        'role'      => 'required|in_list[admin,karyawan,customer]',
        'is_active' => 'required|in_list[0,1]',
        'foto'      => 'permit_empty',

    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah digunakan oleh user lain.',
        ],
        'password' => [
            'min_length' => 'Password minimal 6 karakter.',
            'required'   => 'Password wajib diisi.',
        ],
    ];

    protected $skipValidation = false;
}
