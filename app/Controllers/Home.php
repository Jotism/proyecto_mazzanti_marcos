<?php

namespace App\Controllers;

use App\Models\Productos_model;
use App\Models\Categorias_model;

class Home extends BaseController
{
    public function index($cuerpo = "Principal")
    {
        echo view('plantilla/Header', ['titulo' => $cuerpo]);

        Home::selectorDeCuerpo($cuerpo);

        echo view('plantilla/Footer');
    }

    private function selectorDeCuerpo($cuerpo)
    {
        switch($cuerpo){

            case "Principal":
                echo view('Principal');
                break;

            case "Quienes Somos":
                echo view('QuienesSomos');
                break;

            case "Contacto":
                echo view('Contacto');
                break;

            case "Comercializacion":
                echo view('Comercializacion');
                break;

            case "Terminos Y Usos":
                echo view('TerminosYUso');
                break;

            case "Catalogo":
                $productoModel = new Productos_model();
                $categoriaModel = new Categorias_model();

                $data['productos'] = $productoModel->getProductoAll();
                $data['categorias'] = $categoriaModel->getCategorias();
                echo view('Catalogo', $data);
                break;

            case "Consultas":
                echo view('Principal');
                break;

            case "Registro":
                echo view('Registro');
                break;

            case "Login":
                echo view ('Login');
                break;

            case "Carrito_parte_view":
                echo view('Carrito_parte_view');
                break;
            
            case "Nuevo producto":
                echo view('productos\Producto_nuevo');
                break;
                
        }
    }
}
