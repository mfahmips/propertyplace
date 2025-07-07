<?php namespace App\Models;

use CodeIgniter\Model;

class DeveloperModel extends Model
{
    protected $table         = 'developers';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['name', 'logo', 'location'];
}
