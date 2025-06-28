<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $table = 'properties';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'location', 'price', 'description', 'created_at'];
}
