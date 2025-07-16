<?php

namespace App\Models;
use CodeIgniter\Model;

class PropertyUnitTypeModel extends Model
{
    protected $table            = 'property_unit_type';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'property_id', 'name_unit', 'slug', 'type_unit', 'floors',
        'land_area', 'building_area', 'bedrooms', 'bathrooms',
        'carport', 'elevator'
    ];
}
