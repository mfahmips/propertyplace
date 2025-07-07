<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table         = 'settings';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';   // atau 'object' sesuai kebutuhan
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // **DI SINI** daftarkan semua kolom yang boleh di-update via insert/update massal
    protected $allowedFields = [
        'site_name',
        'tagline',
        'about',
        'location',
        'phone',
        'instagram',
        'tiktok',
        'site_logo',
        'site_icon',
        'timezone',
        'language',
        'date_format',
        'datetime_format',
        'maintenance',
        // plus kolom lain yang ada di tabel
    ];
}
