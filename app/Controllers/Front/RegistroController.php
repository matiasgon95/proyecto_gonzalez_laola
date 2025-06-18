<?php

namespace App\Controllers\Front;

use App\Models\usuario_model;
use CodeIgniter\Controller;

/**
 * Controlador para gestionar el registro de usuarios en el frontend
 * 
 * Este controlador maneja la visualización del formulario de registro
 * y el procesamiento de los datos enviados por el usuario
 */
class RegistroController extends Controller
{
    /**
     * Modelo de usuarios para interactuar con la base de datos
     *
     * @var usuario_model
     */
    protected $usuarioModel;
    
    /**
     * Variable para manejar la sesión del usuario
     *
     * @var \CodeIgniter\Session\Session
     */
    protected $session;

    /**
     * Constructor del controlador
     * 
     * Inicializa el modelo de usuarios, la sesión y los helpers necesarios
     */
    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
        $this->session = session();
        helper(['form', 'url']);
    }

    /**
     * Método para mostrar la página de registro
     * 
     * @return mixed Vista del formulario de registro
     */
    public function index()
    {
        return view('front/registro_usuario', [
            'titulo' => 'Registro de Usuario'
        ]);
    }

    /**
     * Método para procesar el formulario de registro
     * 
     * Valida los datos del formulario, crea el usuario en la base de datos
     * y redirige según el resultado
     * 
     * @return mixed Redirección a login o de vuelta al formulario con errores
     */
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
                'rules' => 'required|min_length[8]|max_length[16]|regex_match[/^(?=.*[A-Z])(?=.*[0-9])/]',
                'errors' => [
                    'required' => 'La contraseña es obligatoria',
                    'min_length' => 'La contraseña debe tener al menos 8 caracteres',
                    'max_length' => 'La contraseña no debe exceder los 16 caracteres',
                    'regex_match' => 'La contraseña debe contener al menos una letra mayúscula y un número'
                ]
            ],
            'provincia' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La provincia es obligatoria'
                ]
            ]
        ];

        // Verificar si la validación ha fallado
        if (!$this->validate($rules)) {
            // Redirigir con errores en lugar de usar dd()
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        // Preparar los datos del usuario para insertar en la base de datos
        $data = [
            'nombre'    => trim($this->request->getPost('nombre')),
            'apellido'  => trim($this->request->getPost('apellido')),
            'email'     => strtolower(trim($this->request->getPost('email'))),
            'pass'      => password_hash($this->request->getPost('pass'), PASSWORD_DEFAULT),
            'provincia' => trim($this->request->getPost('provincia')),
            'perfil_id' => 2, // Perfil de cliente
        ];

        try {
            // Intentar guardar el usuario en la base de datos
            $result = $this->usuarioModel->agregar_usuario($data);
            
            if ($result === false) {
                throw new \Exception('Error al insertar en la base de datos');
            }

            // Registro exitoso, redirigir a login
            $this->session->setFlashdata('success', '¡Usuario registrado con éxito! Por favor, inicia sesión.');
            return redirect()->to(base_url('front/login'));
        } catch (\Exception $e) {
            // Registrar el error y mostrar mensaje al usuario
            log_message('error', 'Error al registrar usuario: ' . $e->getMessage());
            $this->session->setFlashdata('error', 'Error al registrar el usuario. Por favor, intente nuevamente.');
            return redirect()->back()->withInput();
        }
    }
}
