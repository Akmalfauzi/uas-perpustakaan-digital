<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'setting_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'setting_value' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'setting_type' => [
                'type'       => 'ENUM',
                'constraint' => ['string', 'number', 'boolean', 'json'],
                'default'    => 'string',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('setting_key');
        $this->forge->createTable('settings');

        // Insert default settings
        $defaultSettings = [
            [
                'setting_key' => 'site_name',
                'setting_value' => 'Perpustakaan Digital',
                'setting_type' => 'string',
                'description' => 'Nama website perpustakaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'site_description',
                'setting_value' => 'Sistem Perpustakaan Digital Modern',
                'setting_type' => 'string',
                'description' => 'Deskripsi website perpustakaan',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'books_per_page',
                'setting_value' => '12',
                'setting_type' => 'number',
                'description' => 'Jumlah buku per halaman',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'max_file_size',
                'setting_value' => '50',
                'setting_type' => 'number',
                'description' => 'Ukuran file maksimal upload dalam MB',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'allow_registration',
                'setting_value' => '1',
                'setting_type' => 'boolean',
                'description' => 'Izinkan registrasi pengguna baru',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'email_verification',
                'setting_value' => '1',
                'setting_type' => 'boolean',
                'description' => 'Verifikasi email untuk akun baru',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'min_password_length',
                'setting_value' => '6',
                'setting_type' => 'number',
                'description' => 'Panjang password minimal',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'session_timeout',
                'setting_value' => '60',
                'setting_type' => 'number',
                'description' => 'Session timeout dalam menit',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'max_loan_days',
                'setting_value' => '30',
                'setting_type' => 'number',
                'description' => 'Maksimal hari peminjaman buku',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'setting_key' => 'max_loan_books',
                'setting_value' => '5',
                'setting_type' => 'number',
                'description' => 'Maksimal buku yang bisa dipinjam per user',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('settings')->insertBatch($defaultSettings);
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
} 