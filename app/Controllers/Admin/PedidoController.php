<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Ventas_cabecera_model;
use App\Models\Ventas_detalle_model;
use App\Models\usuario_model;
use App\Models\ProductoModel;

class PedidoController extends BaseController
{
    protected $ventasCabeceraModel;
    protected $ventasDetalleModel;
    protected $usuarioModel;
    protected $productoModel;

    public function __construct()
    {
        $this->ventasCabeceraModel = new Ventas_cabecera_model();
        $this->ventasDetalleModel = new Ventas_detalle_model();
        $this->usuarioModel = new usuario_model();
        $this->productoModel = new ProductoModel();
    }

    // Mostrar listado de pedidos
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

    // Ver detalle de un pedido específico
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