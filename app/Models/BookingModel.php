<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table         = 'bookings';
    protected $primaryKey    = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'developer_id','property_id','type_id','unit_number',
        'buyer_name','buyer_phone','buyer_email',
        'price','payment_plan','deposit_amount','deposit_receipt',
        'status','reserved_by_user_id','reserved_at','expires_at','notes'
    ];

    // booking dianggap "aktif" bila status reserved/confirmed dan belum expired
    public function hasActiveBooking($propertyId, $typeId, ?string $unitNumber): bool
    {
        $builder = $this->where('property_id', $propertyId)
            ->where('type_id', $typeId)
            ->whereIn('status', ['reserved','confirmed']);

        if ($unitNumber !== null && $unitNumber !== '') {
            $builder->where('unit_number', $unitNumber);
        }

        // abaikan yang sudah lewat expires_at (jika diset dan expired)
        $builder->groupStart()
                ->where('expires_at IS NULL')
                ->orWhere('expires_at >=', date('Y-m-d H:i:s'))
                ->groupEnd();

        return $builder->countAllResults() > 0;
    }
}
