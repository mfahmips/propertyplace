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

    /**
     * Daftar field yang dapat diubah lewat sistem admin.
     * Termasuk konfigurasi umum + warna tema.
     */
    protected $allowedFields = [
        // General info
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

        // 🎨 Theme colors
        'theme_primary_color',
        'theme_primary_hover',
        'theme_background_color',
        'theme_panel_color',
        'theme_card_color',
        'theme_text_color',
        'theme_muted_text_color',
    ];

    /**
     * Ambil satu setting berdasarkan key.
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
     * Ambil beberapa setting sekaligus berdasarkan array key.
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
     * Update beberapa setting sekaligus.
     * Asumsi: hanya ada satu baris global settings dengan ID=1.
     *
     * @param array $data
     * @return bool
     */
    public function updateSettings(array $data): bool
    {
        return $this->update(1, $data);
    }
}
