<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

class CarritoController extends BaseController
{
    protected $cart;
    protected $session;
    
    public function __construct()
    {
        helper(['form', 'url', 'cart']);
        $this->cart = \Config\Services::cart();
        $this->session = session();
    }
    
    public function index()
    {
        $data = [
            'titulo' => 'Carrito de Compras',
            'cart' => $this->cart->contents(),
            'total' => $this->cart->total()
        ];
        
        return view('front/carrito/index', $data);
    }
    
    public function add()
    {
        $this->cart = \Config\Services::cart();
        $request = \Config\Services::request();
        
        $productoModel = new \App\Models\ProductoModel();
        $producto = $productoModel->find($request->getPost('id'));
        $cantidad = $request->getPost('qty') ? (int)$request->getPost('qty') : 1;
        
        // Verificar si el producto ya está en el carrito
        $carrito_actual = $this->cart->contents();
        $cantidad_en_carrito = 0;
        
        foreach ($carrito_actual as $item) {
            if ($item['id'] == $request->getPost('id')) {
                $cantidad_en_carrito = $item['qty'];
                break;
            }
        }
        
        // Calcular la cantidad total (actual + nueva)
        $cantidad_total = $cantidad_en_carrito + $cantidad;
        
        $response = ['success' => false, 'message' => ''];
        
        // Validar stock considerando lo que ya está en el carrito
        if ($producto && $producto['stock'] >= $cantidad_total) {
            $this->cart->insert(array(
                'id'      => $request->getPost('id'),
                'qty'     => $cantidad,
                'price'   => $request->getPost('precio_vta'),
                'name'    => $request->getPost('nombre_prod'),
                'imagen'  => $request->getPost('imagen')
            ));
            
            // Añadir mensaje flash de confirmación
            $this->session->setFlashdata('mensaje', 'Producto agregado al carrito correctamente');
            $response['success'] = true;
            $response['message'] = 'Producto agregado al carrito correctamente';
        } else {
            // Mensaje de error si no hay suficiente stock
            $this->session->setFlashdata('mensaje', 'No hay suficiente stock disponible. Stock actual: ' . $producto['stock'] . ', En carrito: ' . $cantidad_en_carrito);
            $response['message'] = 'No hay suficiente stock disponible. Stock actual: ' . $producto['stock'] . ', En carrito: ' . $cantidad_en_carrito;
        }
        
        // Si es una solicitud AJAX, devolver JSON
        if ($request->isAJAX()) {
            return $this->response->setJSON($response);
        }
        
        // Si no es AJAX, redireccionar a la página anterior
        $referer = $request->getServer('HTTP_REFERER');
        if (!empty($referer)) {
            return redirect()->to($referer . '#producto-' . $request->getPost('id'));
        } else {
            // Si no hay referrer, redirigir a productos
            return redirect()->to(base_url('productos'));
        }
    }
    
    public function actualiza_carrito()
    {
        $this->cart = \Config\Services::cart();
        $request = \Config\Services::request();
        
        $cart = $request->getPost('cart');
        
        foreach ($cart as $key => $value) {
            $this->cart->update(array(
                'rowid' => $key,
                'qty'   => $value['qty']
            ));
        }
        
        return redirect()->to(base_url('carrito'));
    }
    
