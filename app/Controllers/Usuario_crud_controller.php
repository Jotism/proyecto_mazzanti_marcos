<?php

namespace App\Controllers;
use App\Models\Usuarios_Model;
use App\Models\consulta_Model;
use CodeIgniter\Controller;

class Usuario_crud_controller extends Controller
{
    public function __construct() {
        helper(['url','form']);
    }

    // Mostrar lista de usuarios
    public function index() {
        $userModel = new Usuarios_Model();
        $data['users'] = $userModel->orderBy('id', 'DESC')->findAll();
        $data['titulo'] = 'Crud_usuarios';

        echo view('plantilla\Header', $data);
        echo view('usuario/usuario_vista', $data);
        echo view('plantilla\Footer');
    }

    // Mostrar formulario de creación de usuario
    public function create() {
        $userModel = new Usuarios_Model();
        $data['user_obj'] = $userModel->orderBy('id', 'DESC')->findAll();
        $data['titulo'] = 'Alta Usuario';

        echo view('plantilla\Header', $data);
        echo view('usuario/usuario_crud', $data);
        echo view('plantilla\Footer');
    }

    // Validar y guardar datos del usuario
    public function store() {
        $input = $this->validate([
            'nombre'   => 'required|min_length[3]',
            'apellido' => 'required|min_length[3]|max_length[25]',
            'email'    => 'required|min_length[3]|max_length[100]|valid_email|is_unique[usuarios.email]',
            'usuario'  => 'required|min_length[3]',
            'pass'     => 'required|min_length[3]|max_length[10]'
        ]);

        $userModel = new Usuarios_Model();

        if (!$input) {
            $data['titulo'] = 'Modificacion';
            echo view('plantilla\Header', $data);
            echo view('usuario/usuario_crud', [
                'titulo' => 'Alta Usuario',
                'validation' => $this->validator
            ]);
            echo view('plantilla\Footer');
        } else {
            $data = [
                'nombre'   => $this->request->getVar('nombre'),
                'apellido' => $this->request->getVar('apellido'),
                'usuario'  => $this->request->getVar('usuario'),
                'email'    => $this->request->getVar('email'),
                'pass'     => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT)
            ];
            $userModel->insert($data);
            return $this->response->redirect(site_url('users-list'));
        }
    }

    // Mostrar datos de un usuario por id
    public function singleUser($id = null) {
        $userModel = new Usuarios_Model();
        $data['user_obj'] = $userModel->where('id', $id)->first();
        $data['titulo'] = 'Crud_usuarios';

        echo view('plantilla\Header', $data);
        echo view('usuario/edit_usuarios', $data);
        echo view('plantilla\Footer');
    }

    // Actualizar datos del usuario
    public function update() {
        $userModel = new Usuarios_Model();
        $id = $this->request->getVar('id');

        $data = [
            'nombre'    => $this->request->getVar('nombre'),
            'apellido'  => $this->request->getVar('apellido'),
            'usuario'   => $this->request->getVar('usuario'),
            'email'     => $this->request->getVar('email'),
            'perfil_id' => $this->request->getVar('perfil')
        ];
        $userModel->update($id, $data);
        return $this->response->redirect(site_url('users-list'));
    }

    // Baja lógica (soft delete)
    public function deleteLogico($id = null) {
        $userModel = new Usuarios_Model();
        $data['baja'] = $userModel->where('id', $id)->first();
        $data['baja'] = 'SI';
        $userModel->update($id, $data);
        return $this->response->redirect(site_url('users-list'));
    }

    // Activar usuario
    public function activar($id = null) {
        $userModel = new Usuarios_Model();
        $data['baja'] = $userModel->where('id', $id)->first();
        $data['baja'] = 'NO';
        $userModel->update($id, $data);
        return $this->response->redirect(site_url('users-list'));
    }
}
