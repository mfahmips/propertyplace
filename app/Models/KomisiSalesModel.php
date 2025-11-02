<?php

namespace App\Models;

use CodeIgniter\Model;

class KomisiSalesModel extends Model
{
    protected $table            = 'komisi_sales';
    protected $primaryKey       = 'id';
    protected $useTimestamps    = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'booking_id',
        'user_id',
        'harga',
        'komisi',
        'status',
        'keterangan',
        'file_bukti',
        'tanggal_pengajuan',
        'updated_at',
    ];

    /**
     * Ambil data pengajuan komisi beserta join user, booking, dan properti.
     */
    public function getPengajuan($role, $userId = null)
    {
        $builder = $this->select("
                komisi_sales.*,
                users.name AS user_name,
                bookings.buyer_name,
                bookings.unit_number,
                bookings.price,
                properties.title AS property_title,
                property_type.name AS type_name
            ")
            ->join('users', 'users.id = komisi_sales.user_id', 'left')
            ->join('bookings', 'bookings.id = komisi_sales.booking_id', 'left')
            ->join('properties', 'properties.id = bookings.property_id', 'left')
            ->join('property_type', 'property_type.id = bookings.type_id', 'left')
            ->orderBy('komisi_sales.tanggal_pengajuan', 'DESC');

        if ($role !== 'admin' && $userId !== null) {
            $builder->where('komisi_sales.user_id', $userId);
        }

        return $builder->findAll();
    }
}
