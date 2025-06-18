<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Ventas_cabecera_model;
use App\Models\Ventas_detalle_model;
use App\Models\usuario_model;
use App\Models\ProductoModel;

/**
 * PedidoController
 * 
 * Controlador para la gestión de pedidos en el panel de administración
 * Permite visualizar y gestionar los pedidos realizados por los usuarios
 */
class PedidoController extends BaseController
{
    /**
     * @var Ventas_cabecera_model Modelo para operaciones con cabeceras de ventas
     */
    protected $ventasCabeceraModel;
    
    /**
     * @var Ventas_detalle_model Modelo para operaciones con detalles de ventas
     */
    protected $ventasDetalleModel;
    
    /**
     * @var usuario_model Modelo para operaciones con usuarios
     */
    protected $usuarioModel;
    
    /**
     * @var ProductoModel Modelo para operaciones con productos
     */
    protected $productoModel;

    /**
     * Constructor
     * 
     * Inicializa los modelos necesarios para las operaciones del controlador
     */
    public function __construct()
    {
        $this->ventasCabeceraModel = new Ventas_cabecera_model();
        $this->ventasDetalleModel = new Ventas_detalle_model();
        $this->usuarioModel = new usuario_model();
        $this->productoModel = new ProductoModel();
    }

    /**
     * Muestra el listado de todos los pedidos
     * 
     * Obtiene todos los pedidos con información del usuario asociado
     * y los muestra ordenados por fecha descendente
     * 
     * @return mixed Vista con la lista de pedidos
     */
    public function index()
    {
        // Obtener todos los pedidos con información del usuario
        $pedidos = $this->ventasCabeceraModel
            ->select('ventas_cabecera.*, usuarios.nombre, usuarios.apellido, usuarios.email')
            ->join('usuarios', 'usuarios.id = ventas_cabecera.usuario_id', 'left')
            ->orderBy('ventas_cabecera.fecha', 'DESC')
            ->findAll();

        $data['pedidos'] = $pedidos;
        return view('back/pedidos/index', $data);
    }

    /**
     * Muestra el detalle de un pedido específico
     * 
     * Obtiene la información de la cabecera del pedido junto con los datos del usuario
     * y los detalles de los productos incluidos en el pedido
     * 
     * @param int $id ID del pedido a mostrar
     * @return mixed Vista con el detalle del pedido o redirección si no existe
     */
    public function detalle($id)
    {
        // Obtener información de la cabecera del pedido
        $pedido = $this->ventasCabeceraModel
            ->select('ventas_cabecera.*, usuarios.nombre, usuarios.apellido, usuarios.email, usuarios.provincia')
            ->join('usuarios', 'usuarios.id = ventas_cabecera.usuario_id', 'left')
            ->where('ventas_cabecera.id', $id)
            ->first();

        if (!$pedido) {
            return redirect()->to('back/pedidos')->with('mensaje', 'Pedido no encontrado');
        }

        // Obtener detalles del pedido
        $detalles = $this->ventasDetalleModel->getDetalles($id);

        $data['pedido'] = $pedido;
        $data['detalles'] = $detalles;
        return view('back/pedidos/detalle', $data);
    }
}