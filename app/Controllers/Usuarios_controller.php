<?php
namespace App\Controllers;
Use App\Models\Usuarios_model;
use CodeIgniter\Controller;

class Usuarios_controller extends Controller{

    public function construct(){
        helper(['form', 'url']);
    }

    public function create(){
        $dato['titulo'] = 'Registro';
        echo view('plantilla\Header', ['titulo' => 'Registro']);
        echo view('Registro');
        echo view('plantilla\Footer');
    }

    public function formValidation(){
        $input = $this->validate([
            'nombre' => 'required|min_length[3]',
            'apellido' => 'required|min_length[3]|max_length[25]', 
            'email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[usuarios.email]',
            'usuario' => 'required|min_length[3]',  
            'pass' => 'required|min_length[3]|max_length[10]'  
        ]); 

        $formModel = new Usuarios_model();

        if (!$input) {
            $data['titulo']='Registro';
            echo view('plantilla\Header', ['titulo' => 'Registro']);
            echo view('Registro', ['validation' => $this->validator]);
            echo view('plantilla\Footer');

        } else {
            $formModel->save([
                'nombre' => $this->request->getVar('nombre'),
                'apellido'=> $this->request->getVar('apellido'),
                'usuario'=> $this->request->getVar('email'),
                'email'=> $this->request->getVar('usuario'),
                'pass' => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT)
                // password_hash() crea un nuevo hash de contraseña usando un algoritmo de hash de único sentido.
            ]);

            // Flashdata funciona solo en redirigir la función en el controlador en la vista de carga.
            session()->setFlashdata('success', 'Usuario registrado con exito');
            return $this->response->redirect(to_url('/Registro'));
        }
    }
}