<?php
namespace App\Models;
use CodeIgniter\Model;

class Categorias_model extends Model
{
    protected $table = 'categorias';
    protected $primaryKey = 'id';
    protected $allowedFields = [
                                'descripcion',  
                                'activo'    
                               ];
    
    public function getCategorias()
    {
        return $this->findAll();
    }

    public function obtenerCategoriaPorId($id)
    {
        return $this->find($id);
    }
}