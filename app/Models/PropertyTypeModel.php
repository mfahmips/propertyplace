<?php

namespace App\Models;
use CodeIgniter\Model;

class PropertyTypeModel extends Model
{
    protected $table            = 'property_type';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    protected $allowedFields = [
    'property_id',
    'name',
    'slug',
    'type_unit',
    'floors',
    'land_area',
    'building_area',
    'bedrooms',
    'bathrooms',
    'carport',
    'elevator',
    'created_at',
    'updated_at'
    ];
}
