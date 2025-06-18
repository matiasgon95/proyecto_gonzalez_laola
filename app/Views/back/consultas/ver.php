<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<!-- Contenedor principal con fondo oscuro y texto en color info -->
<div class="container-fluid py-5 bg-dark text-info">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Tarjeta principal de la consulta -->
                <div class="card bg-dark border-info mb-4">
                    <!-- Encabezado de la tarjeta con número de consulta y estado -->
                    <div class="card-header bg-info text-dark d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Consulta #<?= $consulta->id ?></h4>
                        <!-- Badge dinámico que cambia de color según el estado -->
                        <span class="badge <?= $consulta->estado == 'pendiente' ? 'bg-warning text-dark' : ($consulta->estado == 'respondida' ? 'bg-success' : 'bg-secondary') ?>">
                            <?= ucfirst($consulta->estado) ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <!-- Información del remitente y detalles de la consulta -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Nombre:</strong> <?= $consulta->nombre ?> <?= $consulta->apellido ?></p>
                                <p><strong>Email:</strong> <?= $consulta->email ?></p>
                                <p><strong>Asunto:</strong> <?= $consulta->asunto ?></p>
                                <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($consulta->fecha_creacion)) ?></p>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <!-- Información adicional: estado y tipo de usuario -->
                                <p>
                                    <strong>Estado:</strong> 
                                    <span class="badge <?= $consulta->estado == 'pendiente' ? 'bg-warning text-dark' : ($consulta->estado == 'respondida' ? 'bg-success' : 'bg-secondary') ?>">
                                        <?= ucfirst($consulta->estado) ?>
                                    </span>
                                </p>
                                <p>
                                    <strong>Tipo de usuario:</strong> 
                                    <?php if ($consulta->es_registrado == 'si'): ?>
                                        <span class="badge bg-primary">Cliente Registrado</span>
                                    <?php else: ?>
                                        <span class="badge bg-info text-dark">Visitante</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        
                        <!-- Contenido del mensaje de la consulta -->
                        <div class="mb-4">
                            <h5>Mensaje:</h5>
                            <div class="p-3 bg-dark border border-info rounded">
                                <?= nl2br($consulta->mensaje) ?>
                            </div>
                        </div>
                        
                        <!-- Botones de acción para la consulta -->
                        <div class="d-flex justify-content-between">
                            <!-- Botón para volver a la lista de consultas -->
                            <a href="<?= base_url('back/consultas') ?>" class="btn btn-outline-info">
                                <i class="fas fa-arrow-left me-2"></i>Volver a la lista
                            </a>
                            
                            <!-- Grupo de botones para gestionar el estado de la consulta -->
                            <div class="btn-group">
                                <?php if ($consulta->estado != 'respondida'): ?>
                                    <!-- Botón para marcar como respondida (solo visible si no está respondida) -->
                                    <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/respondida') ?>" class="btn btn-success">
                                        <i class="fas fa-check me-2"></i>Marcar como respondida
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ($consulta->estado != 'archivada'): ?>
                                    <!-- Botón para archivar (solo visible si no está archivada) -->
                                    <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/archivada') ?>" class="btn btn-secondary">
                                        <i class="fas fa-archive me-2"></i>Archivar
                                    </a>
                                <?php endif; ?>
                                
                                <!-- Botón para eliminar la consulta con confirmación -->
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