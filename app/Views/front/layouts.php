<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/mi_estilo.css">
    <script src="assets/js/bootstrap.min.js"></script>

    <title><?= $titulo; ?></title>
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