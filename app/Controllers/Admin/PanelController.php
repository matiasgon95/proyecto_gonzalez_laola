<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class PanelController extends BaseController
{
    public function cliente()
    {
        return view('front/cliente/dashboard', [
            'titulo' => 'Panel de Cliente'
        ]);
    }

    public function admin()
    {
        return view('back/dashboard', [
            'titulo' => 'Panel de Administración'
        ]);
    }

    public function estadisticas()
    {
        // Cargar los modelos necesarios
        $usuarioModel = new \App\Models\usuario_model();
        $productoModel = new \App\Models\ProductoModel();
        $categoriaModel = new \App\Models\CategoriaModel();
        $ventasCabeceraModel = new \App\Models\Ventas_cabecera_model();
        $ventasDetalleModel = new \App\Models\Ventas_detalle_model();
        
        // Estadísticas generales
        $data['total_usuarios'] = count($usuarioModel->findAll());
        $data['total_clientes'] = count($usuarioModel->obtener_clientes());
        $data['total_productos'] = count($productoModel->findAll());
        $data['total_categorias'] = count($categoriaModel->findAll());
        
        // Pedidos y ventas
        $pedidos = $ventasCabeceraModel->findAll();
        $data['total_pedidos'] = count($pedidos);
        
        // Calcular total de ventas
        $total_ventas = 0;
        foreach ($pedidos as $pedido) {
            $total_ventas += $pedido['total_venta'];
        }
        $data['total_ventas'] = $total_ventas;
        
        // Pedidos y ventas del mes actual
        $mes_actual = date('m');
        $año_actual = date('Y');
        $pedidos_mes = 0;
        $ventas_mes = 0;
        
        foreach ($pedidos as $pedido) {
            $fecha_pedido = date_create($pedido['fecha']);
            $mes_pedido = date_format($fecha_pedido, 'm');
            $año_pedido = date_format($fecha_pedido, 'Y');
            
            if ($mes_pedido == $mes_actual && $año_pedido == $año_actual) {
                $pedidos_mes++;
                $ventas_mes += $pedido['total_venta'];
            }
        }
        
        $data['pedidos_mes'] = $pedidos_mes;
        $data['ventas_mes'] = $ventas_mes;
        
        // Datos para gráfico de ventas por mes
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $datos_ventas = array_fill(0, 12, 0); // Inicializar con ceros
        
        foreach ($pedidos as $pedido) {
            $fecha_pedido = date_create($pedido['fecha']);
            $mes_pedido = (int)date_format($fecha_pedido, 'm') - 1; // Índice 0-11
            $año_pedido = date_format($fecha_pedido, 'Y');
            
            if ($año_pedido == $año_actual) {
                $datos_ventas[$mes_pedido] += $pedido['total_venta'];
            }
        }
        
        $data['meses'] = $meses;
        $data['datos_ventas'] = $datos_ventas;
        
        // Productos más vendidos
        $db = \Config\Database::connect();
        $query = $db->query(
            "SELECT p.nombre, SUM(vd.cantidad) as cantidad 
             FROM ventas_detalle vd 
             JOIN productos p ON p.id = vd.producto_id 
             GROUP BY vd.producto_id 
             ORDER BY cantidad DESC 
             LIMIT 5"
        );
        $data['productos_top'] = $query->getResultArray();
        
        // Productos por categoría
        $query = $db->query(
            "SELECT c.descripcion, COUNT(p.id) as total 
             FROM productos p 
             JOIN categorias c ON c.id = p.categoria_id 
             WHERE p.eliminado = 0 
             GROUP BY p.categoria_id"
        );
        $result = $query->getResultArray();
        
        $categorias = [];
        $productos_por_categoria = [];
        
        foreach ($result as $row) {
            $categorias[] = $row['descripcion'];
            $productos_por_categoria[] = $row['total'];
        }
        
        $data['categorias'] = $categorias;
        $data['productos_por_categoria'] = $productos_por_categoria;
        
        // Productos con stock bajo
        $data['productos_stock_bajo'] = $productoModel->where('stock <=', 'stock_min', false)
                                                     ->where('eliminado', 0)
                                                     ->orderBy('stock', 'ASC')
                                                     ->findAll(10);
        
        // Añadir título a los datos
        $data['titulo'] = 'Estadísticas';
        
        return view('back/estadisticas', $data);
    }
}