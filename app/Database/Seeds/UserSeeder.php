<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Admin Demo',
                'slug'       => 'admin-demo',
                'email'      => 'admin@propertyplace.id',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'is_active'  => 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'name'       => 'Karyawan Sample',
                'slug'       => 'karyawan-sample',
                'email'      => 'karyawan@propertyplace.id',
                'password'   => password_hash('karyawan123', PASSWORD_DEFAULT),
                'role'       => 'karyawan',
                'is_active'  => 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
            [
                'name'       => 'Customer Dummy',
                'slug'       => 'customer-dummy',
                'email'      => 'customer@propertyplace.id',
                'password'   => password_hash('customer123', PASSWORD_DEFAULT),
                'role'       => 'customer',
                'is_active'  => 1,
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
