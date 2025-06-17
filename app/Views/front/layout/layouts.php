<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap - Framework CSS principal -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- CSS Reestructurado - Arquitectura modular de estilos -->
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>"><!-- Estilos base y reset -->
    <link rel="stylesheet" href="<?= base_url('assets/css/layout.css') ?>"><!-- Estructura y disposición -->
    <link rel="stylesheet" href="<?= base_url('assets/css/componentes.css') ?>"><!-- Componentes reutilizables -->
    <link rel="stylesheet" href="<?= base_url('assets/css/paginas.css') ?>"><!-- Estilos específicos por página -->
    <link rel="stylesheet" href="<?= base_url('assets/css/tablas.css') ?>"><!-- Estilos para tablas -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!--iconos para login y carrito - Bootstrap Icons -->
    <link href="<?= base_url('assets/css/bootstrap-icons/font/bootstrap-icons.css') ?>" rel="stylesheet"> 
    <!-- Fuentes locales - Tipografías personalizadas -->
    <link rel="stylesheet" href="<?= base_url('assets/css/fonts.css') ?>">
    
    <!-- Variable global para la URL base - Utilizada por scripts JS para AJAX y rutas -->
    <script>
        var baseUrl = '<?= base_url() ?>';
    </script>
    
    <!-- JavaScript personalizado - Módulos funcionales -->
    <script src="<?= base_url('assets/js/cart.js') ?>"></script><!-- Gestión del carrito de compras -->
    <script src="<?= base_url('assets/js/notifications.js') ?>"></script><!-- Sistema de notificaciones -->
    <script src="<?= base_url('assets/js/ui.js') ?>"></script><!-- Interacciones de interfaz -->
    <script src="<?= base_url('assets/js/search.js') ?>"></script><!-- Funcionalidad de búsqueda -->
    <script src="<?= base_url('assets/js/checkout.js') ?>"></script><!-- Proceso de pago -->
    <script src="<?= base_url('assets/js/password-toggle.js') ?>"></script><!-- Mostrar/ocultar contraseña -->
    <script src="<?= base_url('assets/js/productos.js') ?>"></script><!-- Funcionalidades de productos -->
    
    <!--Titulo - Dinámico según la página actual-->
    <title><?= isset($titulo) ? $titulo . ' - GL technology' : 'GL technology' ?></title>
</head>
<body class="d-flex flex-column min-vh-100"><!-- Estructura flex para footer sticky -->
    
    <!--Seccion navbar - Barra de navegación principal-->
    <?php echo $this->include('front/layout/nav_view');?>
    
    <!--Seccion de posicionamiento de los contenedores - Contenido principal con flex-fill-->
    <div class="flex-fill">
        <?= $this->renderSection('contenedor'); ?><!-- Renderiza el contenido específico de cada vista -->
    </div>

    <!--Seccion del pie de página - Footer común para todas las páginas-->
    <?php echo $this->include('front/layout/footer_view');?>
    
    <!-- Icono flotante del carrito - Visible solo cuando hay productos -->
    <?php $cart = \Config\Services::cart(); ?><!-- Instancia del servicio de carrito -->
    <div class="floating-cart-container" <?= ($cart->totalItems() == 0) ? 'style="display: none;"' : '' ?>>
        <button type="button" class="floating-cart" id="openCartModal">
            <div class="cart-icon">
                <i class="bi bi-cart-fill"></i>
                <span class="cart-count"><?= $cart->totalItems(); ?></span><!-- Contador de productos -->
            </div>
        </button>
    </div>
    
    <!-- Botón para volver arriba - Mejora de usabilidad para páginas largas -->
    <button type="button" id="scrollTopBtn" class="scroll-top-btn" aria-label="Volver arriba">
        <i class="fas fa-arrow-up"></i>
    </button>
    
    <!-- Modal del Carrito - Ventana emergente con resumen del carrito -->
    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-content">
            <div class="cart-modal-header">
                <h5 class="cart-modal-title">Tu Carrito</h5>
                <button type="button" class="cart-close" id="closeCartModal">&times;</button>
            </div>
            <div class="cart-modal-body" id="cartModalBody">
                <!-- El contenido del carrito se cargará aquí mediante AJAX -->
                <div class="text-center p-4">
                    <div class="spinner-border text-info" role="status"><!-- Indicador de carga -->
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando tu carrito...</p>
                </div>
            </div>
            <div class="cart-modal-footer">
                <button type="button" class="btn btn-info btn-sm" id="continueShoppingBtn"><i class="fas fa-shopping-basket me-1"></i>Seguir comprando</button>
                <button type="button" class="btn btn-outline-danger btn-sm btn-cart-clear"><i class="fas fa-trash me-1"></i>Vaciar carrito</button>
                <button type="button" class="btn btn-info btn-sm btn-cart-checkout"><i class="fas fa-shopping-cart me-1"></i>Finalizar compra</button>
            </div>
        </div>
    </div>
    <!-- Script de favoritos cargado al final para no bloquear renderizado -->
    <script src="<?= base_url('assets/js/favoritos.js') ?>"></script>
</body>
</html>