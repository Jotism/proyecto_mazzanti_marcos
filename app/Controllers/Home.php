<?php

namespace App\Controllers;

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
                echo view('Catalogo');
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

            case "Alta producto":
                echo view('productos\Alta_producto');
                break;
            
            case "Nuevo producto":
                echo view('productos\Producto_nuevo');
                break;

        }
    }
}
