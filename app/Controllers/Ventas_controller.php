<?php
namespace App\Controllers;
use CodeIgniter\Controller;
Use App\Models\Producto_model;
Use App\Models\Usuarios_model;
Use App\Models\Ventas_cabecera_model;
Use App\Models\Ventas_detalle_model;

class Ventas_controller extends Controller{

    public function registrar_venta()
    {
        $session = session();
        require(APPPATH . 'Controllers/carrito_controller.php');
        $cartController = new carrito_controller(); //instancia
        $carrito_contents = $cartController->devolver_carrito();

        $productoModel = new Producto_model();
        $ventasModel = new Ventas_cabecera_model();
        $detalleModel = new Ventas_detalle_model();

        $productos_validos = [];
        $productos_sin_stock = [];
        $total = 0;

        // Validar stock y filtrar productos válidos
        foreach ($carrito_contents as $item) {
            $producto = $productoModel->getProducto($item['id']);

            if ($producto && $producto['stock'] >= $item['qty']) {
                $productos_validos[] = $item;
                $total += $item['subtotal'];
            } else {
                $productos_sin_stock[] = $item['name'];
                // Eliminar del carrito el producto sin stock
                $cartController->eliminar_item($item['rowid']);
            }
        }

        // Si hay productos sin stock, avisar y volver al carrito
        if (!empty($productos_sin_stock)) {
            $mensaje = 'Los siguientes productos no tienen stock suficiente y fueron eliminados del carrito: <br>' .
            implode(', ', $productos_sin_stock);
            $session->setFlashdata('mensaje', $mensaje);
            return redirect()->to(base_url('muestra'));
        }

        // Si no hay productos válidos, no se registra la venta
        if (empty($productos_validos)) {
            $session->setFlashdata('mensaje', 'No hay productos válidos para registrar la venta.');
            return redirect()->to(base_url('muestra'));
        }

        // Registrar cabecera de la venta
        $nueva_venta = [
            'usuario_id' => $session->get('id_usuario'),
            'total_venta' => $total
        ];
        $venta_id = $ventasModel->insert($nueva_venta);

        // Registrar detalle y actualizar stock
        foreach ($productos_validos as $item) {
            $detalle = [
                'venta_id' => $venta_id,
                'producto_id' => $item['id'],
                'cantidad' => $item['qty'],
                'precio' => $item['subtotal']
            ];
            $detalleModel->insert($detalle);

            $producto = $productoModel->getProducto($item['id']);
            $productoModel->updateStock($item['id'], $producto['stock'] - $item['qty']);
        }

        // Vaciar carrito y mostrar confirmación
        $cartController->borrar_carrito();
        $session->setFlashdata('mensaje', 'Venta registrada exitosamente.');
        return redirect()->to(base_url('vista_compras/' . $venta_id));
    }

    // función del usuario cliente para ver sus compras
    public function ver_factura($venta_id)
    {
        //echo $venta_id;die;
        $detalle_ventas = new Ventas_detalle_model();
        $data['venta'] = $detalle_ventas->getDetalles($venta_id);

        $dato['titulo'] = "Mi compra";
        echo view('front/head_view_crud', $dato);
        echo view('front/nav_view');
        echo view('back/compras/vista_compras', $data);
        echo view('front/footer_view');
    }

    // función del cliente para ver el detalle de su facturas de compras
    public function ver_facturas_usuario($id_usuario){
        $ventas = new Ventas_cabecera_model();

        $data['ventas'] = $ventas->getVentas($id_usuario);
        $dato['titulo'] = "Todos mis compras";

        echo view('front/head_view_crud', $dato);
        echo view('front/nav_view');
        echo view('back/compras/ver_factura_usuario', $data);
        echo view('front/footer_view');
    }
}
