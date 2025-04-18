<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/mi_estilo.css') ?>">
    <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>


    <!--Google Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Winky+Rough:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">
    
    <title>GL technology</title>
</head>
<body class="d-flex flex-column min-vh-100">
    
    
    <?php echo $this->include('front/nav_view');?>
    
    <div class="flex-fill">
        <?= $this->renderSection('contenedor'); ?>
    </div>

   <footer class="bg-dark text-white text-center py-3">
     <div>
       © 2025 González Matías - Laola Mariano. Todos los derechos reservados.
     </div>
    </footer>
</body>
</html>