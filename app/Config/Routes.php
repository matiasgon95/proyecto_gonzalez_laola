<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Página principal (ventana principal)
// Página principal (ventana principal)
$routes->get('/', 'Home::index');

// Rutas adicionales
$routes->get('productos', 'Front\Producto::index'); // Página de inicio que muestra el catálogo de productos
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('quienes_somos', 'Home::quienes_somos');
$routes->get('contacto', 'Home::contacto');

// Rutas para productos (deberían ir después de las rutas estáticas)
$routes->get('producto/detalle/(:num)', 'Front\Producto::detalle/$1');  // Detalle de un producto, pasando el ID como parámetro
$routes->get('producto/categoria/(:any)', 'Front\Producto::categoria/$1');  // Ver productos por categoría
