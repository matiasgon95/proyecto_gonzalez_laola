<?= $this->extend('front/layout/layouts'); ?>

<?= $this->section('contenedor'); ?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card bg-dark text-info">
                <div class="card-body">
                    <h1 class="card-title"><?= $titulo ?></h1>
                    <p class="card-text">Aquí puedes ver todas tus consultas realizadas.</p>
                    <a href="<?= base_url('front/cliente/dashboard') ?>" class="btn btn-outline-info">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Panel
                    </a>
                    <a href="<?= base_url('front/cliente/nueva_consulta') ?>" class="btn btn-info ms-2">
                        <i class="fas fa-plus me-2"></i>Nueva Consulta
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <?php if (session()->getFlashdata('mensaje')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('mensaje') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-dark text-info">
                <div class="card-body">
                    <?php if (empty($consultas)) : ?>
                        <div class="alert alert-info text-center">
                            No tienes consultas realizadas. Puedes crear una nueva desde la sección de contacto.
                        </div>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-dark table-hover table-bordered text-info text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Asunto</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($consultas as $consulta) : ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= date('d/m/Y H:i', strtotime($consulta->fecha_creacion)) ?></td>
                                            <td class="text-center align-middle"><?= $consulta->asunto ?></td>
                                            <td class="text-center align-middle">
                                                <?php if ($consulta->estado == 'pendiente') : ?>
                                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                                <?php elseif ($consulta->estado == 'respondida') : ?>
                                                    <span class="badge bg-success">Respondida</span>
                                                <?php elseif ($consulta->estado == 'archivada') : ?>
                                                    <span class="badge bg-secondary">Archivada</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <button type="button" class="btn btn-sm btn-info ver-consulta" data-id="<?= $consulta->id ?>">
                                                    <i class="fas fa-eye"></i> Ver
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger eliminar-consulta" data-id="<?= $consulta->id ?>">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para ver detalle de consulta -->
<div class="modal fade" id="modalConsulta" tabindex="-1" aria-labelledby="modalConsultaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark text-info">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConsultaLabel">Detalle de Consulta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6 text-center">
                        <p><strong>Asunto:</strong> <span id="consulta-asunto"></span></p>
                    </div>
                    <div class="col-md-6 text-center">
                        <p><strong>Estado:</strong> <span id="consulta-estado"></span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <p class="text-center"><strong>Mensaje:</strong></p>
                        <div class="p-3 bg-dark border border-info rounded" id="consulta-mensaje"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mx-auto text-center">
                        <p><strong>Fecha de creación:</strong> <span id="consulta-fecha"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de consulta -->
<div class="modal fade" id="modalConfirmarEliminar" tabindex="-1" aria-labelledby="modalConfirmarEliminarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-info">
            <div class="modal-header">
                <h5 class="modal-title" id="modalConfirmarEliminarLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>¿Estás seguro de que deseas eliminar esta consulta?</p>
                <p class="text-danger">Esta acción no se puede deshacer.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="btn-confirmar-eliminar" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<!-- Incluir el script específico para consultas -->
<script src="<?= base_url('assets/js/consultas-cliente.js') ?>"></script>

<?= $this->endSection(); ?>