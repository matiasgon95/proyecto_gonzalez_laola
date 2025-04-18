<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mi_estilo.css') ?>">
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>



    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    
    <!--Titulo-->
    <title>GL technology</title>
</head>
<body class="d-flex flex-column min-vh-100">
    
    <!--Seccion navbar-->
    <?php echo $this->include('front/nav_view');?>
    
    <!--Seccion de posicionamiento de los contenedores-->
    <div class="flex-fill">
        <?= $this->renderSection('contenedor'); ?>
    </div>

    <!--Seccion del pie de página-->
   <footer class="bg-dark text-white text-center py-3">
     <div>
       © 2025 González Matías - Laola Mariano. Todos los derechos reservados.
       <br>
       <a href="<?= base_url('terminos')?>" class="text-white">Términos y Condiciones de Uso</a>
     </div>
    </footer>
</body>
</html>