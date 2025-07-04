<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Productos_model;
use App\Models\Usuarios_model;
use App\Models\Ventas_cabecera_model;
use App\Models\Ventas_detalle_model;

class Ventas_cabecera_controller extends Controller
{
    public function registrar_venta()
    {
        $session = session();
        require(APPPATH . 'Controllers/carrito_controller.php');
        $cartController = new carrito_controller();
        $carrito_contents = $cartController->devolver_carrito();

        $productoModel = new Productos_model();
        $ventasModel = new Ventas_cabecera_model();
        $detalleModel = new Ventas_detalle_model();

        $carritoController = new Carrito_controller();
        $datos_validados = $carritoController->validar_productos();

        
        $productos_validos = $datos_validados['productos_validos'];
        $productos_sin_stock = $datos_validados['productos_sin_stock'];
        $total = $datos_validados['total'];
        
        
        if (empty($productos_validos)) {
            return redirect()->to('/muestra')->with('error', 'No hay productos con stock suficiente.');
        }

        $venta_id = $ventasModel->insert([
            'fecha' => date('Y-m-d'),
            'usuario_id' => $session->get('id'),
            'total_venta' => $total
        ]);

        foreach ($productos_validos as $item) {
            $detalleModel->insert([
                'venta_id' => $venta_id,
                'producto_id' => $item['id'],
                'cantidad' => $item['qty'],
                'precio' => $item['price']
            ]);

            $productoModel->updateStock($item['id'], -$item['qty']);
        }

        $cartController->borrar_carrito();

        return redirect()->to('vista_compras/' . $venta_id);
    }

    public function ver_facturas_usuario($id_usuario)
    {
        $ventas = new Ventas_cabecera_model();

        $data['ventas'] = $ventas->getVentas($id_usuario);
        $dato['titulo'] = "Todos mis compras";

        echo view('plantilla\Header', $dato); 
        echo view('compras/ver_factura_usuario', $data);
        echo view('plantilla\Footer');
    }

    public function ventas()
    {
        $venta_id = $this->request->getGet('id');

        $detalle_ventas = new Ventas_detalle_model();
        $data['venta'] = $detalle_ventas->getDetalles($venta_id);

        $ventascabecera = new Ventas_cabecera_model();
        $data['usuarios'] = $ventascabecera->getBuilderVentas_cabecera();

        $dato['titulo'] = "ventas";
        echo view('plantilla\Header', $dato);
        echo view('ventas/ventas', $data);
        echo view('plantilla\Footer');
    }
}
