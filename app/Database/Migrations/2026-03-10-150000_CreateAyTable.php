<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAyTable extends Migration
{
    public function up()
    {
        $this->forge->addField(
        [
            'pk_ay' => 
            [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'ay_name' => 
            [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'ay_description' => 
            [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'status' => 
            [
                'type'       => 'SMALLINT',
                'constraint' => 1,
                'default'    => 1,
            ],

            'created_at DATETIME default current_timestamp',
            'updated_at DATETIME default current_timestamp on update current_timestamp'
        ]);

        $this->forge->addKey('pk_ay', true);
        $this->forge->createTable('tbl_ay');
    }

    public function down()
    {
        //$this->forge->dropTable('tbl_ay');
    }
}
