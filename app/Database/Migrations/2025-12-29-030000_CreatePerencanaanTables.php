<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePerencanaanTables extends Migration
{
    public function up()
    {
        // Table: rencana_kerja_tahunan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'visi' => [
                'type' => 'TEXT',
            ],
            'misi' => [
                'type' => 'TEXT',
            ],
            'periode_mulai' => [
                'type' => 'DATE',
            ],
            'periode_selesai' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'approved', 'active', 'archived'],
                'default' => 'draft',
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'approved_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'approved_at' => [
                'type' => 'DATETIME',
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
        $this->forge->addKey('tahun');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('approved_by', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('rencana_kerja_tahunan');

        // Table: program_kerja
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'rkt_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'bidang' => [
                'type' => 'ENUM',
                'constraint' => ['Lingkungan', 'Sosial', 'Keamanan', 'Pendidikan', 'Kesehatan', 'Infrastruktur', 'Lainnya'],
            ],
            'nama_program' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'target_output' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pj_program' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addKey('rkt_id');
        $this->forge->addForeignKey('rkt_id', 'rencana_kerja_tahunan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('program_kerja');

        // Table: rencana_kegiatan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'program_kerja_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nama_kegiatan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'timeline' => [
                'type' => 'ENUM',
                'constraint' => ['Q1', 'Q2', 'Q3', 'Q4'],
            ],
            'bulan_target' => [
                'type' => 'INT',
                'constraint' => 2,
                'null' => true,
            ],
            'target_peserta' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'expected_outcome' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'pic_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['belum_mulai', 'on_progress', 'selesai', 'delayed', 'canceled'],
                'default' => 'belum_mulai',
            ],
            'progress_persen' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 0,
            ],
            'kegiatan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'Link to actual kegiatan table',
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
        $this->forge->addKey('program_kerja_id');
        $this->forge->addForeignKey('program_kerja_id', 'program_kerja', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pic_user_id', 'users', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('kegiatan_id', 'kegiatan', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('rencana_kegiatan');

        // Table: rapb
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'rkt_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
            ],
            'total_target_pendapatan' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'total_rencana_belanja' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'buffer_persen' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 10.00,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft', 'approved', 'active'],
                'default' => 'draft',
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
        $this->forge->addKey('rkt_id');
        $this->forge->addForeignKey('rkt_id', 'rencana_kerja_tahunan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rapb');

        // Table: rapb_pendapatan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'rapb_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'sumber' => [
                'type' => 'ENUM',
                'constraint' => ['Iuran Warga', 'Swadaya', 'Bantuan Pemerintah', 'Donasi', 'Lainnya'],
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'target_nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
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
        $this->forge->addKey('rapb_id');
        $this->forge->addForeignKey('rapb_id', 'rapb', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rapb_pendapatan');

        // Table: rapb_belanja
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'rapb_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'program_kerja_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'kategori' => [
                'type' => 'ENUM',
                'constraint' => ['Rutin', 'Pembangunan', 'Operasional', 'Keamanan', 'Sosial', 'Lainnya'],
            ],
            'uraian' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jumlah_anggaran' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
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
        $this->forge->addKey('rapb_id');
        $this->forge->addForeignKey('rapb_id', 'rapb', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('program_kerja_id', 'program_kerja', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('rapb_belanja');

        // Table: pembangunan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'rkt_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'nama_proyek' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'manfaat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'estimasi_biaya' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'sumber_dana' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'timeline_mulai' => [
                'type' => 'DATE',
            ],
            'timeline_selesai' => [
                'type' => 'DATE',
            ],
            'priority' => [
                'type' => 'ENUM',
                'constraint' => ['High', 'Medium', 'Low'],
                'default' => 'Medium',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['proposal', 'approved', 'survey', 'pelaksanaan', 'selesai', 'ditunda'],
                'default' => 'proposal',
            ],
            'progress_fisik' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 0,
            ],
            'realisasi_biaya' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'pic_user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
        $this->forge->addKey('rkt_id');
        $this->forge->addForeignKey('rkt_id', 'rencana_kerja_tahunan', 'id', 'SET NULL', 'SET NULL');
        $this->forge->addForeignKey('pic_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pembangunan');

        // Table: pembangunan_foto
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'pembangunan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'keterangan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('pembangunan_id');
        $this->forge->addForeignKey('pembangunan_id', 'pembangunan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pembangunan_foto');
    }

    public function down()
    {
        $this->forge->dropTable('pembangunan_foto');
        $this->forge->dropTable('pembangunan');
        $this->forge->dropTable('rapb_belanja');
        $this->forge->dropTable('rapb_pendapatan');
        $this->forge->dropTable('rapb');
        $this->forge->dropTable('rencana_kegiatan');
        $this->forge->dropTable('program_kerja');
        $this->forge->dropTable('rencana_kerja_tahunan');
    }
}
