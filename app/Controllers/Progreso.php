<?php
namespace App\Controllers;

use App\Models\ProgresoModel;
use CodeIgniter\Controller;

class Progreso extends Controller
{
    public function registrar()
    {
        $idUsuario = session()->get('idUsuario');
        $idModulo = $this->request->getPost('idModulo');

        if (!$idUsuario || !$idModulo) {
            return $this->response->setJSON(['error' => 'Datos incompletos']);
        }

        $progresoModel = new ProgresoModel();

        // Verificar si ya existe progreso para este usuario y módulo
        $existe = $progresoModel
            ->where('idUsuario', $idUsuario)
            ->where('idModulo', $idModulo)
            ->first();

        if (!$existe) {
            $progresoModel->insert([
                'idUsuario' => $idUsuario,
                'idModulo'  => $idModulo,
                'completado' => 1,
                'fechaCompletado' => date('Y-m-d H:i:s')
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }
}
