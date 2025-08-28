<?php

namespace App\Controllers;
use App\Models\CursoModel;
use App\Models\ModuloModel;

class Page extends BaseController
{
    public function index()
    {
        $cursoModel = new CursoModel();
        $cursos = $cursoModel->findAll();

        return view('page/landing', [
            'titulo' => 'Artesanas de Hueyapan',
            'cursos' => $cursos
        ]);
    }

    public function curso($id)
{
    $cursoModel = new CursoModel();
    $moduloModel = new ModuloModel();
    $inscripcionModel = new \App\Models\UsuarioCursoModel();

    $curso = $cursoModel->find($id);
    if (!$curso) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Curso no encontrado");
    }

    $modulos = $moduloModel->where('idCurso', $id)->orderBy('orden', 'asc')->findAll();

    $usuarioInscrito = false;

    if (session()->has('idUsuario')) {
        $idUsuario = session()->get('idUsuario');
        $usuarioInscrito = $inscripcionModel
            ->where('idUsuario', $idUsuario)
            ->where('idCurso', $id)
            ->first() !== null;
    }

    return view('page/curso_detalle', [
        'titulo' => $curso['titulo'],
        'curso' => $curso,
        'modulos' => $modulos,
        'usuarioInscrito' => $usuarioInscrito,
        'estaLogeado' => session()->has('idUsuario')
    ]);
}

}
