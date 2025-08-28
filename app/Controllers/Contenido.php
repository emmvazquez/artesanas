<?php
namespace App\Controllers;
use App\Models\ContenidoModel;
use CodeIgniter\Controller;

class Contenido extends Controller
{
    public function index($idModulo)
    {
        $model = new ContenidoModel();
        $data['contenido'] = $model->where('idModulo', $idModulo)
                                   ->where('deleted_at', null)
                                   ->orderBy('tipo', 'asc')
                                   ->findAll();
        $data['idModulo'] = $idModulo;
        return view('contenido/index', $data);
    }

    public function edit($id)
    {
        $model = new ContenidoModel();
        return $this->response->setJSON($model->find($id));
    }

    public function create()
{
    $model = new ContenidoModel();
    $data = $this->request->getPost();

    $file = $this->request->getFile('archivoSubido');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $nombre = $file->getRandomName();
        $file->move('uploads/contenido/', $nombre);
        $data['urlArchivo'] = base_url("uploads/contenido/" . $nombre);
    }

    $model->insert($data);
    return redirect()->to('/contenido/index/' . $data['idModulo']);
}

public function update($id)
{
    $model = new ContenidoModel();
    $data = $this->request->getPost();

    $file = $this->request->getFile('archivoSubido');
    if ($file && $file->isValid() && !$file->hasMoved()) {
        $nombre = $file->getRandomName();
        $file->move('uploads/contenido/', $nombre);
        $data['urlArchivo'] = base_url("uploads/contenido/" . $nombre);
    }

    $model->update($id, $data);
    return redirect()->to('/contenido/index/' . $data['idModulo']);
}



    public function delete($id)
    {
        $model = new ContenidoModel();
        $contenido = $model->find($id);
        $model->delete($id);
        return redirect()->to('/contenido/index/' . $contenido['idModulo']);
    }
}
