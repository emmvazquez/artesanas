<?php
namespace App\Controllers;
use App\Models\ModuloModel;
use CodeIgniter\Controller;

class Modulo extends Controller
{
    public function index($idCurso)
    {
        $model = new ModuloModel();
        $data['modulos'] = $model->where('idCurso', $idCurso)
                                 ->where('deleted_at', null)
                                 ->orderBy('orden', 'asc')
                                 ->findAll();
        $data['idCurso'] = $idCurso;
        return view('modulos/index', $data);
    }

    public function edit($id)
    {
        $model = new ModuloModel();
        return $this->response->setJSON($model->find($id));
    }

    public function update($id)
    {
        $model = new ModuloModel();
        $data = $this->request->getPost();
        $model->update($id, $data);
        return redirect()->to('/modulo/index/' . $data['idCurso']);
    }

    public function delete($id)
    {
        $model = new ModuloModel();
        $modulo = $model->find($id);
        $model->delete($id);
        return redirect()->to('/modulo/index/' . $modulo['idCurso']);
    }

    public function create()
    {
        $model = new ModuloModel();
        $data = $this->request->getPost();
        $model->insert($data);
        return redirect()->to('/modulo/index/' . $data['idCurso']);
    }
}
