<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <!-- CSS Reestructurado -->
    <link rel="stylesheet" href="<?= base_url('assets/css/base.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/layout.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/componentes.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/paginas.css') ?>">
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
    <!--iconos para login y carrito-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> 



    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600&display=swap" rel="stylesheet">
    
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
    <?php if ($cart->totalItems() > 0): ?>
    <a href="<?= base_url('carrito'); ?>" class="floating-cart">
        <div class="cart-icon">
            <i class="bi bi-cart-fill"></i>
            <span class="cart-count"><?= $cart->totalItems(); ?></span>
        </div>
    </a>
    <?php endif; ?>
</body>
</html>