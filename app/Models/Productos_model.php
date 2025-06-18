<?php
namespace App\Models;
use CodeIgniter\Model;

class Productos_model extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
                                'nombre_prod', 
                                'imagen', 
                                'categoria_id', 
                                'precio', 
                                'precio_vta', 
                                'stock', 
                                'stock_min', 
                                'eliminado'
                               ];
    
                               
    public function getProductoAll()
    {
        return $this->findAll();
    }

    public function insertarProducto($data)
    {
        $this->insert($data);
        return $this->getInsertID(); // ✅ devuelve el ID insertado
    }

    public function obtenerProductoPorId($id)
    {
        return $this->find($id);
    }
}