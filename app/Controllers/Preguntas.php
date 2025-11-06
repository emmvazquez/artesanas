<?php
namespace App\Controllers;
use App\Models\PreguntasModel;
use CodeIgniter\Controller;

class Preguntas extends Controller
{
    public function index($idModulo)
    {
       $pregunta = new PreguntasModel();
        $data ['preguntas']= $pregunta -> where('idModulo', $idModulo)
                                       -> where('deleted_at', null)
                                       -> findAll();
        $data['idModulo'] = $idModulo;
        return view('preguntas/index', $data);
    }
 
    public function edit($id)
    {
        $pregunta = new PreguntasModel();
        return $this->response->setJSON($pregunta->find($id));
    }

    public function update($id)
    {
        $pregunta = new PreguntasModel();
        $data = $this->request->getPost();
        $pregunta -> update($id, $data);
        return redirect()->to('/preguntas/index/' . $data['idModulo']);
    }

    public function create()
    {
        $model = new PreguntasModel();
        $data = $this->request->getPost();
        $model->insert($data);
        return redirect()->to('/preguntas/index/' . $data['idModulo']);
    }

    public function delete($id) 
    {
        $model = new PreguntasModel();
        $pregunta = $model->find($id);
        $model->delete($id);
        return redirect()->to('/preguntas/index/' . $pregunta['idModulo']);
    }
}