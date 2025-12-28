<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRondaTables extends Migration
{
    public function up()
    {
        // Table: anggota_ronda
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'warga_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'no_hp' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'is_koordinator' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'nonaktif'],
                'default' => 'aktif',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('warga_id');
        $this->forge->addForeignKey('warga_id', 'warga', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('anggota_ronda');

        // Table: jadwal_ronda
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'shift' => [
                'type' => 'ENUM',
                'constraint' => ['Shift 1 (22:00-00:00)', 'Shift 2 (00:00-02:00)', 'Shift 3 (02:00-04:00)', 'Custom'],
            ],
            'shift_custom' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'lokasi_pos' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['scheduled', 'selesai', 'dibatalkan'],
                'default' => 'scheduled',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal');
        $this->forge->createTable('jadwal_ronda');

        // Table: jadwal_ronda_anggota
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jadwal_ronda_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'anggota_ronda_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['jadwal_ronda_id', 'anggota_ronda_id']);
        $this->forge->addForeignKey('jadwal_ronda_id', 'jadwal_ronda', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('anggota_ronda_id', 'anggota_ronda', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('jadwal_ronda_anggota');

        // Table: absensi_ronda
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jadwal_ronda_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'anggota_ronda_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'check_in_time' => [
                'type' => 'DATETIME',
            ],
            'check_in_latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,8',
                'null' => true,
            ],
            'check_in_longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '11,8',
                'null' => true,
            ],
            'check_out_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'check_out_latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,8',
                'null' => true,
            ],
            'check_out_longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '11,8',
                'null' => true,
            ],
            'durasi_menit' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['hadir', 'terlambat', 'tidak_hadir'],
                'default' => 'hadir',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['jadwal_ronda_id', 'anggota_ronda_id']);
        $this->forge->addForeignKey('jadwal_ronda_id', 'jadwal_ronda', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('anggota_ronda_id', 'anggota_ronda', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('absensi_ronda');

        // Table: laporan_kejadian
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'jadwal_ronda_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'tanggal_waktu' => [
                'type' => 'DATETIME',
            ],
            'jenis_kejadian' => [
                'type' => 'ENUM',
                'constraint' => ['Keamanan', 'Kebakaran', 'Banjir', 'Kecelakaan', 'Lainnya'],
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'latitude' => [
                'type' => 'DECIMAL',
                'constraint' => '10,8',
                'null' => true,
            ],
            'longitude' => [
                'type' => 'DECIMAL',
                'constraint' => '11,8',
                'null' => true,
            ],
            'tindakan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['dilaporkan', 'ditangani', 'selesai'],
                'default' => 'dilaporkan',
            ],
            'pelapor_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal_waktu');
        $this->forge->addForeignKey('jadwal_ronda_id', 'jadwal_ronda', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('pelapor_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('laporan_kejadian');

        // Table: laporan_kejadian_foto
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'laporan_kejadian_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('laporan_kejadian_id');
        $this->forge->addForeignKey('laporan_kejadian_id', 'laporan_kejadian', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('laporan_kejadian_foto');

        // Table: kas_ronda_transaksi
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['masuk', 'keluar'],
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'uraian' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'masuk' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'keluar' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'saldo' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'bukti_file' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tanggal');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kas_ronda_transaksi');

        // Table: insentif_ronda
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'anggota_ronda_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'bulan' => [
                'type' => 'INT',
                'constraint' => 2,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'total_shift' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'nominal_insentif' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'status_bayar' => [
                'type' => 'ENUM',
                'constraint' => ['belum', 'sudah'],
                'default' => 'belum',
            ],
            'tanggal_bayar' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['anggota_ronda_id', 'bulan', 'tahun']);
        $this->forge->addForeignKey('anggota_ronda_id', 'anggota_ronda', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('insentif_ronda');
    }

    public function down()
    {
        $this->forge->dropTable('insentif_ronda');
        $this->forge->dropTable('kas_ronda_transaksi');
        $this->forge->dropTable('laporan_kejadian_foto');
        $this->forge->dropTable('laporan_kejadian');
        $this->forge->dropTable('absensi_ronda');
        $this->forge->dropTable('jadwal_ronda_anggota');
        $this->forge->dropTable('jadwal_ronda');
        $this->forge->dropTable('anggota_ronda');
    }
}
