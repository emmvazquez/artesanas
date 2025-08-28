<?php
namespace App\Models;
use CodeIgniter\Model;

class ContenidoModel extends Model
{
    protected $table = 'contenidos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'idModulo', 'tipo', 'urlArchivo',
        'textoAdicional', 'duracionEstimada', 'idioma'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
}
