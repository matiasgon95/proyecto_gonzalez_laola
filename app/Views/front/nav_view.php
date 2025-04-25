<!-- Barra de navegación adaptada -->
<nav class="navbar navbar-expand-lg mi-navbar">
  <div class="container-fluid d-flex flex-column p-0">
    
    <!-- Primera fila: Logo, Buscador y Iconos -->
    <div class="d-flex justify-content-between align-items-center w-100 p-2">
      
      <!-- Logo -->
      <a href="<?= base_url('/'); ?>" class="d-flex align-items-center">
        <img class="logo img-fluid" src="<?= base_url('assets/img/logo.png') ?>" alt="logo.png">
      </a>

      <!-- Buscador -->
      <div class="buscador-nav mx-3" style="flex: 0 0 40%;">
        <input type="text" class="form-control form-control-sm" placeholder="Buscar productos...">
      </div>

      <!-- Iconos usuario / carrito -->
      <div class="iconos-nav d-flex align-items-center gap-3">
        <i class="bi bi-person-circle"></i>
        <i class="bi bi-cart3"></i>
      </div>

    </div>

    <!-- Segunda fila: Enlaces -->
    <div class="collapse navbar-collapse justify-content-center w-100" id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-lg-0 d-flex flex-row gap-4">
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
<!-- Fin barra de navegación adaptada -->
