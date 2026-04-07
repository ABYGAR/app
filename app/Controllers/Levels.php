<?php

namespace App\Controllers;

use App\Models\LevelsModel;

class Levels extends BaseController
{

    public function create()
    {
        $levelsModel = new LevelsModel();
        
        $cat_levels = 
        [
            'level' => 'Project'
        ];

        if ($levelsModel->insert($cat_levels)) 
        {
			return $this->response->setJSON([
                'status'  => '200',
                'message' => 'Nivel insertado con exito'
            ]); 
        } 
        else 
        {
            return $this->response->setJSON([
                'status'  => '500',
                'message' => 'Se produjo un error'
            ]); 
        }
    }

    public function read()
    {
        $levelsModel = new LevelsModel();

        $cat_levels = $levelsModel->findAll();

        return $this->response->setJSON($cat_levels);        
    }

    public function delete($pk_level= null)
    {
        $levelsModel = new LevelsModel();

        $level  = $levelsModel->find($pk_level);
        
        if(empty($level))
        {
            return $this->response->setJSON([
                'status'  => '400',
                'message' => 'Nivel solicitado incorrectamente'
            ]); 
        }
        else
        {
            $status = $levelsModel->delete($level);

             return $this->response->setJSON([
                'status'  => $status,
                'message' => 'Nivel eliminado correctamente'
            ]); 
        }
    }

    public function update($pk_level= null)
    {
        $levelsModel = new LevelsModel();

        $cat_levels = 
        [
            'level' => 'Driver'
        ];

        $level  = $levelsModel->find($pk_level);

        if(empty($level))
        {
            return $this->response->setJSON([
                'status'  => '400',
                'message' => 'Level incorrect!'
            ]); 
        }
        else
        {
            $status = $levelsModel->update(['$pk_level' => $pk_level], $cat_levels);

             return $this->response->setJSON([
                'status'  => $status,
                'message' => 'Nivel actualizad0 correctamente'
            ]); 
        }

    }

    public function apiCreate()
    {
        $level =  $this->request->getPost('level');
        
        if($level == null)
        {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Valiable no encontrada',
                'icon'    => 'error',
            ]);
        }
        else
        {
            
            $levelsModel = new LevelsModel();

            $newLevel = 
            [
                'level' => $level
            ];

            if ($levelsModel->insert($newLevel)) 
            {
                return $this->response->setJSON([
                    'status'  => 200,
                    'message' => 'Nivel creado correctamente',
                    'icon'    => 'success',
                ]);
            } 
            else 
            {
                return $this->response->setJSON([
                    'status'  => 400,
                    'message' => 'Error al crear un niveñ',
                    'icon'    => 'error',
                ]);
            }
        }
    }

    public function apiDelete()
    {
        $level = $this->request->getPost('level');
        $pkLevel = is_array($level) ? ($level[0] ?? null) : $level;

        if ($pkLevel === null || $pkLevel === '') {
            return $this->response->setJSON([
                'status'  => 400,
                'message' => 'Nivel no recibido',
                'icon'    => 'error',
            ]);
        }

        $levelsModel = new LevelsModel();
        $levelData   = $levelsModel->find($pkLevel);

        if (! $levelData) {
            return $this->response->setJSON([
                'status'  => 404,
                'message' => 'Nivel no encontrado',
                'icon'    => 'error',
            ]);
        }

        if ($levelsModel->delete($pkLevel)) {
            return $this->response->setJSON([
                'status'  => 200,
                'message' => 'Nivel eliminado correctamente',
                'icon'    => 'success',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 400,
            'message' => 'No se pudo eliminar el nivel',
            'icon'    => 'error',
        ]);
    }
}
