<?php
namespace App\Models;
use CodeIgniter\Model;

class Consulta_model extends Model
{
    protected $table = 'consultas';
    protected $primaryKey = 'id_consulta';
    protected $allowedFields = ['nombre', 'apellido', 'email', 'telefono', 'respuesta', 'mensaje'];

    public function obtenerConsultasPorEmail($email){
        
    return $this->where('email', $email)->findAll();
    }  

}
