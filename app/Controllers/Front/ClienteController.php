<?php

namespace App\Controllers\Front;

use App\Models\usuario_model;
use App\Models\Ventas_cabecera_model;
use App\Models\Ventas_detalle_model;
use App\Models\FavoritoModel;
use App\Models\ProductoModel;
use App\Models\ConsultaModel; // Agregar esta línea
use App\Controllers\BaseController;

/**
 * ClienteController - Gestiona las funcionalidades del área de cliente
 * 
 * Este controlador maneja todas las operaciones relacionadas con el perfil del cliente,
 * pedidos, favoritos, consultas y actualización de datos personales.
 */
class ClienteController extends BaseController
{
    /**
     * @var usuario_model Modelo para operaciones con usuarios
     */
    protected $usuarioModel;
    
    /**
     * @var Ventas_cabecera_model Modelo para operaciones con cabeceras de ventas
     */
    protected $ventasCabeceraModel;
    
    /**
     * @var Ventas_detalle_model Modelo para operaciones con detalles de ventas
     */
    protected $ventasDetalleModel;
    
    /**
     * @var FavoritoModel Modelo para operaciones con favoritos
     */
    protected $favoritoModel;
    
    /**
     * @var ProductoModel Modelo para operaciones con productos
     */
    protected $productoModel;
    
    /**
     * @var ConsultaModel Modelo para operaciones con consultas
     */
    protected $consultaModel;
    
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
     * Inicializa los modelos y la sesión necesarios para el funcionamiento
     */
    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
        $this->ventasCabeceraModel = new Ventas_cabecera_model();
        $this->ventasDetalleModel = new Ventas_detalle_model();
        $this->favoritoModel = new FavoritoModel();
        $this->productoModel = new ProductoModel();
        $this->consultaModel = new ConsultaModel();
        $this->session = session();
    }
    
    /**
     * Muestra la página de perfil del cliente
     * 
     * Obtiene y muestra los datos personales del usuario logueado
     * 
     * @return string Vista del perfil del cliente
     */
    public function perfil()
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Obtener los datos del usuario
        $data['usuario'] = $this->usuarioModel->obtener_usuario_por_id($usuario_id);
        $data['titulo'] = 'Mi Perfil';
        
        return view('front/cliente/perfil', $data);
    }

    /**
     * Muestra la lista de pedidos del cliente
     * 
     * Obtiene y muestra todos los pedidos realizados por el usuario logueado
     * 
     * @return string Vista de pedidos del cliente
     */
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
    
    /**
     * Muestra el detalle de un pedido específico
     * 
     * Obtiene y muestra la información detallada de un pedido, verificando
     * que pertenezca al usuario logueado
     * 
     * @param int $id ID del pedido a mostrar
     * @return \CodeIgniter\HTTP\RedirectResponse|string Vista del detalle o redirección
     */
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
    
    /**
     * Muestra los productos favoritos del cliente
     * 
     * Obtiene y muestra todos los productos marcados como favoritos
     * por el usuario logueado
     * 
     * @return string Vista de favoritos del cliente
     */
    public function favoritos()
    {
        // Obtener el ID del usuario de la sesión
        $usuario_id = session()->get('usuario_id');
        
        // Obtener todos los favoritos del usuario
        $favoritos = $this->favoritoModel->getFavoritos($usuario_id);
        
        $data['favoritos'] = $favoritos;
        return view('front/cliente/favoritos', $data);
    }
    
    /**
     * Agrega un producto a la lista de favoritos
     * 
     * Recibe el ID del producto por POST y lo agrega a favoritos
     * si el usuario está logueado
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de resultado
     */
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
    
    /**
     * Elimina un producto de la lista de favoritos
     * 
     * Recibe el ID del producto por URL y lo elimina de favoritos
     * si el usuario está logueado
     * 
     * @param int $producto_id ID del producto a eliminar de favoritos
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de resultado
     */
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
    
    /**
     * Verifica si un producto está en favoritos (para AJAX)
     * 
     * Recibe el ID del producto por URL y devuelve un JSON indicando
     * si está en favoritos del usuario logueado
     * 
     * @param int $producto_id ID del producto a verificar
     * @return \CodeIgniter\HTTP\Response Respuesta JSON con el resultado
     */
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

    /**
     * Actualiza los datos del perfil del cliente
     * 
     * Recibe los datos del formulario, valida y actualiza la información
     * del usuario en la base de datos
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de resultado
     */
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

    /**
     * Muestra las consultas realizadas por el cliente
     * 
     * Obtiene y muestra todas las consultas realizadas por el usuario logueado
     * ordenadas por fecha de creación descendente
     * 
     * @return string Vista de consultas del cliente
     */
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

    /**
     * Muestra el detalle de una consulta específica
     * 
     * Obtiene y devuelve en formato JSON la información de una consulta,
     * verificando que pertenezca al usuario logueado
     * 
     * @param int $id ID de la consulta a mostrar
     * @return \CodeIgniter\HTTP\Response|\CodeIgniter\HTTP\RedirectResponse Respuesta JSON o redirección
     */
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

    /**
     * Muestra el formulario para crear una nueva consulta
     * 
     * @return string Vista del formulario de nueva consulta
     */
    public function nueva_consulta()
    {
        $data['titulo'] = 'Nueva Consulta';
        return view('front/cliente/nueva_consulta', $data);
    }

    /**
     * Procesa el envío de una nueva consulta
     * 
     * Valida los datos del formulario y guarda la consulta en la base de datos
     * 
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de resultado
     */
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
            'estado' => 'pendiente',  // Estado inicial de la consulta
            'es_registrado' => 'si',  // El usuario está registrado
            'id_usuario' => $usuario_id  // ID del usuario logueado
        ];
        
        $this->consultaModel->insert($data);
        
        return redirect()->to('front/cliente/consultas')->with('mensaje', 'Tu consulta ha sido enviada correctamente. Te responderemos a la brevedad.');
    }

    /**
     * Elimina una consulta del cliente
     * 
     * Recibe el ID de la consulta por URL, verifica que pertenezca al usuario
     * logueado y la elimina de la base de datos
     * 
     * @param int $id ID de la consulta a eliminar
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de resultado
     */
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