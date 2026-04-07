<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeacherStudentsTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('tbl_teacher_students')) {
            return;
        }

        $this->forge->addField([
            'pk_assignment' => [
                'type'           => 'INT',
                'constraint'     => 10,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'fk_teacher_user' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'fk_student_user' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'student_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'school_group' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'subject_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'notes' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status' => [
                'type'       => 'SMALLINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at DATETIME default current_timestamp',
            'updated_at DATETIME default current_timestamp on update current_timestamp',
        ]);

        $this->forge->addKey('pk_assignment', true);
        $this->forge->addKey(['fk_teacher_user', 'fk_student_user']);
        $this->forge->addForeignKey('fk_teacher_user', 'tbl_users', 'pk_user', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('fk_student_user', 'tbl_users', 'pk_user', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_teacher_students');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_teacher_students', true);
    }
}
