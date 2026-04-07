<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResequenceUsersTable extends Migration
{
    public function up()
    {
        $users = $this->db->table('tbl_users')
            ->select('pk_user')
            ->orderBy('pk_user', 'asc')
            ->get()
            ->getResultArray();

        if (empty($users)) {
            $this->db->query('ALTER TABLE `tbl_users` AUTO_INCREMENT = 1');
            return;
        }

        // Esta migracion acomoda los IDs reales de usuarios a un orden
        // consecutivo (1, 2, 3, 4, ...).
        //
        // Se usa una zona temporal alta para evitar choques de clave primaria
        // durante el reordenamiento de pk_user.
        $temporaryId = 1000;

        foreach ($users as $user) {
            $this->db->table('tbl_users')
                ->where('pk_user', (int) $user['pk_user'])
                ->update(['pk_user' => $temporaryId]);

            $temporaryId++;
        }

        $newId = 1;

        foreach ($users as $index => $user) {
            $this->db->table('tbl_users')
                ->where('pk_user', 1000 + $index)
                ->update(['pk_user' => $newId]);

            $newId++;
        }

        // Ajustamos el siguiente AUTO_INCREMENT para que continue
        // despues del ultimo usuario reasignado.
        $this->db->query('ALTER TABLE `tbl_users` AUTO_INCREMENT = ' . $newId);
    }

    public function down()
    {
        // No se revierte automaticamente porque modifica IDs reales
        // ya existentes y no siempre es seguro reconstruir el orden anterior.
    }
}
