<?php

namespace App\Controllers;
use App\Models\CursoModel;
use App\Models\UsuarioCursoModel;

use CodeIgniter\Controller;

class Curso extends Controller
{
    public function index()
    {
        $model = new CursoModel();
        $data['cursos'] = $model->where('deleted_at', null)->findAll();
        return view('cursos/index', $data);
    }

    public function edit($id)
    {
        $model = new CursoModel();
        return $this->response->setJSON($model->find($id));
    }

    public function update($id)
    {
        $model = new CursoModel();
        $data = $this->request->getPost();
        
        // Subida de nueva imagen si se proporciona
        $file = $this->request->getFile('imagenPortada');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nombre = $file->getRandomName();
            $file->move('uploads/cursos/', $nombre);
            $data['imagenPortada'] = base_url("uploads/cursos/" . $nombre);
        }

        $model->update($id, $data);
        return redirect()->to('/curso');
    }

    public function delete($id)
    {
        $model = new CursoModel();
        $model->delete($id);
        return redirect()->to('/curso');
    }

    public function create()
    {
        $model = new CursoModel();
        $data = $this->request->getPost();

        $file = $this->request->getFile('imagenPortada');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $nombre = $file->getRandomName();
            $file->move('uploads/cursos/', $nombre);
            $data['imagenPortada'] = base_url("uploads/cursos/" . $nombre);
        }

        $model->insert($data);
        return redirect()->to('/curso');
    }


     public function inscribirse($idCurso)
    {
        if (!session()->has('idUsuario')) {
            return redirect()->to('/auth/login')->with('error', 'Debes iniciar sesión para inscribirte.');
        }

        $idUsuario = session()->get('idUsuario');
        $inscripcionModel = new UsuarioCursoModel();

        // Verifica si ya está inscrito
        $yaInscrito = $inscripcionModel
            ->where('idUsuario', $idUsuario)
            ->where('idCurso', $idCurso)
            ->first();

        if (!$yaInscrito) {
            $inscripcionModel->insert([
                'idUsuario' => $idUsuario,
                'idCurso' => $idCurso,
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->to('/curso/' . $idCurso)->with('success', 'Inscripción exitosa.');
    }
}
