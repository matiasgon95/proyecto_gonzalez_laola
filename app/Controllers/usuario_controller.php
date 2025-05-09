<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class usuario_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Usuario_model');
        $this->load->helper('url');
    }

    public function index() {
        $data['usuarios'] = $this->Usuario_model->obtener_usuarios();
        $this->load->view('back/usuarios/lista_usuarios_view', $data);
    }

    public function agregar() {
        $this->load->view('back/usuarios/agregausuario_view');
    }

    public function guardar() {
        $data = $this->input->post();
        $this->Usuario_model->agregar_usuario($data);
        redirect('usuario_controller');
    }

    public function editar($id) {
        $data['usuario'] = $this->Usuario_model->obtener_usuario_por_id($id);
        $this->load->view('back/usuarios/editarusuario_view', $data);
    }

    public function actualizar($id) {
        $data = $this->input->post();
        $this->Usuario_model->actualizar_usuario($id, $data);
        redirect('usuario_controller');
    }

    public function eliminar($id) {
        $this->Usuario_model->eliminar_usuario($id);
        redirect('usuario_controller');
    }
}
