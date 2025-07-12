<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyFloorPlanModel extends Model
{
    protected $table            = 'property_floor_plan';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'property_id',
        'name',
        'image',
        'description',
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
