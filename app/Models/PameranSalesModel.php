<?php

namespace App\Models;

use CodeIgniter\Model;

class PameranSalesModel extends Model
{
    protected $table      = 'pameran_sales';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'lokasi',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
