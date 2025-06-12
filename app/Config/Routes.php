<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Página principal
$routes->get('/', 'Home::index');

// Rutas públicas (sin login)
$routes->get('productos', 'Front\Producto::index');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('quienes_somos', 'Home::quienes_somos');
$routes->get('contacto', 'Home::contacto');
$routes->get('terminos', 'Home::terminos');
$routes->get('sitio_en_construccion', 'Home::sitio_en_construccion');

// Login y registro
$routes->get('front/login', 'Front\LoginController::index');
$routes->post('LoginController/autenticar', 'Front\LoginController::autenticar');
$routes->get('LoginController/logout', 'Front\LoginController::logout');
$routes->get('front/registro_usuario', 'Front\RegistroController::index');
$routes->post('front/registro_usuario/guardar','Front\RegistroController::guardar');

// Rutas protegidas por perfil
$routes->group('front/cliente', ['filter' => 'auth:2'], function($routes) {
    $routes->get('dashboard', 'Admin\PanelController::cliente');
    $routes->get('perfil', 'Front\ClienteController::perfil');
    $routes->post('actualizar_perfil', 'Front\ClienteController::actualizar_perfil');
    $routes->get('pedidos', 'Front\ClienteController::pedidos');
    $routes->get('detalle_pedido/(:num)', 'Front\ClienteController::detalle_pedido/$1');
    $routes->get('favoritos', 'Front\ClienteController::favoritos');
    $routes->post('agregar_favorito', 'Front\ClienteController::agregar_favorito');
    $routes->get('eliminar_favorito/(:num)', 'Front\ClienteController::eliminar_favorito/$1');
    $routes->get('es_favorito/(:num)', 'Front\ClienteController::es_favorito/$1');
});

// Rutas de gestión de Productos del admin
$routes->group('back', ['filter' => 'auth:1'], function($routes) {
    $routes->get('dashboard', 'Admin\PanelController::admin');
    $routes->get('productos/papelera', 'Admin\ProductoController::papelera');
    $routes->get('productos/restaurar/(:num)', 'Admin\ProductoController::restaurar/$1');
    $routes->get('productos/eliminar_definitivo/(:num)', 'Admin\ProductoController::eliminar_definitivo/$1');

    $routes->get('productos', 'Admin\ProductoController::index');
    $routes->get('productos/crear', 'Admin\ProductoController::crear');
    $routes->post('productos/guardar', 'Admin\ProductoController::guardar');
    $routes->get('productos/editar/(:num)', 'Admin\ProductoController::editar/$1');
    $routes->post('productos/actualizar/(:num)', 'Admin\ProductoController::actualizar/$1');
    $routes->get('productos/eliminar/(:num)', 'Admin\ProductoController::eliminar/$1');
    $routes->post('productos/guardar_categoria', 'Admin\ProductoController::guardarCategoria');
    
    // Nuevas rutas para pedidos
    $routes->get('pedidos', 'Admin\PedidoController::index');
    $routes->get('pedidos/detalle/(:num)', 'Admin\PedidoController::detalle/$1');
    
    // Ruta para estadísticas
    $routes->get('estadisticas', 'Admin\PanelController::estadisticas');
});

// Rutas de productos
$routes->get('producto/detalle/(:num)', 'Front\Producto::detalle/$1');
$routes->get('producto/categoria/(:any)', 'Front\Producto::categoria/$1');
$routes->get('producto/buscar', 'Front\Producto::buscar'); // Ruta para búsqueda
$routes->get('producto/sugerencias', 'Front\Producto::sugerencias'); // Nueva ruta para autocompletado

// Rutas del carrito de compras
// Rutas del carrito
$routes->get('carrito', 'Front\CarritoController::index');
$routes->post('carrito_add', 'Front\CarritoController::add');
$routes->post('carrito_agrega', 'Front\CarritoController::add'); // Nueva ruta para compatibilidad
$routes->post('carrito_actualiza', 'Front\CarritoController::actualiza_carrito');
$routes->get('carrito_suma/(:segment)', 'Front\CarritoController::suma/$1');
$routes->get('carrito_resta/(:segment)', 'Front\CarritoController::resta/$1');
$routes->get('carrito_elimina/(:segment)', 'Front\CarritoController::remove/$1');
$routes->get('carrito_vaciar', 'Front\CarritoController::clear');
$routes->get('carrito_mini', 'Front\CarritoController::mini');
$routes->get('carrito/mini', 'Front\CarritoController::mini'); // Nueva ruta para compatibilidad
$routes->get('carrito_count', 'Front\CarritoController::count');
$routes->get('carrito/count', 'Front\CarritoController::count'); // Nueva ruta para compatibilidad
$routes->get('carrito_comprar', 'Front\CarritoController::comprar');
$routes->post('carrito_confirmar', 'Front\CarritoController::confirmar');
$routes->get('carrito/compra_exitosa', 'Front\CarritoController::compra_exitosa'); // Nueva ruta para la vista de compra exitosa

// Rutas de checkout
$routes->get('carrito_comprar', 'Front\CarritoController::comprar');
$routes->post('carrito_confirmar', 'Front\CarritoController::confirmar');
$routes->get('carrito/generar_factura/(:num)', 'Front\CarritoController::generar_factura/$1');


// Rutas de administración de usuarios
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Admin\PanelController::admin');
    
    // Rutas de gestión de usuarios
    $routes->get('usuarios', 'Admin\UsuarioController::index');
    $routes->get('usuarios/clientes', 'Admin\UsuarioController::clientes');
    $routes->get('usuarios/administradores', 'Admin\UsuarioController::administradores');
    $routes->get('usuarios/agregar/(:segment)', 'Admin\UsuarioController::agregar/$1');
    $routes->get('usuarios/agregar', 'Admin\UsuarioController::agregar');
    $routes->post('usuarios/guardar', 'Admin\UsuarioController::guardar');
    $routes->get('usuarios/editar/(:num)', 'Admin\UsuarioController::editar/$1');
    $routes->post('usuarios/actualizar/(:num)', 'Admin\UsuarioController::actualizar/$1');
    $routes->get('usuarios/eliminar/(:num)', 'Admin\UsuarioController::eliminar/$1');
    $routes->get('usuarios/bloquear/(:num)', 'Admin\UsuarioController::bloquear/$1');
    $routes->get('usuarios/desbloquear/(:num)', 'Admin\UsuarioController::desbloquear/$1');
});