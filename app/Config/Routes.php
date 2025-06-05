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
});









// Rutas de productos
$routes->get('producto/detalle/(:num)', 'Front\Producto::detalle/$1');
$routes->get('producto/categoria/(:any)', 'Front\Producto::categoria/$1');
