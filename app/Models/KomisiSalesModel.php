<?php

namespace App\Models;

use CodeIgniter\Model;

class KomisiSalesModel extends Model
{
    protected $table      = 'komisi_sales';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'property_id',
        'developer_id',
        'harga',
        'komisi',
        'status',
        'keterangan',
        'file_bukti',
        'tanggal_pengajuan',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'tanggal_pengajuan';
    protected $updatedField  = 'updated_at';
}
