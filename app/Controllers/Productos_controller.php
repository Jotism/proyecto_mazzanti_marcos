<?php
namespace App\Controllers;

use App\Models\Productos_model;
use App\Models\Usuarios_model;
use App\Models\Ventas_cabecera_model;
use App\Models\Ventas_detalle_model;
use App\Models\Categorias_Model;
use CodeIgniter\Controller;

class Productos_controller extends Controller
{
    public function __construct(){
        helper(['url', 'form']);
        $session = session();
    }

    // mostrar los productos en lista
    public function index(){
        $productoModel = new Productos_model();
        $categoriaModel = new Categorias_model(); // Agregado

        $data['producto'] = $productoModel->getProductoAll();
        $data['categorias'] = $categoriaModel->getCategorias(); // Agregado

        echo view('plantilla\Header', ['titulo' => 'Nuevo Producto']);
        echo view('productos\Producto_nuevo', $data);
        echo view('plantilla\Footer');
    }

    public function crearproducto()
    {
        $categoriasmodel = new Categorias_model();
        $data['categorias'] = $categoriasmodel->getCategorias(); //traer las categorías desde la db

        $productoModel = new Productos_model();
        $data['producto'] = $productoModel->getProductoAll();

        echo view('plantilla\Header', ['titulo' => 'Alta Producto']);
        echo view('productos\Ver_producto', $data);
        echo view('plantilla\Footer');
    }

    public function store()
    {
        // construimos las reglas de validación
        $input = $this->validate([
            'nombre_prod' => 'required|min_length[3]',
            'categoria'   => 'is_not_unique[categorias.id]',
            'precio'      => 'required|numeric',
            'precio_vta'  => 'required|numeric',
            'stock'       => 'required',
            'stock_min'   => 'required',
            'imagen'      => 'uploaded[imagen]'
        ]);

        $productoModel = new Productos_model(); //se instancia el modelo
        $data['producto'] = $productoModel->getProductoAll();

        if (!$input) {
            $categoria_model = new Categorias_model();
            $data['categorias'] = $categoria_model->getCategorias();
            $data['validation'] = $this->validator;

            echo view('plantilla\Header', ['titulo' => 'Nuevo Producto']);
            echo view('productos\Producto_nuevo', $data);
            echo view('plantilla\Footer');
        } else {
            $img = $this->request->getFile('imagen');
            // este código genera un nombre aleatorio para el archivo
            $nombre_aleatorio = $img->getRandomName();
            // mueve el archivo de imagen a una ubicación específica en el servidor
            $img->move(ROOTPATH . 'assets/uploads', $nombre_aleatorio);

            $data = [
                'nombre_prod' => $this->request->getVar('nombre_prod'),
                // Aquí se obtiene el nombre del archivo de imagen (sin la ruta)
                'imagen'      => $img->getName(),
                'categoria_id'=> $this->request->getVar('categoria'),
                'precio'      => $this->request->getVar('precio'),
                'precio_vta'  => $this->request->getVar('precio_vta'),
                'stock'       => $this->request->getVar('stock'),
                'stock_min'   => $this->request->getVar('stock_min'),
                // 'eliminado' => NO
            ];

            $producto = new Productos_model();
            $id = $productoModel->insertarProducto($data);
            session()->setFlashdata('success', 'Alta Exitosa...');
            
             return $this->response->redirect(site_url('/productos/producto%' . $id));
        }
    }

    public function ver_producto($id)
    {
        $productoModel = new \App\Models\Productos_model();
        $data['producto'] = $productoModel->obtenerProductoPorId($id);
        if (!$data['producto']) {
            show_error("No se encontró el producto.");
        }
        $categoriaModel = new \App\Models\Categorias_model();
        $data['categoria'] = $categoriaModel->obtenerCategoriaPorId($data['producto']['categoria_id']);

        echo view('plantilla\Header', ['titulo' => 'Producto ' . $id]);
        echo view('productos\Ver_producto', $data);
        echo view('plantilla\Footer');
    }

}

