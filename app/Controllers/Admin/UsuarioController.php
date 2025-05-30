<?php

namespace App\Controllers;

use App\Models\usuario_model;
use CodeIgniter\Controller;

class UsuarioController extends Controller
{
    protected $usuarioModel;
    protected $helpers = ['url', 'form'];

    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
    }

    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->obtener_usuarios();
        return view('back/usuarios/lista_usuarios_view', $data);
    }

    public function agregar()
    {
        return view('back/usuarios/agregausuario_view');
    }

    public function guardar()
    {
        $data = $this->request->getPost();
        $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
        $this->Usuario_model->agregar_usuario($data);
    
        return redirect()->to(site_url('UsuarioController'));
    }


    public function editar($id)
    {
        $data['usuario'] = $this->usuarioModel->obtener_usuario_por_id($id);
        return view('back/usuarios/editarusuario_view', $data);
    }

    public function actualizar($id)
    {
        $data = $this->request->getPost();
        $this->usuarioModel->actualizar_usuario($id, $data);
        return redirect()->to(site_url('UsuarioController'));
    }

    public function eliminar($id)
    {
        $this->usuarioModel->eliminar_usuario($id);
        return redirect()->to(site_url('UsuarioController'));
    }
}
