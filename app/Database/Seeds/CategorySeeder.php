<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'          => 1,
                'name'        => 'Standard',
                'description' => 'Comfortable and affordable room featuring standard amenities, double bed, free Wi-Fi, and a desk.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 2,
                'name'        => 'Deluxe',
                'description' => 'More spacious room with enhanced facilities, king-sized bed, city view, mini-bar, and modern bathroom.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 3,
                'name'        => 'Suite',
                'description' => 'Luxurious suite with separate living area, premium entertainment system, bath tub, and complimentary room service.',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('categories')->insertBatch($data);
    }
}
