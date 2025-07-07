<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';    // nama tabel
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'nama',
        'email',
        'phone'
    ];

    protected $useTimestamps = true;
}
