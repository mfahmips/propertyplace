<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyDetailModel extends Model
{
    protected $table = 'property_details';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'property_id', 'rooms', 'bedrooms', 'bathrooms', 'sqft',
        'type', 'purpose', 'parking', 'elevator', 'wifi'
    ];
}
