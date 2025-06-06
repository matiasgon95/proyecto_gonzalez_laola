<?php

namespace App\Controllers\Admin;

use App\Models\usuario_model;
use App\Controllers\BaseController;

class UsuarioController extends BaseController
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
    
    public function clientes()
    {
        $data['usuarios'] = $this->usuarioModel->obtener_clientes();
        $data['tipo'] = 'clientes';
        return view('back/usuarios/lista_usuarios_view', $data);
    }
    
    public function administradores()
    {
        $data['usuarios'] = $this->usuarioModel->obtener_administradores();
        $data['tipo'] = 'administradores';
        return view('back/usuarios/lista_usuarios_view', $data);
    }

    public function agregar($tipo = 'admin')
    {
        $data['tipo'] = $tipo;
        return view('back/usuarios/agregausuario_view', $data);
    }

    public function guardar()
    {
        $data = $this->request->getPost();
        
        // Validación básica
        $rules = [
            'nombre' => 'required|min_length[3]',
            'apellido' => 'required|min_length[2]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'pass' => 'required|min_length[6]',
            'provincia' => 'required',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Establecer valores predeterminados
        $data['baja'] = 'no'; // Siempre activo
        $data['perfil_id'] = 1; // Siempre administrador
        // Eliminar esta línea que asigna el campo usuario
        // $data['usuario'] = $data['email']; 
        
        $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
        $this->usuarioModel->agregar_usuario($data);
    
        return redirect()->to(site_url('admin/usuarios'))->with('mensaje', 'Administrador creado correctamente');
    }

    public function editar($id)
    {
        $data['usuario'] = $this->usuarioModel->obtener_usuario_por_id($id);
        return view('back/usuarios/editarusuario_view', $data);
    }

    public function actualizar($id)
    {
        $data = $this->request->getPost();
        
        // Validación básica para actualización
        $rules = [
            'nombre' => 'required|min_length[3]',
            'apellido' => 'required|min_length[2]',
            'email' => 'required|valid_email',
            // Eliminar la validación de 'usuario'
            // 'usuario' => 'required|min_length[4]',
        ];
        
        // Si la contraseña está vacía, no la actualizamos
        if (empty($data['pass'])) {
            unset($data['pass']);
        } else {
            $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
            $rules['pass'] = 'min_length[6]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $this->usuarioModel->actualizar_usuario($id, $data);
        return redirect()->to(site_url('admin/usuarios'))->with('mensaje', 'Usuario actualizado correctamente');
    }

    public function eliminar($id)
    {
        $this->usuarioModel->eliminar_usuario($id);
        return redirect()->back()->with('mensaje', 'Usuario eliminado correctamente');
    }
    
    public function bloquear($id)
    {
        $this->usuarioModel->bloquear_usuario($id);
        return redirect()->back()->with('mensaje', 'Usuario bloqueado correctamente');
    }
    
    public function desbloquear($id)
    {
        $this->usuarioModel->desbloquear_usuario($id);
        return redirect()->back()->with('mensaje', 'Usuario desbloqueado correctamente');
    }
}
