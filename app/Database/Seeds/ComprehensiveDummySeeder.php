<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ComprehensiveDummySeeder extends Seeder
{
    public function run()
    {
        try {
            $db = \Config\Database::connect();
            $db->query('SET FOREIGN_KEY_CHECKS = 0;');

            echo "Cleaning up existing data...\n";
            $tables = [
                'kas_transaksi', 'laporan_kejadian', 'rencana_kegiatan', 
                'program_kerja', 'rencana_kerja_tahunan', 'jadwal_ronda', 
                'anggota_ronda', 'aset_inventaris', 'struktur_organisasi',
                'warga', 'kartu_keluarga', 'kk_iuran_setup'
            ];
            foreach ($tables as $table) {
                $db->table($table)->truncate();
            }
            $db->query('SET FOREIGN_KEY_CHECKS = 1;');

            // 1. ORGANISASI
            $db->table('struktur_organisasi')->insertBatch([
                ['nama' => 'Bp. H. Ahmad Fauzi', 'jabatan' => 'Ketua RT', 'periode_mulai' => '2024-01-01', 'periode_selesai' => '2026-12-31', 'no_hp' => '081234567801', 'is_active' => 1, 'urutan' => 1],
                ['nama' => 'Bp. Bambang Heru', 'jabatan' => 'Sekretaris', 'periode_mulai' => '2024-01-01', 'periode_selesai' => '2026-12-31', 'no_hp' => '081234567802', 'is_active' => 1, 'urutan' => 2],
                ['nama' => 'Ibu Siti Aminah', 'jabatan' => 'Bendahara', 'periode_mulai' => '2024-01-01', 'periode_selesai' => '2026-12-31', 'no_hp' => '081234567803', 'is_active' => 1, 'urutan' => 3],
            ]);

            // 2. KK & WARGA
            for ($i = 1; $i <= 10; $i++) {
                $no_kk = '320101' . date('ymd') . str_pad($i, 4, '0', STR_PAD_LEFT);
                $kkId = $db->table('kartu_keluarga')->insert([
                    'no_kk' => $no_kk,
                    'kepala_keluarga' => 'Kepala Keluarga ' . $i,
                    'alamat' => 'Blok A ' . $i,
                    'rt' => '001', 'rw' => '005', 'status' => 'aktif'
                ]);
                
                // Head
                $db->table('warga')->insert([
                    'kk_id' => $kkId, 
                    'nik' => '320101' . date('ymd') . '1' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama_lengkap' => 'Kepala Keluarga ' . $i, 
                    'tempat_lahir' => 'Jakarta',
                    'tanggal_lahir' => '1980-05-10',
                    'jenis_kelamin' => 'L',
                    'agama' => 'Islam', 
                    'pekerjaan' => 'Wirausaha',
                    'status_perkawinan' => 'Kawin',
                    'status_keluarga' => 'Kepala Keluarga', 
                    'status' => 'aktif'
                ]);
                
                // Istri
                $db->table('warga')->insert([
                    'kk_id' => $kkId, 
                    'nik' => '320101' . date('ymd') . '2' . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'nama_lengkap' => 'Istri ' . $i, 
                    'tempat_lahir' => 'Bandung',
                    'tanggal_lahir' => '1985-08-15',
                    'jenis_kelamin' => 'P',
                    'agama' => 'Islam', 
                    'pekerjaan' => 'Ibu Rumah Tangga',
                    'status_perkawinan' => 'Kawin',
                    'status_keluarga' => 'Istri', 
                    'status' => 'aktif'
                ]);

                // Optional Anak
                if ($i % 2 == 0) {
                    $db->table('warga')->insert([
                        'kk_id' => $kkId, 
                        'nik' => '320101' . date('ymd') . '3' . str_pad($i, 3, '0', STR_PAD_LEFT),
                        'nama_lengkap' => 'Anak ' . $i, 
                        'tempat_lahir' => 'Jakarta',
                        'tanggal_lahir' => '2015-10-20',
                        'jenis_kelamin' => 'L',
                        'agama' => 'Islam', 
                        'pekerjaan' => 'Pelajar',
                        'status_perkawinan' => 'Belum Kawin',
                        'status_keluarga' => 'Anak', 
                        'status' => 'aktif'
                    ]);
                }
            }

            // 3. IURAN SETUP
            $kategoriIuran = $db->table('kategori_iuran')->get()->getResultArray();
            $kkList = $db->table('kartu_keluarga')->get()->getResultArray();
            foreach ($kkList as $kk) {
                foreach ($kategoriIuran as $kat) {
                    $db->table('kk_iuran_setup')->insert([
                        'kk_id' => $kk['id'], 'kategori_iuran_id' => $kat['id'], 'is_active' => 1
                    ]);
                }
            }

            // 4. ASET
            $db->table('aset_inventaris')->insert([
                'kategori_aset_id' => 2, 
                'kode_register' => 'GB.001', 
                'nama_aset' => 'Pos Ronda Utama',
                'tanggal_perolehan' => date('Y-m-d', strtotime('-2 years')),
                'cara_perolehan' => 'Swadaya Masyarakat',
                'nilai_perolehan' => 15000000,
                'kondisi' => 'Baik', 
                'lokasi' => 'Pintu Masuk RT'
            ]);

            // 5. KEAMANAN
            $ids = [];
            for ($i = 1; $i <= 5; $i++) {
                $db->table('anggota_ronda')->insert([
                    'nama' => 'Kepala Keluarga ' . $i, 
                    'no_hp' => '0812' . str_pad($i, 8, '0', STR_PAD_LEFT),
                    'alamat' => 'Blok A ' . $i,
                    'status' => 'aktif'
                ]);
                $ids[] = $db->insertID();
            }
            
            $db->table('jadwal_ronda')->insert([
                'tanggal' => date('Y-m-d'), 
                'shift' => 'Shift 1 (22:00-00:00)', 
                'lokasi_pos' => 'Pos 1', 
                'status' => 'scheduled'
            ]);
            $jadwalId = $db->insertID();
            
            foreach ($ids as $aid) {
                $db->table('jadwal_ronda_anggota')->insert([
                    'jadwal_ronda_id' => $jadwalId,
                    'anggota_ronda_id' => $aid
                ]);
            }

            // 6. PERENCANAAN
            $db->table('rencana_kerja_tahunan')->insert([
                'tahun' => date('Y'), 'visi' => 'Visi RT ' . date('Y'), 'misi' => 'Misi RT ' . date('Y'), 
                'periode_mulai' => date('Y') . '-01-01', 'periode_selesai' => date('Y') . '-12-31', 
                'status' => 'active', 'user_id' => 1
            ]);
            $rktId = $db->insertID();

            $db->table('program_kerja')->insert([
                'rkt_id' => $rktId, 
                'nama_program' => 'Peningkatan Fasilitas Lingkungan', 
                'bidang' => 'Infrastruktur', 
                'pj_program' => 'Bp. H. Ahmad Fauzi', 
            ]);
            $progId = $db->insertID();
            
            $db->table('rencana_kegiatan')->insert([
                'program_kerja_id' => $progId, 
                'nama_kegiatan' => 'Pengecatan Gapura', 
                'timeline' => 'Triwulan I', 
                'bulan_target' => 3, 
                'status' => 'persiapan'
            ]);

            // 7. KAS
            $db->table('kas_transaksi')->insert([
                'tanggal' => date('Y-m-d'), 
                'jenis' => 'masuk', 
                'kategori' => 'Iuran rutinitas',
                'uraian' => 'Saldo Awal Kas RT', 
                'masuk' => 7500000, 
                'keluar' => 0,
                'saldo' => 7500000,
                'user_id' => 1
            ]);

            // 8. LAPORAN KEJADIAN
            $db->table('laporan_kejadian')->insert([
                'tanggal_waktu' => date('Y-m-d H:i:s'), 
                'jenis_kejadian' => 'Keamanan', 
                'lokasi' => 'Blok A', 
                'deskripsi' => 'Ditemukan orang asing mencurigakan', 
                'pelapor_id' => 1, 
                'status' => 'dilaporkan'
            ]);

            echo "✓ Comprehensive dummy data seeded successfully!\n";

        } catch (\Exception $e) {
            echo "ERROR: " . $e->getMessage() . "\n";
        }
    }
}
