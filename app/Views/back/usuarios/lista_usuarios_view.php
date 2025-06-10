<?= $this->extend('front/layout/layouts') ?>
<?= $this->section('contenedor') ?>

<div class="container py-5 bg-dark text-info">
    <div class="card bg-dark border-info mb-4">
        <div class="card-body">
            <h2 class="text-center mb-4">
                <?php if(isset($tipo) && $tipo == 'clientes'): ?>
                    Listado de Clientes
                <?php elseif(isset($tipo) && $tipo == 'administradores'): ?>
                    Listado de Administradores
                <?php else: ?>
                    Listado de Todos los Usuarios
                <?php endif; ?>
            </h2>
            
            <?php if(session()->getFlashdata('mensaje')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('mensaje') ?>
                </div>
            <?php endif; ?>
            
            <div class="mb-3 d-flex justify-content-between">
                <div>
                    <a href="<?= site_url('admin/usuarios') ?>" class="btn btn-info me-2">Todos</a>
                    <a href="<?= site_url('admin/usuarios/clientes') ?>" class="btn btn-info me-2">Clientes</a>
                    <a href="<?= site_url('admin/usuarios/administradores') ?>" class="btn btn-info">Administradores</a>
                </div>
                <div>
                    <a href="<?= site_url('admin/usuarios/agregar/admin') ?>" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Nuevo Administrador
                    </a>
                </div>
            </div>
            <div class="d-block d-md-none alert alert-info py-2 mb-2 text-center small">
                <i class="fas fa-arrows-left-right me-1"></i> Desliza horizontalmente para ver toda la tabla
            </div>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead class="table-info">
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Apellido</th>
                            <th class="text-center">Email</th>
                            <!-- Eliminar la columna Usuario -->
                            <th class="text-center">Perfil</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($usuarios)): ?>
                            <tr>
                                <td colspan="7" class="text-center">No hay usuarios registrados</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td class="text-center"><?= $usuario->id ?></td>
                                <td class="text-center"><?= $usuario->nombre ?></td>
                                <td class="text-center"><?= $usuario->apellido ?></td>
                                <td class="text-center"><?= $usuario->email ?></td>
                                <!-- Eliminar la columna que muestra $usuario->usuario -->
                                <td class="text-center">
                                    <?php if($usuario->perfil_id == 1): ?>
                                        <span class="badge bg-danger">Administrador</span>
                                    <?php else: ?>
                                        <span class="badge bg-info">Cliente</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($usuario->baja == 'si'): ?>
                                        <span class="badge bg-danger">Bloqueado</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="<?= site_url('admin/usuarios/editar/' . $usuario->id) ?>" class="btn btn-warning btn-sm me-2" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <?php if($usuario->baja == 'si'): ?>
                                            <a href="<?= site_url('admin/usuarios/desbloquear/' . $usuario->id) ?>" class="btn btn-success btn-sm me-2" title="Desbloquear">
                                                <i class="fas fa-unlock"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= site_url('admin/usuarios/bloquear/' . $usuario->id) ?>" class="btn btn-secondary btn-sm me-2" title="Bloquear">
                                                <i class="fas fa-lock"></i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <a href="<?= site_url('admin/usuarios/eliminar/' . $usuario->id) ?>" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<td><?= $usuario->email ?></td>
