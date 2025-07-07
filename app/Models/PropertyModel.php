<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $table = 'properties';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title',
                                'slug', // pastikan ini ada
                                'location',
                                'price',
                                'description',
                                // ... kolom lain jika ada];
                                ];

    public function withDeveloper()
    {
        return $this->select('properties.*, developers.name AS dev_name, developers.logo AS dev_logo, developers.location AS dev_location')
                    ->join('developers', 'developers.id = properties.developer_id', 'left');
    }

}


