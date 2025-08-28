<?php 
namespace App\Models;

use CodeIgniter\Model;

class PerfilModel extends Model{
    protected $table      = 'perfiles';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'idUsuario', 'nombre', 'apellidoPaterno', 'apellidoMaterno',
        'fechaNacimiento', 'estado', 'municipio', 'localidad',
        'idiomaPreferido', 'tamLetra', 'velocidadAudio', 'contrasteAlto', 'sexo'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function getPerfilByUsuario($idUsuario)
    {
        return $this->where('idUsuario', $idUsuario)->first();
    }
}