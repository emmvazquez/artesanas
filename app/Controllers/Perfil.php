<?php namespace App\Controllers;

use App\Models\PerfilModel;
use CodeIgniter\API\ResponseTrait;

class Perfil extends BaseController
{
    use ResponseTrait;

    protected $perfilModel;

    public function __construct()
    {
        $this->perfilModel = new PerfilModel();
    }

    /**
     * Vista principal de perfil (puede mostrar perfil activo o una tabla si es administrador)
     */
    public function vista()
    {
        return view('perfil/index', ['title' => 'Mi perfil']);
    }

    /**
     * Listar todos los perfiles (modo administrativo)
     */
    public function index()
    {
        $perfiles = $this->perfilModel->findAll();
        return $this->respond($perfiles);
    }

    /**
     * Obtener un perfil específico por ID
     */
    public function edit($id = null)
    {
        $perfil = $this->perfilModel->find($id);
        return $perfil ? $this->respond($perfil) : $this->failNotFound("Perfil no encontrado");
    }

    /**
     * Actualizar un perfil por ID
     */
    public function update($id = null)
    {
        $data = $this->request->getJSON(true);
        if ($this->perfilModel->update($id, $data)) {
            return $this->respond(['msg' => 'Perfil actualizado']);
        }
        return $this->failValidationErrors($this->perfilModel->errors());
    }

    /**
     * Crear un nuevo perfil
     */
    public function add()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['idUsuario'])) {
            return $this->failValidationErrors(['idUsuario' => 'El campo idUsuario es obligatorio']);
        }

        if ($this->perfilModel->getPerfilByUsuario($data['idUsuario'])) {
            return $this->failResourceExists("Ya existe un perfil para este usuario");
        }

        if ($this->perfilModel->insert($data)) {
            return $this->respondCreated(['msg' => 'Perfil creado', 'id' => $this->perfilModel->insertID()]);
        }

        return $this->failValidationErrors($this->perfilModel->errors());
    }

    /**
     * Eliminar perfil por ID
     */
    public function delete($id = null)
    {
        if ($this->perfilModel->delete($id)) {
            return $this->respondDeleted(['msg' => 'Perfil eliminado']);
        }
        return $this->failNotFound("No se pudo eliminar el perfil");
    }
}
