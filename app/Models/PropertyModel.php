<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $table = 'properties';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'slug',
        'thumbnail',
        'developer_id',
        'created_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $useSoftDeletes = false;

    /**
     * Join developer info
     */
    public function withDeveloper()
    {
        return $this->select('
                properties.id,
                properties.title,
                properties.slug,
                properties.thumbnail,
                developers.name AS developer_name,
                developers.logo AS developer_logo,
                developers.location AS developer_location
            ')
            ->join('developers', 'developers.id = properties.developer_id', 'left');
    }

    /**
     * Join property details
     */
    public function withDetails()
    {
        return $this->select('
                properties.*,
                property_details.price_text,
                property_details.location,
                property_details.type,
                property_details.purpose
            ')
            ->join('property_details', 'property_details.property_id = properties.id', 'left');
    }
}
