<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $table = 'properties';
    protected $primaryKey = 'id';

    // Sesuai kolom dalam tabel properties
    protected $allowedFields = [
        'title',
        'slug',
        'thumbnail',
        'developer_id',
        'created_at'
    ];

    // Aktifkan hanya created_at karena kolom updated_at tidak tersedia
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = ''; // Tidak digunakan karena tidak ada di DB

    /**
     * Join developer data untuk listing
     */
    public function withDeveloper()
    {
        return $this->select('properties.*, developers.name AS dev_name, developers.logo AS dev_logo, developers.location AS dev_location')
                    ->join('developers', 'developers.id = properties.developer_id', 'left');
    }
}
