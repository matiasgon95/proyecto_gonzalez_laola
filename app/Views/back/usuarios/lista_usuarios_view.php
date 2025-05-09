<h2>Listado de Usuarios</h2>
<a href="<?= site_url('usuario_controller/agregar') ?>">Agregar nuevo usuario</a>
<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th><th>Nombre</th><th>Apellido</th><th>Email</th>
            <th>Usuario</th><th>Perfil ID</th><th>Baja</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
        <tr>
            <td><?= $usuario->id ?></td>
            <td><?= $usuario->nombre ?></td>
            <td><?= $usuario->apellido ?></td>
            <td><?= $usuario->email ?></td>
            <td><?= $usuario->usuario ?></td>
            <td><?= $usuario->perfil_id ?></td>
            <td><?= $usuario->baja ?></td>
            <td>
                <a href="<?= site_url('usuario_controller/editar/' . $usuario->id) ?>">Editar</a> |
                <a href="<?= site_url('usuario_controller/eliminar/' . $usuario->id) ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
