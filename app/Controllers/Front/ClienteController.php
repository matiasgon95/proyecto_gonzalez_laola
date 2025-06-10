<?php

namespace App\Controllers\Front;

use App\Models\usuario_model;
use App\Models\Ventas_cabecera_model;
use App\Models\Ventas_detalle_model;
use App\Models\FavoritoModel;
use App\Models\ProductoModel;
use App\Controllers\BaseController;

class ClienteController extends BaseController
{
    protected $usuarioModel;
    protected $ventasCabeceraModel;
    protected $ventasDetalleModel;
    protected $favoritoModel;
    protected $productoModel;
    protected $session;
    protected $helpers = ['url', 'form'];

    public function __construct()
    {
        $this->usuarioModel = new usuario_model();
        $this->ventasCabeceraModel = new Ventas_cabecera_model();
        $this->ventasDetalleModel = new Ventas_detalle_model();
        $this->favoritoModel = new FavoritoModel();
        $this->productoModel = new ProductoModel();
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
}