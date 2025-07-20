<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table         = 'settings';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

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
    ];

    /**
     * Get setting by key name.
     *
     * @param string $key
     * @return string|null
     */
    public function getSetting(string $key): ?string
    {
        $result = $this->select($key)->first();
        return $result[$key] ?? null;
    }

    /**
     * Get multiple settings by array of keys.
     *
     * @param array $keys
     * @return array
     */
    public function getSettings(array $keys): array
    {
        $result = $this->select($keys)->first();
        return $result ?? [];
    }

    /**
     * Update multiple settings in one call.
     *
     * @param array $data
     * @return bool
     */
    public function updateSettings(array $data): bool
    {
        return $this->update(1, $data); // asumsi ID = 1 untuk global settings
    }
}
