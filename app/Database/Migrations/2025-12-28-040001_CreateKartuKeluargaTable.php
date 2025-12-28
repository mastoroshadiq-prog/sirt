<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKartuKeluargaTable extends Migration
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
            'no_kk' => [
                'type' => 'VARCHAR',
                'constraint' => '16',
            ],
            'kepala_keluarga' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
            ],
            'alamat' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'rt' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'rw' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'pindah', 'nonaktif'],
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
        $this->forge->addUniqueKey('no_kk');
        $this->forge->createTable('kartu_keluarga');
    }

    public function down()
    {
        $this->forge->dropTable('kartu_keluarga');
    }
}
