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

    public function getBuilderProductos()
    {
        // connect() es un método de la clase Database, que nos permite conectar a la base de datos
        $db = \Config\Database::connect();
        // $builder es una instancia de la clase QueryBuilder de CodeIgniter
        $builder = $db->table('productos');
        // hace una consulta a la base de datos
        $builder->select('*');
        // hago el join de la tabla categorias
        $builder->join('categorias', 'categorias.id = productos.categoria_id');
        // retorna el builder
        return $builder;
    }

    public function getProducto($id = null)
    {
        $builder = $this->getBuilderProductos(); // Trae los productos por id
        $builder->where('productos.id', $id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function updateStock($id = null, $stock_actual = null)
    {
        $builder = $this->getBuilderProductos();
        $builder->where('productos.id', $id);
        $builder->set('productos.stock', $stock_actual); // Se cambia el valor de la columna stock
        $builder->update();
    }

    public function getProductosPorCategoria($categoria_id) {
        return $this->where('categoria_id', $categoria_id)->findAll();
    }

}