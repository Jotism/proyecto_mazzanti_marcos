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

        $data['productos'] = $productoModel->getProductoAll();
        $data['categorias'] = $categoriaModel->getCategorias(); // Agregado

        echo view('plantilla\Header', ['titulo' => 'Vista Productos']);
        echo view('productos\Vista_productos', $data);
        echo view('plantilla\Footer');
    }

    public function creaproducto()
    {
        $categoriasmodel = new Categorias_model();
        // traer todas las categorias desde la db
        $data['categorias'] = $categoriasmodel->getCategorias();

        $productoModel = new Productos_model();
        $data['producto'] = $productoModel->orderBy('id', 'DESC')->findAll();

        echo view('plantilla\Header', ['titulo' => 'Alta producto']);
        echo view('productos\Alta_producto', $data);
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

            echo view('plantilla\Header', ['titulo' => 'Alta Producto']);
            echo view('productos\Alta_producto', $data);
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
            $producto->insert($data);
            session()->setFlashdata('success', 'Alta Exitosa...');
             return $this->response->redirect(site_url('crear'));
        }
    }

    public function singleproducto($id = null)
    {
        $productModel = new Productos_model();
        $data['old'] = $productModel->where('id', $id)->first();

        if (empty($data['old'])) {
            // lanzar error
            throw new \CodeIgniter\Exceptions\PageNotFoundException('No se encontró el producto seleccionado');
        }

        // instancio el modelo de categorías
        $categoriasM = new Categorias_model();
        $data['categorias'] = $categoriasM->getCategorias(); // traigo categorías

        echo view('plantilla\Header', ['titulo' => 'Producto ' . $id]);
        echo view('productos/edit', $data);
        echo view('plantilla\Footer');
    }

    public function modifica($id)
    {
        $productoModel = new Productos_model();
        $id = $productoModel->where('id', $id)->first();
        $img = $this->request->getFile('imagen');

        // Verifica si se cargó una imagen válida
        if ($img && $img->isValid()) {
            // Se cargó una imagen válida correctamente
            $nombre_aleatorio = $img->getRandomName();
            $img->move(ROOTPATH . 'assets/uploads', $nombre_aleatorio);
            $data = [
                'nombre_prod' => $this->request->getVar('nombre_prod'),
                'imagen' => $img->getName(),
                'categoria_id' => $this->request->getVar('categoria'),
                'precio' => $this->request->getVar('precio'),
                'precio_vta' => $this->request->getVar('precio_vta'),
                'stock' => $this->request->getVar('stock'),
                'stock_min' => $this->request->getVar('stock_min'),
            ];
        } else {
            // No se cargó una nueva imagen, solo actualiza los datos del producto sin sobrescribir la imagen
            $data = [
                'nombre_prod' => $this->request->getVar('nombre_prod'),
                'categoria_id' => $this->request->getVar('categoria'),
                'precio' => $this->request->getVar('precio'),
                'precio_vta' => $this->request->getVar('precio_vta'),
                'stock' => $this->request->getVar('stock'),
                'stock_min' => $this->request->getVar('stock_min'),
            ];
        }

        $productoModel->update($id, $data);
        session()->setFlashdata('success', 'Modificación Exitosa...');
    }

    // Eliminar lógicamente
    public function deleteproducto($id)
    {
        $productoModel = new Productos_model();
        $data['eliminado'] = $productoModel->where('id', $id)->first();
        $data['eliminado'] = 'SI';
        $productoModel->update($id, $data);
        return $this->response->redirect(site_url('crear'));
    }

    public function eliminados()
    {
        $productoModel = new Productos_model();
        $data['producto'] = $productoModel->getProductoAll();
        $data['titulo'] = 'Crud_productos';
        
        echo view('plantilla\Header', ['titulo' => 'Producto ' . $id]);
        echo view('productos/producto_eliminado', $data);
        echo view('plantilla\Footer');
    }

    public function activarproducto($id)
    {
        $productoModel = new Productos_model();
        $data['eliminado'] = $productoModel->where('id', $id)->first();
        $data['eliminado'] = 'NO';
        $productoModel->update($id, $data);
        session()->setFlashdata('success', 'Activación Exitosa...');
        return $this->response->redirect(site_url('crear'));
    }
}

