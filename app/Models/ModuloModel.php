<?php 
namespace App\Models;

use CodeIgniter\Model;

class ModuloModel extends Model{
    protected $table = 'modulos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idCurso', 'titulo', 'descripcion', 'orden'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}