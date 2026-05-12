<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('users')->insert([

            'nom' => 'admin',

            'email' => 'admin@email.com',

            'password' => password_hash('admin123', PASSWORD_DEFAULT),

            'role' => 'admin',

            'created_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('users')->insert([

            'nom' => 'Brandy',

            'email' => 'brandy@email.com',

            'password' => password_hash('azertyuiop', PASSWORD_DEFAULT),

            'role' => 'client',

            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}