<?php
namespace App\Models;
use CodeIgniter\Model;

class UsuarioCursoModel extends Model
{
    protected $table = 'usuario_curso';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idUsuario', 'idCurso', 'fechaInscripcion'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
