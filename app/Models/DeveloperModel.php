<?php namespace App\Models;

use CodeIgniter\Model;

class DeveloperModel extends Model
{
    protected $table      = 'developers'; // pastikan sesuai nama tabel di database
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name',
        'slug',
        'location',
        'logo',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true; // atur true jika kamu pakai `created_at` otomatis
}
