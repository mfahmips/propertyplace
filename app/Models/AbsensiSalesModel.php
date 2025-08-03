<?php

namespace App\Models;

use CodeIgniter\Model;

class AbsensiSalesModel extends Model
{
    protected $table      = 'absensi_sales';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'tanggal',
        'lokasi_pameran',
        'waktu_masuk',
        'foto_masuk',
        'waktu_keluar',
        'foto_pulang',
        'database_pameran',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
