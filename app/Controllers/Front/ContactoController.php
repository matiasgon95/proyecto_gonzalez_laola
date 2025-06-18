<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\ConsultaModel;

/**
 * ContactoController - Gestiona el formulario de contacto en el frontend
 * 
 * Este controlador maneja la visualización del formulario de contacto
 * y el procesamiento de las consultas enviadas por los usuarios.
 */
class ContactoController extends BaseController
{
    /**
     * @var ConsultaModel Modelo para operaciones con consultas
     */
    protected $consultaModel;
    
    /**
     * Constructor del controlador
     * 
     * Inicializa el modelo de consulta y carga los helpers necesarios
     */
    public function __construct()
    {
        $this->consultaModel = new ConsultaModel();
        helper(['form', 'url']);
    }
    
    /**
     * Muestra la página de contacto
     * 
     * Si el usuario está logueado, redirige a la página de nueva consulta para clientes.
     * Si no está logueado, muestra el formulario de contacto normal.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse|string Vista de contacto o redirección
     */
    public function index()
    {
        // Verificar si el usuario está logueado
        $session = session();
        
        if ($session->has('usuario_id')) {
            // Si está logueado, redirigir a la página de nueva consulta para clientes
            return redirect()->to('front/cliente/nueva_consulta');
        }
        
        // Si no está logueado, mostrar el formulario de contacto normal
        return view('front/contacto', [
            'titulo' => 'Contacto'
        ]);
    }
    
    /**
     * Procesa el envío del formulario de contacto
     * 
     * Valida los datos del formulario, verifica si el usuario está logueado,
     * y guarda la consulta en la base de datos.
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de éxito o errores
     */
    public function enviar()
    {
        // Validación del formulario
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[100]',
            'apellido' => 'required|min_length[3]|max_length[100]',
            'email' => 'required|valid_email',
            'asunto' => 'required|min_length[5]|max_length[200]',
            'consulta' => 'required|min_length[10]'
        ];
        
        // Mensajes personalizados en español
        $messages = [
            'nombre' => [
                'required' => 'El campo Nombre es obligatorio.',
                'min_length' => 'El campo Nombre debe tener al menos {param} caracteres.',
                'max_length' => 'El campo Nombre no puede exceder los {param} caracteres.'
            ],
            'apellido' => [
                'required' => 'El campo Apellido es obligatorio.',
                'min_length' => 'El campo Apellido debe tener al menos {param} caracteres.',
                'max_length' => 'El campo Apellido no puede exceder los {param} caracteres.'
            ],
            'email' => [
                'required' => 'El campo Email es obligatorio.',
                'valid_email' => 'El campo Email debe contener una dirección de correo válida.'
            ],
            'asunto' => [
                'required' => 'El campo Asunto es obligatorio.',
                'min_length' => 'El campo Asunto debe tener al menos {param} caracteres.',
                'max_length' => 'El campo Asunto no puede exceder los {param} caracteres.'
            ],
            'consulta' => [
                'required' => 'El campo Consulta es obligatorio.',
                'min_length' => 'El campo Consulta debe tener al menos {param} caracteres.'
            ]
        ];
        
        // Si la validación falla, redirigir con errores
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Verificar si el usuario está logueado
        $session = session();
        $esRegistrado = 'no';
        $idUsuario = null;
        
        if ($session->has('usuario_id')) {
            $esRegistrado = 'si';
            $idUsuario = $session->get('usuario_id');
        }
        
        // Guardar la consulta en la base de datos
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email' => $this->request->getPost('email'),
            'asunto' => $this->request->getPost('asunto'),
            'mensaje' => $this->request->getPost('consulta'),
            'estado' => 'pendiente',  // Estado inicial de la consulta
            'es_registrado' => $esRegistrado,  // Indica si el usuario está registrado
            'id_usuario' => $idUsuario  // ID del usuario si está registrado
        ];
        
        $this->consultaModel->insert($data);
        
        return redirect()->to('contacto')->with('mensaje', 'Tu consulta ha sido enviada correctamente. Te responderemos a la brevedad.');
    }
}