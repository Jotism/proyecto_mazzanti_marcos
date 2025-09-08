<?php  
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Usuarios_model;
use App\Models\Producto_Model;
use App\Models\Ventas_cabecera_model;
use App\Models\Ventas_detalle_model;

class carrito_controller extends BaseController  
{  
    public function __construct()  
    {  
        helper(['form', 'url', 'cart']);  
        $cart = \Config\Services::cart();  
        $session = session();  
    }  

    public function catalogo()  
    {  
    $productoModel = new Productos_model();  
    $productos = $productoModel->orderBy('id', 'DESC')->findAll();  

    $data = [
        'producto' => $productos,
        'titulo' => 'Todos los Productos'
    ];
    echo view('plantilla\Header', $data);
    echo view('Catalogo', $data);
    echo view('plantilla\Footer');
    }

    public function muestra() //carrito que se muestra  
    {  
        $cart = \Config\Services::cart();  
        $cart = $cart->contents();  
        $data['cart'] = $cart;  

        $dato['titulo'] = 'Confirmar compra';  
        echo view('plantilla\Header', $dato); 
        echo view('carrito/carrito_parte_view', $data);  
        echo view('plantilla\Footer');
    }  

    public function add() //agregar productos al carrito  
    {  
        $request = \Config\Services::request(); //trae todo lo que se envia por POST  
        $cart = \Config\Services::Cart(); //devuelve una instancia del carrito  

        $cart->insert([  
            'id'    => $request->getPost('id'),  
            'qty'   => 1,  
            'name'  => $request->getPost('nombre_prod'),  
            'price' => $request->getPost('precio_vta'),  
            'imagen' => $request->getPost('imagen')
        ]);  

        return redirect()->back()->withInput();  
    }  

    public function eliminar_item($rowid)  
    {  
        $cart = \Config\Services::Cart();  
        $cart->remove($rowid);  
        return redirect()->to(base_url('muestra'));  
    }  

    public function borrar_carrito()  
    {  
        $cart = \Config\Services::Cart();  
        $cart->destroy();  
        return redirect()->to(base_url('muestra'));  
    }
     
    public function remove($rowid)  
    {  
        $cart = \Config\Services::cart();  
        if ($rowid === "all") {  
            $cart->destroy(); //vacía el carrito  
        } else {  
            $cart->remove($rowid);  
        }  
        return redirect()->back()->withInput();  
    }  

    public function actualiza_carrito()  
    {  
        $cart = \Config\Services::cart();  
        $request = \Config\Services::request();  

        $cart->update([  
            'id'     => $request->getPost('id'),  
            'qty'    => 1,  
            'price'  => $request->getPost('precio_vta'),
            'name'   => $request->getPost('nombre_prod'),  
            'imagen' => $request->getPost('imagen'),  
        ]);  

        return redirect()->back()->withInput();  
    }  

    public function devolver_carrito()  
    {  
        $cart = \Config\Services::cart();  
        return $cart->contents();  
    }  

    public function suma($rowid)  
    {  
        // suma 1 a la cantidad del producto  
        $cart = \Config\Services::cart();  
        $item = $cart->getItem($rowid);  
        if ($item) {  
            $cart->update([  
                'rowid' => $rowid,  
                'qty'   => $item['qty'] + 1  
            ]);  
        }  
        return redirect()->to('muestra');  
    }  

    public function resta($rowid)  
    {  
        // resta 1 a la cantidad al producto  
        $cart = \Config\Services::cart();  
        $item = $cart->getItem($rowid);  

        if ($item) {  
            if ($item['qty'] > 1) {  
                $cart->update([  
                    'rowid' => $rowid,  
                    'qty'   => $item['qty'] - 1  
                ]);  
            } else {  
                $cart->remove($rowid);  
            }  
        }
        return redirect()->to('muestra');  
    }
}
