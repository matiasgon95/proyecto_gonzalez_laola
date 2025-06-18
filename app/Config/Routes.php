<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 * 
 * Archivo de configuración de rutas para la aplicación
 * Organiza todas las URL accesibles y las mapea a controladores y métodos específicos
 */

// Página principal - Punto de entrada a la aplicación
$routes->get('/', 'Home::index');

// Rutas públicas (sin login) - Accesibles para todos los usuarios
$routes->get('productos', 'Front\Producto::index');
$routes->get('comercializacion', 'Home::comercializacion');
$routes->get('quienes_somos', 'Home::quienes_somos');
$routes->get('contacto', 'Front\ContactoController::index'); // Formulario de contacto
$routes->post('front/contacto/enviar', 'Front\ContactoController::enviar'); // Procesamiento del formulario
$routes->get('terminos', 'Home::terminos');
$routes->get('sitio_en_construccion', 'Home::sitio_en_construccion');

// Login y registro - Autenticación de usuarios
$routes->get('front/login', 'Front\LoginController::index');
$routes->post('LoginController/autenticar', 'Front\LoginController::autenticar');
$routes->get('LoginController/logout', 'Front\LoginController::logout');
$routes->get('front/registro_usuario', 'Front\RegistroController::index');
$routes->post('front/registro_usuario/guardar','Front\RegistroController::guardar');

// Rutas protegidas por perfil - Solo accesibles para clientes (perfil_id = 2)
$routes->group('front/cliente', ['filter' => 'auth:2'], function($routes) {
    // Dashboard y perfil del cliente
    $routes->get('dashboard', 'Admin\PanelController::cliente');
    $routes->get('perfil', 'Front\ClienteController::perfil');
    $routes->post('actualizar_perfil', 'Front\ClienteController::actualizar_perfil');
    
    // Gestión de pedidos del cliente
    $routes->get('pedidos', 'Front\ClienteController::pedidos');
    $routes->get('detalle_pedido/(:num)', 'Front\ClienteController::detalle_pedido/$1');
    
    // Gestión de favoritos
    $routes->get('favoritos', 'Front\ClienteController::favoritos');
    $routes->post('agregar_favorito', 'Front\ClienteController::agregar_favorito');
    $routes->get('eliminar_favorito/(:num)', 'Front\ClienteController::eliminar_favorito/$1');
    $routes->get('es_favorito/(:num)', 'Front\ClienteController::es_favorito/$1');
    
    // Gestión de consultas del cliente
    $routes->get('consultas', 'Front\ClienteController::consultas');
    $routes->get('detalle_consulta/(:num)', 'Front\ClienteController::detalle_consulta/$1');
    $routes->get('nueva_consulta', 'Front\ClienteController::nueva_consulta');
    $routes->post('guardar_consulta', 'Front\ClienteController::guardar_consulta');
    $routes->get('eliminar_consulta/(:num)', 'Front\ClienteController::eliminar_consulta/$1');
});

// Rutas de gestión de Productos del admin - Solo accesibles para administradores (perfil_id = 1)
$routes->group('back', ['filter' => 'auth:1'], function($routes) {
    // Dashboard de administración
    $routes->get('dashboard', 'Admin\PanelController::admin');
    
    // Gestión de productos (CRUD completo con papelera)
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
    
    // Gestión de pedidos (visualización y detalle)
    $routes->get('pedidos', 'Admin\PedidoController::index');
    $routes->get('pedidos/detalle/(:num)', 'Admin\PedidoController::detalle/$1');
    
    // Estadísticas del sistema
    $routes->get('estadisticas', 'Admin\PanelController::estadisticas');
    
    // Gestión de consultas (CRUD completo con filtros y acciones masivas)
    $routes->get('consultas', 'Admin\ConsultaController::index');
    $routes->get('consultas/registrados', 'Admin\ConsultaController::index/registrados'); // Filtro por usuarios registrados
    $routes->get('consultas/visitantes', 'Admin\ConsultaController::index/visitantes'); // Filtro por visitantes
    $routes->get('consultas/ver/(:num)', 'Admin\ConsultaController::ver/$1');
    $routes->get('consultas/getDetalleConsulta/(:num)', 'Admin\ConsultaController::getDetalleConsulta/$1'); // Para AJAX
    $routes->get('consultas/cambiarEstado/(:num)/(:alpha)', 'Admin\ConsultaController::cambiarEstado/$1/$2');
    $routes->get('consultas/eliminar/(:num)', 'Admin\ConsultaController::eliminar/$1');
    $routes->post('consultas/accionMasiva', 'Admin\ConsultaController::accionMasiva');
    
    // Gestión de consultas archivadas
    $routes->get('consultas/archivadas', 'Admin\ConsultaController::archivadas');
    $routes->get('consultas/archivadas/registrados', 'Admin\ConsultaController::archivadas/registrados');
    $routes->get('consultas/archivadas/visitantes', 'Admin\ConsultaController::archivadas/visitantes');
    $routes->post('consultas/accionMasivaArchivadas', 'Admin\ConsultaController::accionMasivaArchivadas');
});

