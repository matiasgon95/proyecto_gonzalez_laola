<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg mi-navbar">
  <div class="container-fluid">
    <!-- Logo -->
    <a href="<?= base_url('/'); ?>">
      <img class="logo img-fluid" src="<?= base_url('assets/img/logo.png') ?>" alt="logo.png">
    </a>

    <!-- Botón hamburguesa -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Enlaces colapsables -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('productos'); ?>">Productos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('comercializacion'); ?>">Comercialización</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('quienes_somos'); ?>">Quiénes somos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('contacto'); ?>">Contacto</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- Fin barra de navegación -->