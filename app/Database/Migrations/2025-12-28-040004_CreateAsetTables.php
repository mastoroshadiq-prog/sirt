<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAsetTables extends Migration
{
    public function up()
    {
        // Table: kategori_aset
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kategori' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'prefix_kode' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'comment' => 'TN, GB, PM, KD, LL',
            ],
            'deskripsi' => [
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
        $this->forge->createTable('kategori_aset');

        // Table: aset_inventaris
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kategori_aset_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kode_register' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'comment' => 'TN.0001, GB.0002, etc',
            ],
            'nama_aset' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'tanggal_perolehan' => [
                'type' => 'DATE',
            ],
            'cara_perolehan' => [
                'type' => 'ENUM',
                'constraint' => ['Pembelian', 'Hibah', 'Swadaya Masyarakat', 'Lainnya'],
            ],
            'nilai_perolehan' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'kondisi' => [
                'type' => 'ENUM',
                'constraint' => ['Baik', 'Rusak Ringan', 'Rusak Berat'],
                'default' => 'Baik',
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
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'bukti_kepemilikan' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'pengeluaran_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'Link to BKU if from Belanja Modal',
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
        $this->forge->addUniqueKey('kode_register');
        $this->forge->addKey('kategori_aset_id');
        $this->forge->addForeignKey('kategori_aset_id', 'kategori_aset', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pengeluaran_id', 'pengeluaran', 'id', 'SET NULL', 'SET NULL');
        $this->forge->createTable('aset_inventaris');

        // Table: aset_foto
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'aset_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'is_primary' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('aset_id');
        $this->forge->addForeignKey('aset_id', 'aset_inventaris', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('aset_foto');

        // Table: aset_kondisi_log
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'aset_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'kondisi_sebelum' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'kondisi_sesudah' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'tanggal_update' => [
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
        $this->forge->addKey('aset_id');
        $this->forge->addForeignKey('aset_id', 'aset_inventaris', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('aset_kondisi_log');
    }

    public function down()
    {
        $this->forge->dropTable('aset_kondisi_log');
        $this->forge->dropTable('aset_foto');
        $this->forge->dropTable('aset_inventaris');
        $this->forge->dropTable('kategori_aset');
    }
}
