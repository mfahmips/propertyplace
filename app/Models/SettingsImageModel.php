<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsImageModel extends Model
{
    protected $table      = 'settings_images';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'type', 'filename',
        'status', 'sort_order', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional: Default ordering
    protected $order = ['sort_order' => 'ASC'];

    /**
     * Ambil semua banner aktif untuk frontend
     */
    public function getActiveBanners($type = null)
    {
        $builder = $this->where('status', 'active');
        if ($type !== null) {
            $builder->where('type', $type);
        }
        return $builder->orderBy('sort_order', 'ASC')->findAll();
    }

    /**
     * Ambil semua banner dengan filter status dan type
     */
    public function getAllBanners($filter = [])
    {
        $builder = $this;
        if (!empty($filter['status'])) {
            $builder->where('status', $filter['status']);
        }
        if (!empty($filter['type'])) {
            $builder->where('type', $filter['type']);
        }
        return $builder->orderBy('sort_order', 'ASC')->findAll();
    }
}
