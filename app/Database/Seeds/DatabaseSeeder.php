<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('AdminSeeder');
        $this->call('CustomerSeeder');
        $this->call('CategorySeeder');
        $this->call('FacilitySeeder');
        $this->call('RoomSeeder');
    }
}
