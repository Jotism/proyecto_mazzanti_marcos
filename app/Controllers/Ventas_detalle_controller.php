<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Ventas_detalle_model;
use App\Models\Productos_model;

class Ventas_detalle_controller extends Controller
{
    public function ver_factura($venta_id)
    {
        $detalle_ventas = new Ventas_detalle_model();
        $data['venta'] = $detalle_ventas->getDetalles($venta_id);

        $dato['titulo'] = "Mi compra";
        echo view('plantilla\Header', $dato); 
        echo view('compras/vista_compras', $data);
        echo view('plantilla\Footer');
    }

}