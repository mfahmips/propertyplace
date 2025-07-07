<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyImageModel extends Model
{
    protected $table = 'property_images';
    protected $primaryKey = 'id';
    protected $allowedFields = ['property_id', 'slug','filename', 'created_at'];
}
