<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'   => 'customer',
            'email'      => 'customer@gmail.com',
            'password'   => password_hash('customer123', PASSWORD_BCRYPT),
            'role'       => 'customer',
            'fullname'   => 'Budi Customer',
            'phone'      => '082233445566',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('users')->insert($data);
    }
}
