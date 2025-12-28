<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Sample Kartu Keluarga
        $kkData = [
            [
                'no_kk' => '3201012301230001',
                'kepala_keluarga' => 'Budi Santoso',
                'alamat' => 'Jl. Mawar No. 12 RT 001 RW 005',
                'rt' => '001',
                'rw' => '005',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'no_kk' => '3201012301230002',
                'kepala_keluarga' => 'Ahmad Hidayat',
                'alamat' => 'Jl. Melati No. 45 RT 001 RW 005',
                'rt' => '001',
                'rw' => '005',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'no_kk' => '3201012301230003',
                'kepala_keluarga' => 'Siti Nurhaliza',
                'alamat' => 'Jl. Anggrek No. 78 RT 001 RW 005',
                'rt' => '001',
                'rw' => '005',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'no_kk' => '3201012301230004',
                'kepala_keluarga' => 'Eko Prasetyo',
                'alamat' => 'Jl. Kenanga No. 23 RT 001 RW 005',
                'rt' => '001',
                'rw' => '005',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'no_kk' => '3201012301230005',
                'kepala_keluarga' => 'Dewi Lestari',
                'alamat' => 'Jl. Sakura No. 56 RT 001 RW 005',
                'rt' => '001',
                'rw' => '005',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('kartu_keluarga')->insertBatch($kkData);
        echo "✓ 5 Kartu Keluarga created\n";

        // Sample Warga (members for each KK)
        $wargaData = [
            // KK 1 - Budi Santoso
            [
                'kk_id' => 1,
                'nik' => '3201011980010001',
                'nama_lengkap' => 'Budi Santoso',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1980-01-15',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'Pegawai Swasta',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Kepala Keluarga',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kk_id' => 1,
                'nik' => '3201011982050002',
                'nama_lengkap' => 'Sri Rahayu',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '1982-05-20',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Istri',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kk_id' => 1,
                'nik' => '3201012010030003',
                'nama_lengkap' => 'Andi Santoso',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2010-03-10',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'Pelajar',
                'status_perkawinan' => 'Belum Kawin',
                'status_keluarga' => 'Anak',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            // KK 2 - Ahmad Hidayat
            [
                'kk_id' => 2,
                'nik' => '3201011975080004',
                'nama_lengkap' => 'Ahmad Hidayat',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1975-08-25',
                'jenis_kelamin' => 'L',
                'agama' => 'Islam',
                'pekerjaan' => 'Wiraswasta',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Kepala Keluarga',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kk_id' => 2,
                'nik' => '3201011978120005',
                'nama_lengkap' => 'Fatimah',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1978-12-15',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pekerjaan' => 'Guru',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Istri',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            // KK 3 - Siti Nurhaliza
            [
                'kk_id' => 3,
                'nik' => '3201011985030006',
                'nama_lengkap' => 'Siti Nurhaliza',
                'tempat_lahir' => 'Medan',
                'tanggal_lahir' => '1985-03-08',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pekerjaan' => 'Dokter',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Kepala Keluarga',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kk_id' => 3,
                'nik' => '3201012015060007',
                'nama_lengkap' => 'Zahra Amelia',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2015-06-12',
                'jenis_kelamin' => 'P',
                'agama' => 'Islam',
                'pekerjaan' => 'Pelajar',
                'status_perkawinan' => 'Belum Kawin',
                'status_keluarga' => 'Anak',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            // KK 4 - Eko Prasetyo
            [
                'kk_id' => 4,
                'nik' => '3201011990070008',
                'nama_lengkap' => 'Eko Prasetyo',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1990-07-20',
                'jenis_kelamin' => 'L',
                'agama' => 'Kristen',
                'pekerjaan' => 'Insinyur',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Kepala Keluarga',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kk_id' => 4,
                'nik' => '3201011992110009',
                'nama_lengkap' => 'Maria Kristina',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '1992-11-30',
                'jenis_kelamin' => 'P',
                'agama' => 'Kristen',
                'pekerjaan' => 'Desainer',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Istri',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            // KK 5 - Dewi Lestari
            [
                'kk_id' => 5,
                'nik' => '3201011988020010',
                'nama_lengkap' => 'Dewi Lestari',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1988-02-14',
                'jenis_kelamin' => 'P',
                'agama' => 'Hindu',
                'pekerjaan' => 'Pengusaha',
                'status_perkawinan' => 'Kawin',
                'status_keluarga' => 'Kepala Keluarga',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'kk_id' => 5,
                'nik' => '3201012018090011',
                'nama_lengkap' => 'Made Arya',
                'tempat_lahir' => 'Denpasar',
                'tanggal_lahir' => '2018-09-25',
                'jenis_kelamin' => 'L',
                'agama' => 'Hindu',
                'pekerjaan' => 'Belum/Tidak Sekolah',
                'status_perkawinan' => 'Belum Kawin',
                'status_keluarga' => 'Anak',
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('warga')->insertBatch($wargaData);
        echo "✓ 11 Warga created (across 5 KK)\n";

        // Setup iuran for each KK (all subscribe to active categories)
        $kategoriIuran = $this->db->table('kategori_iuran')
                                   ->where('is_active', 1)
                                   ->get()
                                   ->getResultArray();

        $kkIuranSetup = [];
        for ($kkId = 1; $kkId <= 5; $kkId++) {
            foreach ($kategoriIuran as $kategori) {
                $kkIuranSetup[] = [
                    'kk_id' => $kkId,
                    'kategori_iuran_id' => $kategori['id'],
                    'nominal_custom' => null, // Use default
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        $this->db->table('kk_iuran_setup')->insertBatch($kkIuranSetup);
        echo "✓ Iuran setup for 5 KK created\n";

        echo "\n========================================\n";
        echo "Sample data seeded successfully!\n";
        echo "========================================\n";
        echo "5 KK dengan 11 warga telah ditambahkan\n";
        echo "Setup iuran multi-category untuk semua KK\n";
    }
}
