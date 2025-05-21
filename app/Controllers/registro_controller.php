<?php

namespace App\Controllers;

use App\Models\usuario_model;
use CodeIgniter\Controller;

class registro_controller extends Controller
{
    protected $usuarioModel;
    protected $session;

    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
        $this->session = session();
        helper(['form', 'url']);
    }

    public function index()
    {
        return view('front/registro_usuario');
    }

    public function guardar()
    {
        // Reglas de validación mejoradas
        $rules = [
            'nombre' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El nombre es obligatorio',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres'
                ]
            ],
            'apellido' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'El apellido es obligatorio',
                    'min_length' => 'El apellido debe tener al menos 3 caracteres'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[usuarios.email]',
                'errors' => [
                    'required' => 'El email es obligatorio',
                    'valid_email' => 'Por favor ingrese un email válido',
                    'is_unique' => 'Este email ya está registrado'
                ]
            ],
            'pass' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'La contraseña es obligatoria',
                    'min_length' => 'La contraseña debe tener al menos 6 caracteres'
                ]
            ],
            'provincia' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La provincia es obligatoria'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            // Redirigir con errores en lugar de usar dd()
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre'    => trim($this->request->getPost('nombre')),
            'apellido'  => trim($this->request->getPost('apellido')),
            'email'     => strtolower(trim($this->request->getPost('email'))),
            'pass'      => password_hash($this->request->getPost('pass'), PASSWORD_DEFAULT),
            'provincia' => trim($this->request->getPost('provincia')),
            'perfil_id' => 2,
        ];

        try {
            $result = $this->usuarioModel->agregar_usuario($data);
            
            if ($result === false) {
                throw new \Exception('Error al insertar en la base de datos');
            }

            $this->session->setFlashdata('success', '¡Usuario registrado con éxito! Por favor, inicia sesión.');
            return redirect()->to(base_url('front/login'));
        } catch (\Exception $e) {
            log_message('error', 'Error al registrar usuario: ' . $e->getMessage());
            $this->session->setFlashdata('error', 'Error al registrar el usuario. Por favor, intente nuevamente.');
            return redirect()->back()->withInput();
        }
    }
}
