<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyDetailModel extends Model
{
    protected $table = 'property_details';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'property_id',
        'price',
        'price_text',
        'location',
        'type',
        'purpose',
        'description',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
