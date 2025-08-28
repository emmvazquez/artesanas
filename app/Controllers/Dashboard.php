<?php
namespace App\Controllers;
use App\Models\CursoModel;
use App\Models\UsuarioCursoModel;

class Dashboard extends BaseController
{
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
