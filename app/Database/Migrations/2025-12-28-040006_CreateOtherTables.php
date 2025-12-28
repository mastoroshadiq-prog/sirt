<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOtherTables extends Migration
{
    public function up()
    {
        // Table: mutasi_warga
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
            'jenis_mutasi' => [
                'type' => 'ENUM',
                'constraint' => ['baru', 'pindah', 'meninggal', 'kelahiran'],
            ],
            'tanggal_mutasi' => [
                'type' => 'DATE',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'user_id' => [
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
        $this->forge->addKey('warga_id');
        $this->forge->addForeignKey('warga_id', 'warga', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mutasi_warga');

        // Table: kegiatan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['Gotong Royong', '17-an', 'Posyandu', 'Pengajian', 'Rapat RT', 'Lainnya'],
            ],
            'anggaran' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['direncanakan', 'sedang_berjalan', 'selesai', 'dibatalkan'],
                'default' => 'direncanakan',
            ],
            'pic_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'jumlah_peserta' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'hasil_kegiatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'kendala' => [
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
        $this->forge->addKey('tanggal');
        $this->forge->addForeignKey('pic_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kegiatan');

        // Table: kegiatan_foto
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kegiatan_id' => [
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
        $this->forge->addKey('kegiatan_id');
        $this->forge->addForeignKey('kegiatan_id', 'kegiatan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kegiatan_foto');

        // Table: pengajuan_surat
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
            ],
            'jenis_surat' => [
                'type' => 'ENUM',
                'constraint' => ['Pengantar KTP', 'Pengantar KK', 'Domisili', 'Keterangan Lainnya'],
            ],
            'keperluan' => [
                'type' => 'TEXT',
            ],
            'file_ktp' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['diajukan', 'diproses', 'selesai', 'ditolak'],
                'default' => 'diajukan',
            ],
            'alasan_tolak' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tanggal_selesai' => [
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
        $this->forge->addKey('warga_id');
        $this->forge->addForeignKey('warga_id', 'warga', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengajuan_surat');

        // Table: pengaduan
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
            ],
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['Kebersihan', 'Keamanan', 'Infrastruktur', 'Lainnya'],
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['dilaporkan', 'ditindaklanjuti', 'selesai'],
                'default' => 'dilaporkan',
            ],
            'tanggapan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'rating' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => true,
                'comment' => '1-5',
            ],
            'feedback' => [
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
        $this->forge->addKey('warga_id');
        $this->forge->addForeignKey('warga_id', 'warga', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengaduan');

        // Table: pengumuman
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'judul' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'isi' => [
                'type' => 'TEXT',
            ],
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['Kegiatan', 'Iuran', 'Keamanan', 'Umum'],
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'file_attachment' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'is_pinned' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'is_important' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => 'Send push notification if 1',
            ],
            'user_id' => [
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
        $this->forge->addKey('created_at');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengumuman');
    }

    public function down()
    {
        $this->forge->dropTable('pengumuman');
        $this->forge->dropTable('pengaduan');
        $this->forge->dropTable('pengajuan_surat');
        $this->forge->dropTable('kegiatan_foto');
        $this->forge->dropTable('kegiatan');
        $this->forge->dropTable('mutasi_warga');
    }
}
