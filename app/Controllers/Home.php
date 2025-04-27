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
                echo view('Principal');
                break;

            case "Comercializacion":
                echo view('Principal');
                break;

            case "Terminos Y Usos":
                echo view('Principal');
                break;

            case "Catalogo":
                echo view('Principal');
                break;

            case "Consultas":
                echo view('Principal');
                break;
        }
    }
}
