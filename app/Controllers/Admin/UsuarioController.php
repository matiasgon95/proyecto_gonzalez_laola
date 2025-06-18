<?php

namespace App\Controllers\Admin;

use App\Models\usuario_model;
use App\Controllers\BaseController;

/**
 * UsuarioController
 * 
 * Controlador encargado de gestionar todas las operaciones relacionadas con usuarios
 * en el panel de administración, incluyendo listar, agregar, editar, eliminar y gestionar
 * el estado de los usuarios (bloquear/desbloquear).
 */
class UsuarioController extends BaseController
{
    /**
     * Instancia del modelo de usuarios
     *
     * @var usuario_model
     */
    protected $usuarioModel;
    
    /**
     * Helpers utilizados en este controlador
     *
     * @var array
     */
    protected $helpers = ['url', 'form'];

    /**
     * Constructor del controlador
     * Inicializa el modelo de usuarios
     */
    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
    }

    /**
     * Muestra la lista de todos los usuarios
     *
     * @return view
     */
    public function index()
    {
        $data['usuarios'] = $this->usuarioModel->obtener_usuarios();
        return view('back/usuarios/lista_usuarios_view', $data);
    }
    
    /**
     * Muestra la lista de usuarios con perfil de cliente
     *
     * @return view
     */
    public function clientes()
    {
        $data['usuarios'] = $this->usuarioModel->obtener_clientes();
        $data['tipo'] = 'clientes';
        return view('back/usuarios/lista_usuarios_view', $data);
    }
    
    /**
     * Muestra la lista de usuarios con perfil de administrador
     *
     * @return view
     */
    public function administradores()
    {
        $data['usuarios'] = $this->usuarioModel->obtener_administradores();
        $data['tipo'] = 'administradores';
        return view('back/usuarios/lista_usuarios_view', $data);
    }

    /**
     * Muestra el formulario para agregar un nuevo usuario
     *
     * @param string $tipo Tipo de usuario a agregar (admin por defecto)
     * @return view
     */
    public function agregar($tipo = 'admin')
    {
        $data['tipo'] = $tipo;
        return view('back/usuarios/agregausuario_view', $data);
    }

    /**
     * Procesa el formulario de agregar usuario y guarda los datos
     * Realiza validaciones y establece valores predeterminados
     *
     * @return redirect
     */
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
        $data['baja'] = 'no'; // Usuario activo por defecto
        $data['perfil_id'] = 1; // Perfil de administrador (1)
        // Nota: Se eliminó la asignación automática de usuario = email
        
        // Encriptar contraseña
        $data['pass'] = password_hash($data['pass'], PASSWORD_DEFAULT);
        $this->usuarioModel->agregar_usuario($data);
    
        return redirect()->to(site_url('admin/usuarios'))->with('mensaje', 'Administrador creado correctamente');
    }

    /**
     * Muestra el formulario para editar un usuario existente
     *
     * @param int $id ID del usuario a editar
     * @return view
     */
    public function editar($id)
    {
        $data['usuario'] = $this->usuarioModel->obtener_usuario_por_id($id);
        return view('back/usuarios/editarusuario_view', $data);
    }

    /**
     * Procesa el formulario de edición y actualiza los datos del usuario
     * Si la contraseña está vacía, no la actualiza
     *
     * @param int $id ID del usuario a actualizar
     * @return redirect
     */
    public function actualizar($id)
    {
        $data = $this->request->getPost();
        
        // Validación básica para actualización
        $rules = [
            'nombre' => 'required|min_length[3]',
            'apellido' => 'required|min_length[2]',
            'email' => 'required|valid_email',
            // Nota: Se eliminó la validación del campo 'usuario'
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

    /**
     * Elimina un usuario del sistema
     *
     * @param int $id ID del usuario a eliminar
     * @return redirect
     */
    public function eliminar($id)
    {
        $this->usuarioModel->eliminar_usuario($id);
        return redirect()->back()->with('mensaje', 'Usuario eliminado correctamente');
    }
    
    /**
     * Bloquea un usuario (cambia su estado a 'baja')
     *
     * @param int $id ID del usuario a bloquear
     * @return redirect
     */
    public function bloquear($id)
    {
        $this->usuarioModel->bloquear_usuario($id);
        return redirect()->back()->with('mensaje', 'Usuario bloqueado correctamente');
    }
    
    /**
     * Desbloquea un usuario (cambia su estado a 'no')
     *
     * @param int $id ID del usuario a desbloquear
     * @return redirect
     */
    public function desbloquear($id)
    {
        $this->usuarioModel->desbloquear_usuario($id);
        return redirect()->back()->with('mensaje', 'Usuario desbloqueado correctamente');
    }
}
