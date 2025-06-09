<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- CSS Reestructurado -->
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/layout.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/componentes.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/paginas.css') ?>">
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!--iconos para login y carrito-->
    <link href="<?= base_url('assets/css/bootstrap-icons/font/bootstrap-icons.css') ?>" rel="stylesheet"> 
    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Variable global para la URL base -->
    <script>
        var baseUrl = '<?= base_url() ?>';
    </script>
    
    <!-- JavaScript personalizado -->
    <script src="<?= base_url('assets/js/cart.js') ?>"></script>
    <script src="<?= base_url('assets/js/notifications.js') ?>"></script>
    
    <!--Titulo-->
    <title>GL technology</title>
</head>
<body class="d-flex flex-column min-vh-100">
    
    <!--Seccion navbar-->
    <?php echo $this->include('front/layout/nav_view');?>
    
    <!--Seccion de posicionamiento de los contenedores-->
    <div class="flex-fill">
        <?= $this->renderSection('contenedor'); ?>
    </div>

    <!--Seccion del pie de página-->
    <?php echo $this->include('front/layout/footer_view');?>
    
    <!-- Icono flotante del carrito -->
    <?php $cart = \Config\Services::cart(); ?>
    <div class="floating-cart-container" <?= ($cart->totalItems() == 0) ? 'style="display: none;"' : '' ?>>
        <button type="button" class="floating-cart" id="openCartModal">
            <div class="cart-icon">
                <i class="bi bi-cart-fill"></i>
                <span class="cart-count"><?= $cart->totalItems(); ?></span>
            </div>
        </button>
    </div>
    
    <!-- Modal del Carrito -->
    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-content">
            <div class="cart-modal-header">
                <h5 class="cart-modal-title">Tu Carrito</h5>
                <button type="button" class="cart-close" id="closeCartModal">&times;</button>
            </div>
            <div class="cart-modal-body" id="cartModalBody">
                <!-- El contenido del carrito se cargará aquí mediante AJAX -->
                <div class="text-center p-4">
                    <div class="spinner-border text-info" role="status">
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
</body>
</html>