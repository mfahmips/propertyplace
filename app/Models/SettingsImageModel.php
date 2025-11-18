<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsImageModel extends Model
{
    protected $table            = 'settings_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'type',           // Jenis gambar (banner, logo, background, dsb)
        'filename',       // Nama file gambar
        'status',         // 'active' atau 'inactive'
        'sort_order',     // Urutan tampilan
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Optional soft delete
    protected $useSoftDeletes = false;
    protected $deletedField   = 'deleted_at';

    // Default order
    protected $orderBy = ['sort_order' => 'ASC'];

    /**
     * Ambil semua banner aktif (untuk frontend)
     *
     * @param string|null $type Jenis gambar (misal 'banner', 'hero', 'logo')
     * @return array
     */
    public function getActiveBanners(?string $type = null): array
    {
        $builder = $this->where('status', 'active');

        if (!empty($type)) {
            $builder->where('type', $type);
        }

        return $builder->orderBy('sort_order', 'ASC')->findAll();
    }

    /**
     * Ambil semua banner (untuk dashboard)
     *
     * @param array $filter ['status' => 'active', 'type' => 'banner']
     * @return array
     */
    public function getAllBanners(array $filter = []): array
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

    /**
     * Simpan atau update gambar
     *
     * @param array $data
     * @return bool|int|string
     */
    public function saveImage(array $data)
    {
        if (!empty($data['id'])) {
            return $this->update($data['id'], $data);
        }
        return $this->insert($data);
    }

    /**
     * Nonaktifkan gambar tertentu
     */
    public function deactivateImage(int $id): bool
    {
        return $this->update($id, ['status' => 'inactive']);
    }

    /**
     * Aktifkan gambar tertentu
     */
    public function activateImage(int $id): bool
    {
        return $this->update($id, ['status' => 'active']);
    }

    /**
     * Hapus gambar (fisik opsional)
     */
    public function deleteImage(int $id, bool $deleteFile = false): bool
    {
        $image = $this->find($id);

        if ($deleteFile && !empty($image['filename'])) {
            $path = FCPATH . 'uploads/settings/' . $image['filename'];
            if (is_file($path)) {
                unlink($path);
            }
        }

        return $this->delete($id);
    }
}
