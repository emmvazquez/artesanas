<?php
namespace App\Models;
use CodeIgniter\Model;

class ProgresoModel extends Model
{
    protected $table = 'progreso';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'idUsuario',
        'idModulo',
        'completado',
        'fechaCompletado',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
