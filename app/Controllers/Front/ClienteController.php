<?php

namespace App\Controllers\Front;

use App\Models\usuario_model;
use App\Models\Ventas_cabecera_model;
use App\Models\Ventas_detalle_model;
use App\Models\FavoritoModel;
use App\Models\ProductoModel;
use App\Models\ConsultaModel; // Agregar esta línea
use App\Controllers\BaseController;

class ClienteController extends BaseController
{
    protected $usuarioModel;
    protected $ventasCabeceraModel;
    protected $ventasDetalleModel;
    protected $favoritoModel;
    protected $productoModel;
    protected $consultaModel; // Agregar esta línea
    protected $session;
    protected $helpers = ['url', 'form'];

    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
        $this->ventasCabeceraModel = new Ventas_cabecera_model();
        $this->ventasDetalleModel = new Ventas_detalle_model();
        $this->favoritoModel = new FavoritoModel();
        $this->productoModel = new ProductoModel();
        $this->consultaModel = new ConsultaModel(); // Agregar esta línea
        $this->session = session();
    }
    
    public function perfil()
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Obtener los datos del usuario
        $data['usuario'] = $this->usuarioModel->obtener_usuario_por_id($usuario_id);
        $data['titulo'] = 'Mi Perfil';
        
        return view('front/cliente/perfil', $data);
    }

    public function pedidos()
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Obtener todos los pedidos del usuario
        $pedidos = $this->ventasCabeceraModel->getVentas($usuario_id);
        
        $data['pedidos'] = $pedidos;
        $data['titulo'] = 'Mis Pedidos';
        return view('front/cliente/pedidos', $data);
    }
    
    // Método para ver el detalle de un pedido específico
    public function detalle_pedido($id)
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Obtener información de la cabecera del pedido
        $pedido = $this->ventasCabeceraModel
            ->select('ventas_cabecera.*, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.provincia')
            ->join('usuarios', 'usuarios.id = ventas_cabecera.usuario_id', 'left')
            ->where('ventas_cabecera.id', $id)
            ->where('ventas_cabecera.usuario_id', $usuario_id) // Asegurar que el pedido pertenece al usuario
            ->first();

        if (!$pedido) {
            return redirect()->to('front/cliente/pedidos')->with('error', 'Pedido no encontrado o no tienes permiso para verlo');
        }

        // Obtener detalles del pedido
        $detalles = $this->ventasDetalleModel->getDetalles($id);

        $data['pedido'] = $pedido;
        $data['detalles'] = $detalles;
        return view('front/cliente/detalle_pedido', $data);
    }
    
    // Método para mostrar los favoritos del cliente
    public function favoritos()
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Obtener todos los favoritos del usuario
        $favoritos = $this->favoritoModel->getFavoritos($usuario_id);
        
        $data['favoritos'] = $favoritos;
        return view('front/cliente/favoritos', $data);
    }
    
    // Método para agregar un producto a favoritos
    public function agregar_favorito()
    {
        // Verificar si el usuario está logueado
        if (!session()->has('usuario_id')) {
            return redirect()->to('front/login')->with('error', 'Debe iniciar sesión para agregar productos a favoritos');
        }
        
        $usuario_id = session()->get('usuario_id');
        $producto_id = $this->request->getPost('producto_id');
        
        if (empty($producto_id)) {
            return redirect()->back()->with('error', 'Producto no válido');
        }
        
        // Agregar a favoritos
        $resultado = $this->favoritoModel->agregarFavorito($usuario_id, $producto_id);
        
        if ($resultado) {
            return redirect()->back()->with('mensaje', 'Producto agregado a favoritos');
        } else {
            return redirect()->back()->with('error', 'El producto ya está en favoritos');
        }
    }
    
    // Método para eliminar un producto de favoritos
    public function eliminar_favorito($producto_id = null)
    {
        // Verificar si el usuario está logueado
        if (!session()->has('usuario_id')) {
            return redirect()->to('front/login')->with('error', 'Debe iniciar sesión para gestionar favoritos');
        }
        
        $usuario_id = session()->get('usuario_id');
        
        if (empty($producto_id)) {
            return redirect()->back()->with('error', 'Producto no válido');
        }
        
        // Eliminar de favoritos
        $this->favoritoModel->eliminarFavorito($usuario_id, $producto_id);
        
        return redirect()->back()->with('mensaje', 'Producto eliminado de favoritos');
    }
    
    // Método para verificar si un producto es favorito (para AJAX)
    public function es_favorito($producto_id = null)
    {
        // Verificar si el usuario está logueado
        if (!session()->has('usuario_id')) {
            return $this->response->setJSON(['esFavorito' => false]);
        }
        
        $usuario_id = session()->get('usuario_id');
        
        if (empty($producto_id)) {
            return $this->response->setJSON(['esFavorito' => false]);
        }
        
        // Verificar si es favorito
        $esFavorito = $this->favoritoModel->esFavorito($usuario_id, $producto_id);
        
        return $this->response->setJSON(['esFavorito' => $esFavorito]);
    }

    public function actualizar_perfil()
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Validar los datos del formulario
        $rules = [
            'nombre' => [
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'El nombre es obligatorio',
                    'min_length' => 'El nombre debe tener al menos 3 caracteres',
                    'max_length' => 'El nombre no debe exceder los 50 caracteres'
                ]
            ],
            'apellido' => [
                'rules' => 'required|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'El apellido es obligatorio',
                    'min_length' => 'El apellido debe tener al menos 3 caracteres',
                    'max_length' => 'El apellido no debe exceder los 50 caracteres'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'El email es obligatorio',
                    'valid_email' => 'Por favor ingrese un email válido'
                ]
            ],
            'provincia' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'La provincia es obligatoria'
                ]
            ]
        ];
        
        // Si se proporciona una contraseña, validarla con las mismas reglas que en el registro
        if ($this->request->getPost('pass') != '') {
            $rules['pass'] = [
                'rules' => 'min_length[8]|max_length[16]|regex_match[/^(?=.*[A-Z])(?=.*[0-9])/]',
                'errors' => [
                    'min_length' => 'La contraseña debe tener al menos 8 caracteres',
                    'max_length' => 'La contraseña no debe exceder los 16 caracteres',
                    'regex_match' => 'La contraseña debe contener al menos una letra mayúscula y un número'
                ]
            ];
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Preparar los datos para actualizar
        $datos = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'email' => $this->request->getPost('email'),
            'provincia' => $this->request->getPost('provincia')
        ];
        
        // Si se proporciona una contraseña, actualizarla
        if ($this->request->getPost('pass') != '') {
            $datos['pass'] = password_hash($this->request->getPost('pass'), PASSWORD_DEFAULT);
        }
        
        // Actualizar los datos del usuario
        $actualizado = $this->usuarioModel->update($usuario_id, $datos);
        
        if ($actualizado) {
            // Actualizar los datos de la sesión
            $usuario = $this->usuarioModel->obtener_usuario_por_id($usuario_id);
            $datosSession = [
                'usuario_nombre' => $usuario->nombre,
                'usuario_apellido' => $usuario->apellido,
                'usuario_email' => $usuario->email
            ];
            session()->set($datosSession);
            
            return redirect()->to('front/cliente/perfil')->with('mensaje', 'Perfil actualizado correctamente');
        } else {
            return redirect()->back()->with('error', 'No se pudo actualizar el perfil');
        }
    }

    // Método para mostrar las consultas del cliente
    public function consultas()
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Obtener todas las consultas del usuario
        $builder = $this->consultaModel->builder();
        $builder->where('id_usuario', $usuario_id);
        $consultas = $builder->orderBy('fecha_creacion', 'DESC')->get()->getResult();
        
        $data['consultas'] = $consultas;
        $data['titulo'] = 'Mis Consultas';
        
        return view('front/cliente/consultas', $data);
    }

    // Método para ver el detalle de una consulta específica
    public function detalle_consulta($id)
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Obtener la consulta asegurándose que pertenezca al usuario
        $builder = $this->consultaModel->builder();
        $consulta = $builder->where('id', $id)
                            ->where('id_usuario', $usuario_id)
                            ->get()
                            ->getRow();
        
        if (!$consulta) {
            return redirect()->to('front/cliente/consultas')
                             ->with('error', 'Consulta no encontrada o no tienes permiso para verla');
        }
        
        $data['consulta'] = $consulta;
        $data['titulo'] = 'Detalle de Consulta';
        
        return $this->response->setJSON(['consulta' => $consulta]);
    }

    // Método para mostrar el formulario de nueva consulta
    public function nueva_consulta()
    {
        $data['titulo'] = 'Nueva Consulta';
        return view('front/cliente/nueva_consulta', $data);
    }

    // Método para guardar la nueva consulta
    public function guardar_consulta()
    {
        // Validación del formulario
        $rules = [
            'asunto' => 'required|min_length[5]|max_length[200]',
            'mensaje' => 'required|min_length[10]'
        ];
        
        // Mensajes personalizados en español
        $messages = [
            'asunto' => [
                'required' => 'El campo Asunto es obligatorio.',
                'min_length' => 'El campo Asunto debe tener al menos {param} caracteres.',
                'max_length' => 'El campo Asunto no puede exceder los {param} caracteres.'
            ],
            'mensaje' => [
                'required' => 'El campo Mensaje es obligatorio.',
                'min_length' => 'El campo Mensaje debe tener al menos {param} caracteres.'
            ]
        ];
        
        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        // Obtener datos del usuario de la sesión
        $session = session();
        $usuario_id = $session->get('usuario_id');
        $usuario = $this->usuarioModel->obtener_usuario_por_id($usuario_id);
        
        // Guardar la consulta en la base de datos
        $data = [
            'nombre' => $usuario->nombre,
            'apellido' => $usuario->apellido,
            'email' => $usuario->email,
            'asunto' => $this->request->getPost('asunto'),
            'mensaje' => $this->request->getPost('mensaje'),
            'estado' => 'pendiente',
            'es_registrado' => 'si',
            'id_usuario' => $usuario_id
        ];
        
        $this->consultaModel->insert($data);
        
        return redirect()->to('front/cliente/consultas')->with('mensaje', 'Tu consulta ha sido enviada correctamente. Te responderemos a la brevedad.');
    }

    public function eliminar_consulta($id)
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Verificar que la consulta exista y pertenezca al usuario
        $builder = $this->consultaModel->builder();
        $consulta = $builder->where('id', $id)
                            ->where('id_usuario', $usuario_id)
                            ->get()
                            ->getRow();
        
        if (!$consulta) {
            return redirect()->to('front/cliente/consultas')
                             ->with('error', 'Consulta no encontrada o no tienes permiso para eliminarla');
        }
        
        // Eliminar la consulta
        $this->consultaModel->delete($id);
        
        return redirect()->to('front/cliente/consultas')
                         ->with('mensaje', 'La consulta ha sido eliminada correctamente');
    }
}