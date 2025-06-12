<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container-fluid py-5 bg-dark text-info">
    <div class="container-fluid px-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card bg-dark border-info mb-4">
                    <div class="card-body text-info">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h1 class="display-5">Consultas Archivadas</h1>
                            <div>
                                <a href="<?= base_url('back/consultas') ?>" class="btn btn-info rounded-pill px-4 me-2">
                                    <i class="fas fa-inbox"></i> Ver Consultas Activas
                                </a>
                                <a href="<?= base_url('back/dashboard') ?>" class="btn btn-outline-info rounded-pill px-4">
                                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                                </a>
                            </div>
                        </div>
                        
                        <?php if (session()->has('mensaje')): ?>
                            <div class="alert alert-success">
                                <?= session('mensaje') ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (session()->has('error')): ?>
                            <div class="alert alert-danger">
                                <?= session('error') ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="table-responsive">
                            <table class="table table-dark table-hover table-bordered table-consultas">
                                <thead class="bg-info text-dark">
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Asunto</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($consultas)): ?>
                                        <tr>
                                            <td colspan="7" class="text-center">No hay consultas archivadas</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($consultas as $consulta): ?>
                                            <tr>
                                                <td class="text-center"><?= $consulta->id ?></td>
                                                <td><?= $consulta->nombre ?> <?= $consulta->apellido ?></td>
                                                <td><?= $consulta->email ?></td>
                                                <td><?= $consulta->asunto ?></td>
                                                <td class="text-center"><?= date('d/m/Y H:i', strtotime($consulta->fecha_creacion)) ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-secondary">Archivada</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a href="<?= base_url('back/consultas/ver/' . $consulta->id) ?>" class="btn btn-info btn-sm" title="Ver detalles">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('back/consultas/cambiarEstado/' . $consulta->id . '/pendiente') ?>" class="btn btn-warning btn-sm" title="Restaurar como pendiente">
                                                            <i class="fas fa-undo"></i>
                                                        </a>
                                                        <a href="<?= base_url('back/consultas/eliminar/' . $consulta->id) ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta consulta?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>