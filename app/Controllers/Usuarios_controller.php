<?php
namespace App\Controllers;
Use App\Models\Usuarios_model;
use CodeIgniter\Controller;

class Usuarios_controller extends Controller{

    public function __construct(){
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
                'usuario'=> $this->request->getVar('usuario'),
                'email'=> $this->request->getVar('email'),
                'pass' => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT)
            ]);

            // Flashdata funciona solo en redirigir la función en el controlador en la vista de carga.
            session()->setFlashdata('success', 'Usuario registrado con exito');
            return $this->response->redirect('/proyecto_mazzanti_marcos/Registro');
        }
    }

    public function login(){
        echo view('plantilla\\Header', ['titulo' => 'Login']);
        echo view('Login');
        echo view('plantilla\\Footer');
    }

    public function validarLogin(){
        $usuario = $this->request->getVar('usuario');
        $pass = $this->request->getVar('pass');

        $model = new \App\Models\Usuarios_model();
        $dataUsuario = $model->where('usuario', $usuario)
                            ->orWhere('email', $usuario)
                            ->first();

        if ($dataUsuario) {
            if (password_verify($pass, $dataUsuario['pass'])) {
                $sessionData = [
                    'id'       => $dataUsuario['id'],
                    'nombre'   => $dataUsuario['nombre'],
                    'usuario'  => $dataUsuario['usuario'],
                    'email'    => $dataUsuario['email'],
                    'perfil_id'=> $dataUsuario['perfil_id'] ?? 2,
                    'logged_in'=> true
                ];
                session()->set($sessionData);
                return redirect()->to('/dashboard'); // o donde quieras redirigirlo
            } else {
                session()->setFlashdata('error', 'Contraseña incorrecta');
            }
        } else {
            session()->setFlashdata('error', 'Usuario no encontrado');
        }

        return redirect()->to('/login');
    }

    public function logout(){
        session()->destroy();
        return redirect()->to('/login');
    }
}