<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>

<!-- Mostrar mensaje Flash si existe -->
<?php if (session()->getFlashdata('mensaje')): ?>
    <?php $tipo = session()->getFlashdata('tipo_mensaje') ?? 'info'; ?>
    <div class="alert alert-<?= $tipo ?> alert-dismissible fade show mt-3 mx-3 fw-bold" role="alert">
        <i class="fas fa-info-circle me-2"></i><?= session()->getFlashdata('mensaje') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>

<!-- carrousel -->
<div class="carousel-container">
  <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="<?= base_url('assets/img/procesadorInteli9.jpg') ?>" class="d-block w-100" alt="Imagen promocional 1">
        <div class="carousel-caption d-block">
          <a href="<?= base_url('producto/categoria/Procesadores') ?>" class="btn btn-info btn-lg">Ver productos</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="<?= base_url('assets/img/placabaseb550.jpg') ?>" class="d-block w-100" alt="Imagen promocional 2">
        <div class="carousel-caption d-block">
          <a href="<?= base_url('producto/categoria/Placas%20Base') ?>" class="btn btn-info btn-lg">Ver productos</a>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </div>
</div>
<!-- fin carrousel -->

<!-- Presentación de la empresa -->
<section class="container my-5 text-center">
  <h2 class="mb-4">Bienvenido a GL Technology</h2>
  <p class="lead">
    Somos una tienda especializada en la venta de componentes y hardware para computadoras. Nuestro objetivo es brindarte productos de calidad con atención personalizada.
  </p>
</section>

<!-- Introducción a productos -->
<section class="container my-5">
  <div class="row text-center">
    <div class="col-md-4 mb-4">
      <img src="<?= base_url('assets/img/ProcesadorRyzen5_3600.jpg') ?>" class="img-fluid card-img-top" alt="Procesadores">
      <h4 class="mt-3">Procesadores</h4>
      <p>Potenciá tu PC con lo último en tecnología de procesamiento. Trabajamos con Intel y AMD.</p>
    </div>
    <div class="col-md-4 mb-4">
      <img src="<?= base_url('assets/img/MemoriaRamAsusTuf3200.jpg') ?>" class="img-fluid card-img-top" alt="Memorias RAM">
      <h4 class="mt-3">Memorias RAM</h4>
      <p>Ampliá la memoria de tu equipo con módulos DDR4 y DDR5 de las mejores marcas.</p>
    </div>
    <div class="col-md-4 mb-4">
      <img src="<?= base_url('assets/img/motherbord b450.jpg') ?>" class="img-fluid card-img-top" alt="Placas Base">
      <h4 class="mt-3">Placas Base</h4>
      <p>Encontrá la placa base ideal para tu configuración, con soporte para los últimos estándares.</p>
    </div>
  </div>
</section>

<?= $this->endSection(); ?>
