<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResequenceLevelsTable extends Migration
{
    public function up()
    {
        // Esta migracion reordena los IDs reales de cat_levels para que
        // queden consecutivos (1, 2, 3, 4, ...).
        //
        // Se hace en dos pasos para evitar choques de claves primarias:
        // 1. mover temporalmente los IDs actuales a valores altos
        // 2. asignar los nuevos IDs consecutivos
        //
        // Como tbl_users.fk_level tiene ON UPDATE CASCADE, los usuarios
        // se actualizan automaticamente cuando cambia pk_level.

        $levels = $this->db->table('cat_levels')
            ->orderBy('pk_level', 'asc')
            ->get()
            ->getResultArray();

        if (empty($levels)) {
            return;
        }

        $tempId = 1000;

        foreach ($levels as $level) {
            $this->db->table('cat_levels')
                ->where('pk_level', (int) $level['pk_level'])
                ->update(['pk_level' => $tempId]);

            $tempId++;
        }

        $newId = 1;

        foreach ($levels as $level) {
            $temporaryId = 1000 + array_search($level, $levels, true);

            $this->db->table('cat_levels')
                ->where('pk_level', $temporaryId)
                ->update(['pk_level' => $newId]);

            $newId++;
        }

        // Ajustamos el siguiente AUTO_INCREMENT para que el proximo nivel
        // nuevo continue despues del ultimo ID reasignado.
        $this->db->query('ALTER TABLE `cat_levels` AUTO_INCREMENT = ' . $newId);
    }

    public function down()
    {
        // No se revierte automaticamente porque esta migracion cambia IDs
        // reales ya existentes y no siempre es seguro reconstruir el orden previo.
    }
}
