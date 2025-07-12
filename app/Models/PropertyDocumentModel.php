<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyDocumentModel extends Model
{
    protected $table = 'property_documents';
    protected $primaryKey = 'id';
    protected $allowedFields = ['property_id', 'type', 'title', 'file_path', 'video_url', 'created_at'];
    protected $useTimestamps = true;
}
