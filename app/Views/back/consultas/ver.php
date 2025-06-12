<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card bg-dark border-info mb-4">
                    <div class="card-header bg-info text-dark d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Consulta #<?= $consulta->id ?></h4>
                        <span class="badge <?= $consulta->estado == 'pendiente' ? 'bg-warning text-dark' : ($consulta->estado == 'respondida' ? 'bg-success' : 'bg-secondary') ?>">
                            <?= ucfirst($consulta->estado) ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> <?= $consulta->nombre ?> <?= $consulta->apellido ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Email:</strong> <?= $consulta->email ?></p>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($consulta->fecha_creacion)) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Asunto:</strong> <?= $consulta->asunto ?></p>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h5>Mensaje:</h5>
                            <div class="p-3 bg-dark border border-info rounded">
                                <?= nl2br($consulta->mensaje) ?>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('back/consultas') ?>" class="btn btn-outline-info">
                                <i class="fas fa-arrow-left me-2"></i>Volver a la lista
                            </a>
                            
                            <div class="btn-group">
                                <?php if ($consulta->estado != 'respondida'): ?>
                                    <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/respondida') ?>" class="btn btn-success">
                                        <i class="fas fa-check me-2"></i>Marcar como respondida
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($consulta->estado != 'archivada'): ?>
                                    <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/archivada') ?>" class="btn btn-secondary">
                                        <i class="fas fa-archive me-2"></i>Archivar
                                    </a>
                                <?php endif; ?>
                                
                                <a href="<?= base_url('back/consultas/eliminar/' . $consulta->id) ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta consulta?')">
                                    <i class="fas fa-trash-alt me-2"></i>Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>