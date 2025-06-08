<?php

namespace App\Controllers\Front;

use App\Models\usuario_model;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    protected $usuarioModel;
    protected $session;
    protected $helpers = ['url', 'form'];

    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
        $this->session = session();
    }

    public function index()
    {
        // Si ya está logueado, redirigir al dashboard
        if (session()->get('usuario_logueado')) {
            return redirect()->to('front/cliente/dashboard');
        }

        return view('front/login');
    }   


    public function autenticar()
    {
        $email = strtolower(trim($this->request->getPost('email')));
        $pass = $this->request->getPost('pass');

        $usuario = $this->usuarioModel->obtener_por_email($email);

        if ($usuario) {
            if (password_verify($pass, $usuario->pass)) {
                // Guardar en sesión
                $this->session->set([
                    'usuario_id'       => $usuario->id,
                    'usuario_email'    => $usuario->email,
                    'usuario_nombre'   => $usuario->nombre,
                    'usuario_apellido' => $usuario->apellido, // Añadir el apellido a la sesión
                    'perfil_id'        => $usuario->perfil_id,
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

    public function dashboard()
    {
        if (!session()->get('usuario_logueado')) {
            return redirect()->to('front/login');
        }

        return view('front/cliente/dashboard');
    }


    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('front/login');
    }
}
