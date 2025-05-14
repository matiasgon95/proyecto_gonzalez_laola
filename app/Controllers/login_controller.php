<?php

namespace App\Controllers;

use App\Models\usuario_model;
use CodeIgniter\Controller;

class login_controller extends Controller
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
        // Mostrar vista de login
        return view('login');
    }

    public function autenticar()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $this->usuarioModel->obtener_por_email($email);

        if ($usuario) {
            if (password_verify($password, $usuario['password'])) {
                // Guardar en sesión
                $this->session->set([
                    'usuario_id'       => $usuario['id'],
                    'usuario_email'    => $usuario['email'],
                    'usuario_nombre'   => $usuario['nombre'],
                    'usuario_logueado' => true
                ]);
                return redirect()->to('/panel'); // Ruta protegida con filtro auth
            } else {
                $this->session->setFlashdata('error', 'Contraseña incorrecta.');
                return redirect()->to('/login');
            }
        } else {
            $this->session->setFlashdata('error', 'El usuario no existe.');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/login');
    }
}
