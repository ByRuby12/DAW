<?php
require_once("funciones.php");

// Verificar si se ha enviado el formulario de registro
if (isset($_POST["registrarse"])) {
    // Obtener los datos del formulario
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];
    $rol = $_POST["rol"];

    // Llamar a la función para registrar usuario
    if (registrarUsuario($nombre, $apellido1, $apellido2, $correo, $usuario, $contrasena, $rol)) {
        echo '<script>alert("Los datos se han insertado correctamente.");</script>';
    }
}
?>

<!-- Sección de registro -->
<div class="login-section">
    <h2>Registro</h2>
    <!-- Formulario de registro -->
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido1" placeholder="Apellido Paterno" required>
        <input type="text" name="apellido2" placeholder="Apellido Materno" required>
        <input type="email" name="correo" placeholder="Correo Electrónico" required>
        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <select name="rol" required>
            <option value="alumno">Alumno</option>
        </select> <br>
        <input type="submit" id="registrarse" name="registrarse" value="Registrarse">
    </form>

    <!-- Formulario para redirigir a la página de inicio de sesión -->
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <input type="submit" id="iniciarsesion" name="iniciarsesion" value="Iniciar Sesión">
    </form>    
</div>
