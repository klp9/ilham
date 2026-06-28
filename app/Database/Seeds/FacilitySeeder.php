<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'          => 1,
                'name'        => 'Free Wi-Fi',
                'description' => 'High speed wireless internet access available throughout the room and lobby.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 2,
                'name'        => 'Air Conditioning',
                'description' => 'Individual climate control for comfort.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 3,
                'name'        => 'Flat-screen TV',
                'description' => 'Smart LED TV with premium international channels.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 4,
                'name'        => 'Mini Bar',
                'description' => 'Fully stocked refrigerator with refreshments and snacks.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 5,
                'name'        => 'Swimming Pool Access',
                'description' => 'Complimentary access to our pool.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('facilities')->insertBatch($data);
    }
}
