<!-- Barra de navegación adaptada -->
<nav class="navbar navbar-expand-lg mi-navbar">
  <div class="container-fluid d-flex flex-column p-0">
    
    <!-- Primera fila: Logo, Botón Toggler, Buscador e Iconos -->
    <div class="d-flex justify-content-between align-items-center w-100 p-2">
      
      <!-- Logo -->
      <a href="<?= base_url('/'); ?>" class="d-flex align-items-center">
        <img class="logo img-fluid" src="<?= base_url('assets/img/logo.png') ?>" alt="logo.png">
      </a>

      <!-- Botón hamburguesa (solo visible en pantallas chicas) -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Buscador (se oculta en mobile dentro del colapsable) -->
      <form class="buscador-nav mx-3 d-none d-lg-flex" style="flex: 0 0 40%;" action="<?= base_url('sitio_en_construccion'); ?>" method="get" onsubmit="return irASitio();">
  <div class="input-group">
    <input type="text" class="form-control form-control-sm" placeholder="Buscar productos..." name="q">
    <button class="btn btn-outline-info btn-sm" type="submit">Buscar</button>
  </div>
</form>

      <!-- Iconos usuario / carrito -->
      <div class="iconos-nav d-flex align-items-center gap-3">
        <a href="<?= base_url('sitio_en_construccion'); ?>" class="text-dark">
          <i class="bi bi-person-circle fs-4"></i>
        </a>
        <a href="<?= base_url('sitio_en_construccion'); ?>" class="text-dark">
          <i class="bi bi-cart3 fs-4"></i>
        </a>
      </div>


    </div>

    <!-- Segunda fila: Enlaces + Buscador (en responsive) -->
    <div class="collapse navbar-collapse justify-content-center w-100" id="navbarSupportedContent">
      
      <!-- Buscador visible solo en móviles -->
      <form class="buscador-nav w-100 my-2 d-lg-none" action="<?= base_url('sitio_en_construccion'); ?>" method="get" onsubmit="return irASitio();">
  <div class="input-group">
    <input type="text" class="form-control form-control-sm" placeholder="Buscar productos..." name="q">
    <button class="btn btn-outline-info btn-sm" type="submit">Buscar</button>
  </div>
</form>

      <!-- Menú de enlaces -->
      <ul class="navbar-nav mb-2 mb-lg-0 d-flex flex-column flex-lg-row gap-3 gap-lg-4">
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
<script>
function irASitio() {
  window.location.href = "<?= base_url('sitio_en_construccion'); ?>";
  return false; // Previene el envío real del formulario
}
</script>
