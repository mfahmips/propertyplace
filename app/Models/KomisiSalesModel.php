<?php

namespace App\Models;

use CodeIgniter\Model;

class KomisiSalesModel extends Model
{
    protected $table            = 'komisi_sales';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true; // agar created_at & updated_at otomatis
    protected $allowedFields    = [
        'booking_id',
        'user_id',
        'komisi_persen',
        'komisi_nominal',
        'status',
        'tanggal_ajuan',
        'tanggal_acc',
        'catatan',
        'created_at',
        'updated_at',
    ];
}
