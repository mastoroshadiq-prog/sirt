<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Seed Users - Default Admin
        $this->db->table('users')->insert([
            'username' => 'admin',
            'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'nama_lengkap' => 'Administrator',
            'email' => 'admin@si-rt.local',
            'phone' => '08123456789',
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Seed Kategori Iuran
        $kategoriIuran = [
            [
                'nama_kategori' => 'Iuran Bulanan',
                'nominal_default' => 50000,
                'deskripsi' => 'Iuran rutin bulanan untuk kas RT',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Iuran Kebersihan',
                'nominal_default' => 20000,
                'deskripsi' => 'Iuran untuk kebersihan lingkungan',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Iuran Keamanan',
                'nominal_default' => 30000,
                'deskripsi' => 'Iuran untuk keamanan dan ronda',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Iuran Sosial',
                'nominal_default' => 10000,
                'deskripsi' => 'Iuran untuk kegiatan sosial dan santunan',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Iuran Khusus',
                'nominal_default' => 0,
                'deskripsi' => 'Iuran untuk keperluan khusus/event tertentu',
                'is_active' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('kategori_iuran')->insertBatch($kategoriIuran);

        // Seed Kategori Aset
        $kategoriAset = [
            [
                'nama_kategori' => 'Tanah',
                'prefix_kode' => 'TN',
                'deskripsi' => 'Tanah milik RT',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Gedung/Bangunan',
                'prefix_kode' => 'GB',
                'deskripsi' => 'Gedung atau bangunan milik RT',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Peralatan & Mesin',
                'prefix_kode' => 'PM',
                'deskripsi' => 'Peralatan dan mesin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Kendaraan',
                'prefix_kode' => 'KD',
                'deskripsi' => 'Kendaraan milik RT',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kategori' => 'Lain-lain',
                'prefix_kode' => 'LL',
                'deskripsi' => 'Aset lainnya',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('kategori_aset')->insertBatch($kategoriAset);

        echo "Initial data seeded successfully!\n";
        echo "Default admin credentials:\n";
        echo "  Username: admin\n";
        echo "  Password: admin123\n";
    }
}
