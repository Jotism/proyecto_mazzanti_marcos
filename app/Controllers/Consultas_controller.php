<?php

namespace App\Controllers;
use App\Models\consulta_Model;
use CodeIgniter\Controller;

class Consultas_controller extends Controller
{
    public function __construct() {
    helper(['url', 'form']); 
    }


    public function listar_consultas(){
        // instancio el modelo de consultas
        $consultas = new Consulta_model();
        // traer todos los consultas activas desde la db
        $data['consultas'] = $consultas->getConsultas();
        $dato['titulo']= 'Gestion-Consultas';
        // carga la vista
        echo view('plantilla/Header', $dato);
        echo view('consultas/Consultas', $data);
        echo view('plantilla/Footer');

    }

    public function atender_consulta($id = null){
        // instancio el modelo de consultas
        $consultasM = new Consulta_model();
        // traigo consulta por id
        $consultasM->getConsulta($id);
        // actualizo el estado de la consulta
        $consultasM->update($id, ['respuesta' => 'SI']);
        // redirecciona al metodo de el controlador
        return redirect()->to(base_url('listar_consultas'));
    }

    public function eliminar_consulta($id = null){
        // instancio el modelo de consultas
        $model = new Consulta_model();
        // traigo consulta por id
        $model->getConsulta($id);
        // elimino la consulta
        $model->delete($id);
        // redirecciona al metodo de el controlador
        return redirect()->to(base_url('listar_consultas'));
    }

    public function guardar_consulta() {
        $validation = \Config\Services::validation();

        $rules = [
            'nombre'   => 'required|min_length[2]|max_length[50]',
            'apellido' => 'required|min_length[2]|max_length[50]',
            'email'    => 'required|valid_email',
            'telefono' => 'required|numeric|min_length[7]|max_length[15]',
            'mensaje'  => 'required|min_length[5]|max_length[500]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                            ->with('errors', $validation->getErrors());
        }

        $model = new Consulta_model();

        $data = [
            'nombre'    => $this->request->getPost('nombre'),
            'apellido'  => $this->request->getPost('apellido'),
            'email'     => $this->request->getPost('email'),
            'telefono'  => $this->request->getPost('telefono'),
            'mensaje'   => $this->request->getPost('mensaje'),
            'respuesta' => 'NO'
        ];

        $model->insert($data);

        return redirect()->to(base_url('/'))->with('mensaje', 'Consulta enviada correctamente');
    }



    public function vista_consulta_cliente() {
        // Iniciar la sesión
        $session = session();

        // Obtener el email del usuario desde la sesión
        $email = $session->get('email');

        // Pasar el email a la vista también
        $data['email'] = $email;

        // Cargar modelo y traer consultas por email
        $consultasModel = new Consulta_model();
        $data['consultas'] = $consultasModel->obtenerConsultasPorEmail($email);

        // Título para el header
        $data['titulo'] = 'Consulta del Cliente';

        // Cargar las vistas
        echo view('plantilla/Header', $data);
        echo view('consultas/VistaConsultaCliente', $data);
        echo view('plantilla/Footer');
    }

    public function responder_consulta() {
        $id = $this->request->getPost('id_consulta');
        $respuesta = $this->request->getPost('respuesta');

        $model = new Consulta_model();
        $model->update($id, ['respuesta' => $respuesta]);

        return redirect()->to(base_url('listar_consultas'))->with('mensaje', 'Consulta respondida correctamente.');
    }



}
