<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWargaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kk_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'nik' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'tempat_lahir' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'tanggal_lahir' => [
                'type' => 'DATE',
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM',
                'constraint' => ['L', 'P'],
            ],
            'agama' => [
                'type' => 'ENUM',
                'constraint' => ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'],
            ],
            'pekerjaan' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'status_perkawinan' => [
                'type' => 'ENUM',
                'constraint' => ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'],
            ],
            'status_keluarga' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'comment' => 'Kepala Keluarga, Istri, Anak, dll',
            ],
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'pindah', 'meninggal'],
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
        $this->forge->addUniqueKey('nik');
        $this->forge->addKey('kk_id');
        $this->forge->addForeignKey('kk_id', 'kartu_keluarga', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('warga');
    }

    public function down()
    {
        $this->forge->dropTable('warga');
    }
}
