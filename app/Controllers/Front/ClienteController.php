<?php

namespace App\Controllers\Front;

use App\Models\usuario_model;
use App\Controllers\BaseController;

class ClienteController extends BaseController
{
    protected $usuarioModel;
    protected $session;
    protected $helpers = ['url', 'form'];

    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
        $this->session = session();
    }

    public function perfil()
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Obtener los datos del usuario
        $data['usuario'] = $this->usuarioModel->obtener_usuario_por_id($usuario_id);
        
        return view('front/cliente/perfil', $data);
    }
    
    public function actualizar_perfil()
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Validar los datos del formulario
        $rules = [
            'nombre' => 'required|min_length[3]',
            'apellido' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'provincia' => 'required'
        ];
        
        if ($this->request->getPost('pass') != '') {
            $rules['pass'] = 'min_length[6]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Preparar los datos para actualizar
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email' => $this->request->getPost('email'),
            'provincia' => $this->request->getPost('provincia')
        ];
        
        // Si se proporcionó una nueva contraseña, actualizarla
        if ($this->request->getPost('pass') != '') {
            $data['pass'] = password_hash($this->request->getPost('pass'), PASSWORD_DEFAULT);
        }
        
        // Actualizar el usuario
        $this->usuarioModel->actualizar_usuario($usuario_id, $data);
        
        // Actualizar los datos de la sesión
        $this->session->set([
            'usuario_nombre' => $data['nombre'],
            'usuario_apellido' => $data['apellido'],
            'usuario_email' => $data['email']
        ]);
        
        return redirect()->to('front/cliente/perfil')->with('mensaje', 'Perfil actualizado correctamente');
    }
}