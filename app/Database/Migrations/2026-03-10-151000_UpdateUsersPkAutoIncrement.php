<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateUsersPkAutoIncrement extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE `tbl_users` MODIFY `pk_user` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT");
    }

    public function down()
    {
        // Removing AUTO_INCREMENT to match the previous schema.
        $this->db->query("ALTER TABLE `tbl_users` MODIFY `pk_user` INT(10) UNSIGNED NOT NULL");
    }
}
