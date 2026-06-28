<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $rooms = [
            [
                'id'          => 1,
                'category_id' => 1,
                'room_number' => '101',
                'price'       => 250000.00,
                'status'      => 'available',
                'description' => 'Cozy standard room located on the first floor. Perfect for solo travelers or couples.',
                'image'       => 'room_101.jpg',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 2,
                'category_id' => 1,
                'room_number' => '102',
                'price'       => 250000.00,
                'status'      => 'available',
                'description' => 'Cozy standard room with twin beds on the first floor, featuring dynamic view of garden.',
                'image'       => 'room_102.jpg',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 3,
                'category_id' => 2,
                'room_number' => '201',
                'price'       => 500000.00,
                'status'      => 'available',
                'description' => 'Spacious Deluxe room on the second floor with king-size bed and modern bathroom setup.',
                'image'       => 'room_201.jpg',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 4,
                'category_id' => 2,
                'room_number' => '202',
                'price'       => 500000.00,
                'status'      => 'available',
                'description' => 'Spacious Deluxe room on the second floor with king-size bed and modern balcony view.',
                'image'       => 'room_202.jpg',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 5,
                'category_id' => 3,
                'room_number' => '301',
                'price'       => 1200000.00,
                'status'      => 'available',
                'description' => 'Royal Suite room on the penthouse level. Features full living space and high-end styling.',
                'image'       => 'room_301.jpg',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'id'          => 6,
                'category_id' => 3,
                'room_number' => '302',
                'price'       => 1200000.00,
                'status'      => 'available',
                'description' => 'Presidential Suite with private terrace, pool entry access, and ultimate style & decoration.',
                'image'       => 'room_302.jpg',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('rooms')->insertBatch($rooms);

        // Seeding room facilities pivot
        $pivot = [
            // Room 101 (WiFi, AC, TV)
            ['room_id' => 1, 'facility_id' => 1],
            ['room_id' => 1, 'facility_id' => 2],
            ['room_id' => 1, 'facility_id' => 3],
            // Room 102 (WiFi, AC, TV)
            ['room_id' => 2, 'facility_id' => 1],
            ['room_id' => 2, 'facility_id' => 2],
            ['room_id' => 2, 'facility_id' => 3],
            // Room 201 (WiFi, AC, TV, MiniBar)
            ['room_id' => 3, 'facility_id' => 1],
            ['room_id' => 3, 'facility_id' => 2],
            ['room_id' => 3, 'facility_id' => 3],
            ['room_id' => 3, 'facility_id' => 4],
            // Room 202 (WiFi, AC, TV, MiniBar)
            ['room_id' => 4, 'facility_id' => 1],
            ['room_id' => 4, 'facility_id' => 2],
            ['room_id' => 4, 'facility_id' => 3],
            ['room_id' => 4, 'facility_id' => 4],
            // Room 301 (WiFi, AC, TV, MiniBar, Pool Access)
            ['room_id' => 5, 'facility_id' => 1],
            ['room_id' => 5, 'facility_id' => 2],
            ['room_id' => 5, 'facility_id' => 3],
            ['room_id' => 5, 'facility_id' => 4],
            ['room_id' => 5, 'facility_id' => 5],
            // Room 302 (WiFi, AC, TV, MiniBar, Pool Access)
            ['room_id' => 6, 'facility_id' => 1],
            ['room_id' => 6, 'facility_id' => 2],
            ['room_id' => 6, 'facility_id' => 3],
            ['room_id' => 6, 'facility_id' => 4],
            ['room_id' => 6, 'facility_id' => 5],
        ];

        $this->db->table('room_facilities')->insertBatch($pivot);
    }
}
