<?php

namespace App\Controllers;

use App\Models\CursoModel;
use App\Models\ModuloModel;
use App\Models\ContenidoModel;
use App\Models\UsuarioCursoModel;

class Dashboard extends BaseController
{
    public function curso(int $idCurso)
    {
        // 1) Usuario logueado garantizado por el filtro 'auth'
        $idUsuario = session()->get('idUsuario');

        // 2) Verificar inscripción
        $uc = new UsuarioCursoModel();
        $inscrito = $uc->where('idUsuario', $idUsuario)
            ->where('idCurso', $idCurso)
            ->first();

        if (!$inscrito) {
            return redirect()->to('/curso/' . $idCurso)
                ->with('error', 'Debes estar inscrito para ver el contenido de este curso.');
        }

        // 3) Cargar datos del curso, módulos y contenidos
        $cursoModel = new CursoModel();
        $moduloModel = new ModuloModel();
        $contenidoModel = new ContenidoModel();

        $curso = $cursoModel->find($idCurso);
        if (!$curso) {
            return redirect()->to('/dashboard')->with('error', 'Curso no encontrado.');
        }

        $modulos = $moduloModel->where('idCurso', $idCurso)
            ->where('deleted_at', null)
            ->orderBy('orden', 'ASC')
            ->findAll();

        // Opcional: empaquetar contenidos por módulo
        $contenidosPorModulo = [];
        foreach ($modulos as $m) {
            $contenidosPorModulo[$m['id']] = $contenidoModel
                ->where('idModulo', $m['id'])
                ->where('deleted_at', null)
                ->orderBy('tipo', 'ASC')
                ->findAll();
        }

        return view('dashboard/curso', [
            'curso' => $curso,
            'modulos' => $modulos,
            'contenidosPorModulo' => $contenidosPorModulo,
        ]);
    }
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $idUsuario = session()->get('idUsuario');
        //$idUsuario = session('id');
        $cursoModel = new CursoModel();
        $usuarioCursoModel = new UsuarioCursoModel();

        $cursos = $cursoModel->where('deleted_at', null)->findAll();
        $inscritos = $usuarioCursoModel
            ->where('idUsuario', $idUsuario)
            ->where('deleted_at', null)
            ->findAll();

        $cursosInscritos = array_column($inscritos, 'idCurso');

        return view('dashboard/index', [
            'cursos' => $cursos,
            'cursosInscritos' => $cursosInscritos
        ]);
    }

    public function inscribirse($idCurso)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        $model = new UsuarioCursoModel();
        $model->insert([
            'idUsuario' => session()->get('idUsuario'),
            'idCurso' => $idCurso
        ]);

        return redirect()->to('/dashboard');
    }
}
