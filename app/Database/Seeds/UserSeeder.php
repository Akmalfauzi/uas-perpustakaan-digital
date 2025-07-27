<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Administrator',
                'email' => 'admin@perpustakaan.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role' => 'user',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role' => 'user',
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data
        $this->db->table('users')->insertBatch($data);

        echo "User seeder completed successfully!\n";
        echo "Default accounts created:\n";
        echo "Admin: admin@perpustakaan.com / admin123\n";
    }
} 