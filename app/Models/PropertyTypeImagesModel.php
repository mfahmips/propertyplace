<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyTypeImagesModel extends Model
{
    protected $table            = 'property_type_images';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'property_id',
        'type_id',
        'name_floor',
        'image',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps    = true;

    public function getByPropertyId($propertyId)
    {
        return $this->where('property_id', $propertyId)
                    ->orderBy('id', 'ASC')
                    ->findAll();
    }

}
