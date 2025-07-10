<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $table = 'properties';
    protected $primaryKey = 'id';
    protected $allowedFields = [
            'title',
            'slug',
            'location',
            'price',
            'description',
            'thumbnail',        // ✅ tambahkan ini
            'developer_id',     // ✅ biasanya penting juga
            'type',             // opsional jika kamu pakai kategori
            'status',           // misal rent/sale
            'size',             // ukuran properti (opsional)
            // ... tambahkan kolom lainnya jika ada
        ];


    public function withDeveloper()
    {
        return $this->select('properties.*, developers.name AS dev_name, developers.logo AS dev_logo, developers.location AS dev_location')
                    ->join('developers', 'developers.id = properties.developer_id', 'left');
    }

}


