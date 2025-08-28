<?php 
namespace App\Models;

use CodeIgniter\Model;

class CursoModel extends Model{
     protected $table      = 'cursos';
    protected $primaryKey = 'id';

    protected $useSoftDeletes = true;
    protected $useTimestamps  = true;

    protected $allowedFields = [
        'titulo',
        'descripcion',
        'imagenPortada',
        'idiomasDisponibles',
        'fechaCreacion'
    ];
}