// Rutas de productos - Catálogo público
$routes->get('producto/detalle/(:num)', 'Front\Producto::detalle/$1'); // Vista detallada de un producto
$routes->get('producto/categoria/(:any)', 'Front\Producto::categoria/$1'); // Filtro por categoría
$routes->get('producto/buscar', 'Front\Producto::buscar'); // Búsqueda de productos
$routes->get('producto/sugerencias', 'Front\Producto::sugerencias'); // Autocompletado para búsqueda

// Rutas del carrito de compras - Gestión de compras
$routes->get('carrito', 'Front\CarritoController::index'); // Vista del carrito
$routes->post('carrito_add', 'Front\CarritoController::add'); // Agregar producto al carrito
$routes->post('carrito_agrega', 'Front\CarritoController::add'); // Alias para compatibilidad
$routes->post('carrito_actualiza', 'Front\CarritoController::actualiza_carrito'); // Actualizar cantidades
$routes->get('carrito_suma/(:segment)', 'Front\CarritoController::suma/$1'); // Incrementar cantidad
$routes->get('carrito_resta/(:segment)', 'Front\CarritoController::resta/$1'); // Decrementar cantidad
$routes->get('carrito_elimina/(:segment)', 'Front\CarritoController::remove/$1'); // Eliminar producto
$routes->get('carrito_vaciar', 'Front\CarritoController::clear'); // Vaciar carrito
$routes->get('carrito_mini', 'Front\CarritoController::mini'); // Mini carrito para header
$routes->get('carrito/mini', 'Front\CarritoController::mini'); // Alias para compatibilidad
$routes->get('carrito_count', 'Front\CarritoController::count'); // Contador de productos
$routes->get('carrito/count', 'Front\CarritoController::count'); // Alias para compatibilidad

// Rutas de checkout - Proceso de compra
$routes->get('carrito_comprar', 'Front\CarritoController::comprar'); // Formulario de checkout
$routes->post('carrito_confirmar', 'Front\CarritoController::confirmar'); // Procesar compra
$routes->get('carrito/compra_exitosa', 'Front\CarritoController::compra_exitosa'); // Confirmación
$routes->get('carrito/generar_factura/(:num)', 'Front\CarritoController::generar_factura/$1'); // Factura

// Rutas de administración de usuarios - Solo accesibles para administradores
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Admin\PanelController::admin'); // Dashboard admin
    
    // Gestión de usuarios (CRUD completo con filtros por tipo)
    $routes->get('usuarios', 'Admin\UsuarioController::index'); // Todos los usuarios
    $routes->get('usuarios/clientes', 'Admin\UsuarioController::clientes'); // Solo clientes
    $routes->get('usuarios/administradores', 'Admin\UsuarioController::administradores'); // Solo admins
    $routes->get('usuarios/agregar/(:segment)', 'Admin\UsuarioController::agregar/$1'); // Agregar con tipo
    $routes->get('usuarios/agregar', 'Admin\UsuarioController::agregar'); // Agregar genérico
    $routes->post('usuarios/guardar', 'Admin\UsuarioController::guardar'); // Procesar creación
    $routes->get('usuarios/editar/(:num)', 'Admin\UsuarioController::editar/$1'); // Editar usuario
    $routes->post('usuarios/actualizar/(:num)', 'Admin\UsuarioController::actualizar/$1'); // Procesar edición
    $routes->get('usuarios/eliminar/(:num)', 'Admin\UsuarioController::eliminar/$1'); // Eliminar usuario
    $routes->get('usuarios/bloquear/(:num)', 'Admin\UsuarioController::bloquear/$1'); // Bloquear usuario
    $routes->get('usuarios/desbloquear/(:num)', 'Admin\UsuarioController::desbloquear/$1'); // Desbloquear
});