    public function suma($rowid)
    {
        $this->cart = \Config\Services::cart();
        
        // Obtener el item actual
        $item = $this->cart->getItem($rowid);
        
        // Verificar stock antes de incrementar
        $productoModel = new \App\Models\ProductoModel();
        $producto = $productoModel->find($item['id']);
        
        $success = false;
        $message = '';
        
        if ($producto && $producto['stock'] > $item['qty']) {
            // Incrementar la cantidad
            $this->cart->update(array(
                'rowid' => $rowid,
                'qty'   => $item['qty'] + 1
            ));
            $success = true;
        } else {
            // Mensaje de error si no hay suficiente stock
            $message = 'No se puede agregar más unidades. Stock máximo disponible: ' . $producto['stock'];
            $this->session->setFlashdata('mensaje', $message);
        }
        
        // Si es una solicitud AJAX, devolver JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => $success,
                'message' => $message
            ]);
        }
        
        return redirect()->to(base_url('carrito'));
    }
    
    public function resta($rowid)
    {
        $this->cart = \Config\Services::cart();
        
        // Obtener el item actual
        $item = $this->cart->getItem($rowid);
        
        // Decrementar la cantidad (mínimo 1)
        $qty = $item['qty'] - 1;
        if ($qty < 1) {
            $qty = 1;
        }
        
        $this->cart->update(array(
            'rowid' => $rowid,
            'qty'   => $qty
        ));
        
        // Si es una solicitud AJAX, devolver JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }
        
        return redirect()->to(base_url('carrito'));
    }
    
    public function remove($rowid)
    {
        $this->cart = \Config\Services::cart();
        
        $this->cart->remove($rowid);
        
        // Si es una solicitud AJAX, devolver JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true]);
        }
        
        return redirect()->to(base_url('carrito'));
    }
    
    public function clear()
    {
        $this->cart = \Config\Services::cart();
        $this->cart->destroy();
        
        return redirect()->to(base_url('carrito'));
    }
    
    public function mini()
    {
        $this->cart = \Config\Services::cart();
        $data = [
            'cart' => $this->cart->contents(),
            'total' => $this->cart->total()
        ];
        
        return view('front/carrito/mini', $data);
    }
    
    public function count()
    {
        $this->cart = \Config\Services::cart();
        return $this->response->setJSON([
            'count' => $this->cart->totalItems()
        ]);
    }
    
    public function comprar()
    {
        // Verificar si hay productos en el carrito
        $carrito_contents = $this->cart->contents();
        if (empty($carrito_contents)) {
            $this->session->setFlashdata('mensaje', 'No hay productos en el carrito para realizar la compra.');
            return redirect()->to(base_url('carrito'));
        }
        
        // Verificar si el usuario está logueado
        if (!session()->get('usuario_logueado')) {
            $this->session->setFlashdata('mensaje', 'Debe iniciar sesión para realizar la compra.');
            return redirect()->to(base_url('front/login'));
        }
        
        // Cargar los modelos necesarios
        $productoModel = new \App\Models\ProductoModel();
        
        // Validar stock y filtrar productos válidos
        $productos_validos = [];
        $productos_sin_stock = [];
        $subtotal = 0;
        
        foreach ($carrito_contents as $item) {
            $producto = $productoModel->find($item['id']);
            
            if ($producto && $producto['stock'] >= $item['qty']) {
                $productos_validos[] = $item;
                $subtotal += $item['subtotal'];
            } else {
                $productos_sin_stock[] = $item['name'];
            }
        }
        
        // Si hay productos sin stock suficiente, mostrar mensaje y volver al carrito
        if (!empty($productos_sin_stock)) {
            $mensaje = 'Los siguientes productos no tienen stock suficiente y fueron eliminados del carrito: ' . 
                       implode(', ', $productos_sin_stock);
            $this->session->setFlashdata('mensaje', $mensaje);
            return redirect()->to(base_url('carrito'));
        }
        
        // Si no hay productos válidos, no se registra la venta
        if (empty($productos_validos)) {
            $this->session->setFlashdata('mensaje', 'No hay productos válidos para registrar la venta.');
            return redirect()->to(base_url('carrito'));
        }
        
        // Cargar la vista de checkout
        $data = [
            'titulo' => 'Finalizar Compra',
            'cart' => $productos_validos,
            'subtotal' => $subtotal
        ];
        
        return view('front/carrito/checkout', $data);
    }
    
    public function confirmar()
    {
        // Verificar si hay productos en el carrito
        $carrito_contents = $this->cart->contents();
        if (empty($carrito_contents)) {
            $this->session->setFlashdata('mensaje', 'No hay productos en el carrito para realizar la compra.');
            return redirect()->to(base_url('carrito'));
        }
        
        // Verificar si el usuario está logueado
        if (!session()->get('usuario_id')) {  // Cambiado de id_usuario a usuario_id
            $this->session->setFlashdata('mensaje', 'Debe iniciar sesión para realizar la compra.');
            return redirect()->to(base_url('front/login'));
        }
        
        // Cargar los modelos necesarios
        $productoModel = new \App\Models\ProductoModel();
        $ventasModel = new \App\Models\Ventas_cabecera_model();
        $detalleModel = new \App\Models\Ventas_detalle_model();
        
        // Validar stock y filtrar productos válidos
        $productos_validos = [];
        $productos_sin_stock = [];
        $total = 0;
        
        foreach ($carrito_contents as $item) {
            $producto = $productoModel->find($item['id']);
            
            if ($producto && $producto['stock'] >= $item['qty']) {
                $productos_validos[] = $item;
                $total += $item['subtotal'];
            } else {
                $productos_sin_stock[] = $item['name'];
                $this->cart->remove($item['rowid']);
            }
        }
        
        // Si hay productos sin stock suficiente, mostrar mensaje y volver al carrito
        if (!empty($productos_sin_stock)) {
            $mensaje = 'Los siguientes productos no tienen stock suficiente y fueron eliminados del carrito: ' . 
                       implode(', ', $productos_sin_stock);
            $this->session->setFlashdata('mensaje', $mensaje);
            return redirect()->to(base_url('carrito'));
        }
        
        // Si no hay productos válidos, no se registra la venta
        if (empty($productos_validos)) {
            $this->session->setFlashdata('mensaje', 'No hay productos válidos para registrar la venta.');
            return redirect()->to(base_url('carrito'));
        }
        
        // Obtener datos del formulario
        $metodo_entrega = $this->request->getPost('metodo_entrega');
        $metodo_pago = $this->request->getPost('metodo_pago');
        $costo_envio = (float)$this->request->getPost('costo_envio');
        $total_final = (float)$this->request->getPost('total');
        
        // Datos adicionales para guardar
        $datos_adicionales = [
            'nombre' => $this->request->getPost('nombre'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
            'metodo_entrega' => $metodo_entrega,
            'metodo_pago' => $metodo_pago
        ];
        
        // Si es envío a domicilio, guardar dirección
        if ($metodo_entrega === 'envio_domicilio') {
            $datos_adicionales['direccion'] = $this->request->getPost('direccion');
            $datos_adicionales['ciudad'] = $this->request->getPost('ciudad');
            $datos_adicionales['codigo_postal'] = $this->request->getPost('codigo_postal');
        }
        
        // Registrar cabecera de la venta
        $nueva_venta = [
            'usuario_id' => $this->session->get('usuario_id'),
            'total_venta' => $total_final
            // Se elimina la línea de datos_adicionales
        ];
        $venta_id = $ventasModel->insert($nueva_venta);
        
        // Registrar detalle y actualizar stock
        foreach ($productos_validos as $item) {
            $detalle = [
                'venta_id' => $venta_id,
                'producto_id' => $item['id'],
                'cantidad' => $item['qty'],
                'precio' => $item['subtotal']
            ];
            $detalleModel->insert($detalle);
            
            $producto = $productoModel->find($item['id']);
            $productoModel->update($item['id'], ['stock' => $producto['stock'] - $item['qty']]);
        }
        
        // Vaciar carrito y mostrar confirmación
        $this->cart->destroy();
        
        // Mensaje más destacado
        $this->session->setFlashdata('mensaje', 'Compra realizada exitosamente. ¡Gracias por tu compra!');
        $this->session->setFlashdata('tipo_mensaje', 'success'); // Añadimos un tipo para el mensaje
        
        return redirect()->to(base_url('vista_compras/' . $venta_id));
    }
    
    public function ver_factura($venta_id)
    {
        //Verificar si el usuario está logueado
        if (!session()->get('usuario_id')) {  // Cambiado de id_usuario a usuario_id
            return redirect()->to(base_url('front/login'));
        }
        
        $detalle_ventas = new \App\Models\Ventas_detalle_model();
        $data['venta'] = $detalle_ventas->getDetalles($venta_id);
        
        // Verificar si se encontraron detalles
        if (empty($data['venta'])) {
            $this->session->setFlashdata('mensaje', 'No se encontraron detalles para esta compra.');
            $this->session->setFlashdata('tipo_mensaje', 'warning');
        }
        
        $data['titulo'] = "Mi compra";
        
        echo view('front/head_view_crud', $data);
        echo view('front/nav_view');
        echo view('back/compras/vista_compras', $data);
        echo view('front/footer_view');
    }
    
    public function ver_facturas_usuario($id_usuario)
    {
        $ventas = new \App\Models\Ventas_cabecera_model();
        
        $data['ventas'] = $ventas->getVentas($id_usuario);
        $data['titulo'] = "Todos mis compras";
        
        echo view('front/head_view_crud', $data);
        echo view('front/nav_view');
        echo view('back/compras/ver_factura_usuario', $data);
        echo view('front/footer_view');
    }
}