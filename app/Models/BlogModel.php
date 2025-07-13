<?php 

namespace App\Models;

use CodeIgniter\Model;

class BlogModel extends Model
{
    protected $table = 'blogs'; // ✔ Nama tabel sesuai
    protected $primaryKey = 'id'; // ✔ Kunci utama
    protected $allowedFields = ['title', 'slug', 'content', 'cover_image']; // ✔ Field yang boleh disimpan
    protected $useTimestamps = true; // ✔ Aktifkan otomatis `created_at` dan `updated_at`
}
