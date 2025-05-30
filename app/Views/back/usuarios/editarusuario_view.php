<h2>Editar Usuario</h2>
<form method="post" action="<?= site_url('UsuarioController/actualizar/' . $usuario->id) ?>">
    <input type="text" name="nombre" value="<?= $usuario->nombre ?>" placeholder="Nombre"><br>
    <input type="text" name="apellido" value="<?= $usuario->apellido ?>" placeholder="Apellido"><br>
    <input type="email" name="email" value="<?= $usuario->email ?>" placeholder="Email"><br>
    <input type="text" name="usuario" value="<?= $usuario->usuario ?>" placeholder="Usuario"><br>
    <input type="password" name="pass" placeholder="Contraseña (dejar en blanco si no cambia)"><br>
    <input type="number" name="perfil_id" value="<?= $usuario->perfil_id ?>" placeholder="Perfil ID"><br>
    <input type="text" name="baja" value="<?= $usuario->baja ?>" placeholder="Baja (si/no)"><br>
    <input type="submit" value="Actualizar">
</form>
