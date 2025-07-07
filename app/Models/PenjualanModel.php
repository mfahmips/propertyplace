<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjualanModel extends Model
{
    protected $table            = 'penjualan';    // nama tabel
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'tanggal',
        'total',
        'customer_id'
    ];

    protected $useTimestamps = true;
}
