<!-- Barra de navegación elegante -->
<nav class="navbar navbar-expand-lg mi-navbar shadow-sm">
  <div class="container-fluid d-flex flex-column p-0">
    
    <!-- Primera fila: Logo, Botón Toggler, Buscador e Iconos -->
    <div class="d-flex justify-content-between align-items-center w-100 px-3 py-2">
      
      <!-- Logo con efecto hover -->
      <a href="<?= base_url('/'); ?>" class="d-flex align-items-center logo-container">
        <img class="logo img-fluid transition-scale" src="<?= base_url('assets/img/logo.png') ?>" alt="logo.png">
      </a>

      <!-- Botón hamburguesa estilizado -->
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Buscador (escritorio) -->
      <form class="buscador-nav mx-4 d-none d-lg-flex" style="flex: 0 0 40%;" action="<?= base_url('productos/buscar'); ?>" method="get">
        <div class="input-group">
          <input type="text" class="form-control form-control-sm" placeholder="Buscar productos..." name="q">
          <button class="btn btn-outline-info btn-sm" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>

      <!-- Iconos usuario / carrito -->
      <div class="iconos-nav">
        <div class="dropdown dropdown-hover">
          <a href="<?= base_url('front/login') ?>" class="nav-icon-link" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-4"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end nav-dropdown" aria-labelledby="userDropdown">
            <?php if(session()->get('usuario_logueado')): ?>
              <?php if(session()->get('perfil_id') == 1): ?>
                <li><a class="dropdown-item" href="<?= base_url('back/dashboard') ?>"><i class="bi bi-gear me-2"></i>Administrar</a></li>
              <?php elseif(session()->get('perfil_id') == 2): ?>
                <li><a class="dropdown-item" href="<?= base_url('front/cliente/dashboard') ?>"><i class="bi bi-person-gear me-2"></i>Mi Cuenta</a></li>
              <?php endif; ?>
              <li><a class="dropdown-item" href="<?= site_url('LoginController/logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
            <?php else: ?>
              <li><a class="dropdown-item" href="<?= base_url('front/login') ?>"><i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión</a></li>
              <li><a class="dropdown-item" href="<?= base_url('front/registro_usuario') ?>"><i class="bi bi-person-plus me-2"></i>Registrarse</a></li>
            <?php endif; ?>
          </ul>
        </div>
        <a href="#" class="nav-icon-link position-relative">
            <i class="bi bi-cart3 fs-4"></i>
            <?php $cart = \Config\Services::cart(); ?>
            <?php if ($cart->totalItems() > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $cart->totalItems(); ?>
                <span class="visually-hidden">productos en el carrito</span>
            </span>
            <?php endif; ?>
        </a>
      </div>
    </div>

    <!-- Segunda fila: Menú de enlaces y buscador móvil -->
    <div class="collapse navbar-collapse justify-content-center w-100" id="navbarSupportedContent">
      
      <!-- Buscador (móvil) -->
      <form class="buscador-nav w-100 my-3 px-3 d-lg-none" action="<?= base_url('productos/buscar'); ?>" method="get">
        <div class="input-group">
          <input type="text" class="form-control form-control-sm" placeholder="Buscar productos..." name="q">
          <button class="btn btn-outline-info btn-sm" type="submit">
            <i class="bi bi-search"></i>
          </button>
        </div>
      </form>

      <!-- Enlaces de navegación -->
      <ul class="navbar-nav mb-2 mb-lg-0 d-flex flex-column flex-lg-row gap-2 gap-lg-4 text-center">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/'); ?>">Inicio</a>
        </li>
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
