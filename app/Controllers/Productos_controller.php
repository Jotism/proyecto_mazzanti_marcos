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
        $categoriaModel = new Categorias_model();

        $data['productos'] = $productoModel->getProductoAll();
        $data['categorias'] = $categoriaModel->getCategorias();

        echo view('plantilla\Header', ['titulo' => 'Vista Productos']);
        echo view('productos\Vista_productos', $data);
        echo view('plantilla\Footer');
    }

    public function mostrarCatalogo() {
        $productoModel = new Productos_model();
        $categoriaModel = new Categorias_model();

        $data['productos'] = $productoModel->getProductoAll();
        $data['categorias'] = $categoriaModel->getCategorias();
        $data['categoriaSeleccionada'] = ''; // Para evitar el error

        echo view('plantilla/Header', ['titulo' => 'Catálogo']);
        echo view('Catalogo', $data);
        echo view('plantilla/Footer');
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
        $data['producto'] = $productModel->getProducto($id);
        // instancio el modelo de categorías
        $categoriasM = new Categorias_model();
        $data['categorias'] = $categoriasM->getCategorias(); // traigo categorías

        $data['producto']['id'] = $id;

        echo view('plantilla\Header', ['titulo' => 'Producto ' . $id]);
        echo view('productos\edit', $data);
        echo view('plantilla\Footer');
    }

    public function modifica($id)
    {
        $productoModel = new Productos_model();
        $producto = $productoModel->find($id);
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
        return $this->response->redirect(site_url('crear'));
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
        $data['productos'] = $productoModel->getProductoAll();
        
        echo view('plantilla\Header', ['titulo' => 'Productos Eliminados']);
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
        return $this->response->redirect(site_url('eliminados'));
    }

    public function catalogo_filtrado(){
        
        $productoModel = new Productos_model();
        $categoriaModel = new Categorias_model();

        $categoria_id = $this->request->getGet('categoria');
        $ordenPrecio = $this->request->getGet('ordenPrecio'); // asc o desc

        // Filtrar por categoría
        if ($categoria_id) {
            $productos = $productoModel->getProductosPorCategoria($categoria_id);
            $data['categoriaSeleccionada'] = $categoria_id;
        } else {
            $productos = $productoModel->getProductoAll();
            $data['categoriaSeleccionada'] = '';
        }

        // Ordenar por precio si se seleccionó
        if ($ordenPrecio == 'asc') {
            usort($productos, function($a, $b) {
                return $a['precio_vta'] <=> $b['precio_vta'];
            });
        } elseif ($ordenPrecio == 'desc') {
            usort($productos, function($a, $b) {
                return $b['precio_vta'] <=> $a['precio_vta'];
            });
        }

        $data['productos'] = $productos;
        $data['categorias'] = $categoriaModel->getCategorias();
        $data['ordenPrecio'] = $ordenPrecio;

        echo view('plantilla/Header', ['titulo' => 'Catálogo Filtrado']);
        echo view('Catalogo', $data);
        echo view('plantilla/Footer');
    }


    public function catalogo()
{
    $productoModel = new Productos_model();
    $categoriaModel = new Categorias_model();

    // Obtener filtros de GET
    $categoriaSeleccionada = $this->request->getGet('categoria');
    $ordenPrecio = $this->request->getGet('ordenPrecio'); // "asc" o "desc"

    // Obtener categorías para el dropdown
    $data['categorias'] = $categoriaModel->getCategorias();
    $data['categoriaSeleccionada'] = $categoriaSeleccionada;
    $data['ordenPrecio'] = $ordenPrecio;

    // Filtrar productos
    if ($categoriaSeleccionada) {
        $productos = $productoModel->getProductosPorCategoria($categoriaSeleccionada);
    } else {
        $productos = $productoModel->getProductoAll();
    }

    // Ordenar por precio si se seleccionó
    if ($ordenPrecio == 'asc') {
        usort($productos, function($a, $b) {
            return $a['precio_vta'] <=> $b['precio_vta'];
        });
    } elseif ($ordenPrecio == 'desc') {
        usort($productos, function($a, $b) {
            return $b['precio_vta'] <=> $a['precio_vta'];
        });
    }

    $data['productos'] = $productos;

    echo view('plantilla/Header', ['titulo' => 'Catálogo']);
    echo view('Catalogo', $data);
    echo view('plantilla/Footer');
}


}

