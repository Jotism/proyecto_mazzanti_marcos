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
        echo view('plantilla\Header', $dato);
        echo view('consulta\Consultas', $data);
        echo view('plantilla\Footer');
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
        //Chatgot hacer metodo ver vista consulta
    }

    public function obtenerConsultasPorEmail($email){
        return $this->where('email', $email)->findAll();
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


}
