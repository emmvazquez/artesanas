<?php
namespace App\Models;

use CodeIgniter\Model;

class PreguntasModel extends Model {
    protected $table = 'preguntas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['idModulo', 'pregunta', 'opcion1', 'opcion2', 'opcion3', 'respuestaCorrecta'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
} 