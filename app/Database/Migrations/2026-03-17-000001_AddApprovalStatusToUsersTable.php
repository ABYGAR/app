<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddApprovalStatusToUsersTable extends Migration
{
    public function up()
    {
        $fields = [
            'approval_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'approved',
                'after'      => 'locked',
            ],
        ];

        $this->forge->addColumn('tbl_users', $fields);
        $this->db->table('tbl_users')->set(['approval_status' => 'approved'])->update();
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_users', 'approval_status');
    }
}
