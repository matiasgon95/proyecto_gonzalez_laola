<?php

namespace App\Controllers\Front;

use App\Models\usuario_model;
use CodeIgniter\Controller;

/**
 * LoginController - Gestiona la autenticación de usuarios en el frontend
 * 
 * Este controlador maneja el inicio de sesión, cierre de sesión y
 * la redirección al panel de control según el perfil del usuario.
 */
class LoginController extends Controller
{
    /**
     * @var usuario_model Modelo para operaciones con usuarios
     */
    protected $usuarioModel;
    
    /**
     * @var \CodeIgniter\Session\Session Instancia de la sesión
     */
    protected $session;
    
    /**
     * @var array Helpers utilizados por el controlador
     */
    protected $helpers = ['url', 'form'];

    /**
     * Constructor del controlador
     * 
     * Inicializa el modelo de usuario y la sesión
     */
    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
        $this->session = session();
    }

    /**
     * Muestra la página de inicio de sesión
     * 
     * Si el usuario ya está logueado, redirige al dashboard
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string Vista de login o redirección
     */
    public function index()
    {
        // Si ya está logueado, redirigir al dashboard
        if (session()->get('usuario_logueado')) {
            return redirect()->to('front/cliente/dashboard');
        }

        return view('front/login', [
            'titulo' => 'Iniciar Sesión'
        ]);
    }

    /**
     * Muestra el panel de control del cliente
     * 
     * Verifica que el usuario esté logueado antes de mostrar el dashboard
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string Vista del dashboard o redirección
     */
    public function dashboard()
    {
        if (!session()->get('usuario_logueado')) {
            return redirect()->to('front/login');
        }

        return view('front/cliente/dashboard', [
            'titulo' => 'Panel de Cliente'
        ]);
    }

    /**
     * Procesa la autenticación del usuario
     * 
     * Verifica las credenciales, establece la sesión y redirige según el perfil
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección según resultado
     */
    public function autenticar()
    {
        $email = strtolower(trim($this->request->getPost('email')));
        $pass = $this->request->getPost('pass');

        $usuario = $this->usuarioModel->obtener_por_email($email);

        if ($usuario) {
            // Verificar si el usuario está dado de baja
            if ($usuario->baja == 'si') {
                $this->session->setFlashdata('error', 'Esta cuenta está bloqueada. Contacte con el administrador.');
                return redirect()->to('front/login');
            }
            
            if (password_verify($pass, $usuario->pass)) {
                // Guardar datos del usuario en sesión
                $this->session->set([
                    'usuario_id'       => $usuario->id,
                    'usuario_email'    => $usuario->email,
                    'usuario_nombre'   => $usuario->nombre,
                    'usuario_apellido' => $usuario->apellido,
                    'perfil_id'        => $usuario->perfil_id, // 1=Admin, 2=Cliente
                    'usuario_logueado' => true
                ]);
                
                // Redirigir según perfil
                if ($usuario->perfil_id == 1) {
                    return redirect()->to('back/dashboard'); // Admin
                } else {
                    return redirect()->to('front/cliente/dashboard'); // Cliente
                }
            } else {
                $this->session->setFlashdata('error', 'Contraseña incorrecta.');
                return redirect()->to('front/login');
            }
        } else {
            $this->session->setFlashdata('error', 'El usuario no existe.');
            return redirect()->to('front/login');
        }
    }

    /**
     * Cierra la sesión del usuario
     * 
     * Destruye la sesión actual y redirige a la página de login
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a la página de login
     */
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('front/login');
    }
}
