<form method="post" action="<?= site_url('usuario_controller/guardar') ?>">
    <input type="text" name="nombre" placeholder="Nombre"><br>
    <input type="text" name="apellido" placeholder="Apellido"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="text" name="usuario" placeholder="Usuario"><br>
    <input type="password" name="pass" placeholder="Contraseña"><br>
    <input type="number" name="perfil_id" placeholder="Perfil ID"><br>
    <input type="text" name="baja" placeholder="Baja (si/no)"><br>
    <input type="submit" value="Guardar">
</form>
