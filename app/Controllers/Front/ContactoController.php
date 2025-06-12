<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Models\ConsultaModel;

class ContactoController extends BaseController
{
    protected $consultaModel;
    
    public function __construct()
    {
        $this->consultaModel = new ConsultaModel();
        helper(['form', 'url']);
    }
    
    public function index()
    {
        return view('front/contacto', [
            'titulo' => 'Contacto'
        ]);
    }
    
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
        
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Guardar la consulta en la base de datos
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email' => $this->request->getPost('email'),
            'asunto' => $this->request->getPost('asunto'),
            'mensaje' => $this->request->getPost('consulta'),
            'estado' => 'pendiente'
        ];
        
        $this->consultaModel->insert($data);
        
        return redirect()->to('contacto')->with('mensaje', 'Tu consulta ha sido enviada correctamente. Te responderemos a la brevedad.');
    }
}