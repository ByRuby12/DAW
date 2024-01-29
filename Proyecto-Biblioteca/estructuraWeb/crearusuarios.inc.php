<?php
// Incluir el archivo de funciones necesario
require_once("funciones.php");

// Verificar si el usuario tiene permisos de administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {

    // Procesar el formulario de creación de usuario si se ha enviado por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crearUsuario"])) {
        // Obtener datos del formulario
        $nombre = $_POST["nombre"];
        $apellido1 = $_POST["apellido1"];
        $apellido2 = $_POST["apellido2"];
        $correo = $_POST["correo"];
        $usuario = $_POST["usuario"];
        $contrasena = $_POST["contrasena"];
        $rol = $_POST["rol"];

        // Intentar crear un nuevo usuario
        if (crearUsuario($nombre, $apellido1, $apellido2, $correo, $usuario, $contrasena, $rol)) {
            // Mostrar mensaje de éxito y recargar la página
            echo '<script>alert("Usuario creado con éxito.");</script>';
            echo '<script>window.location.href = window.location.href;</script>';
        } else {
            // Mostrar mensaje de error si la creación falla
            echo "Error al crear el usuario.";
        }
    }
?>

<!-- Formulario para crear un nuevo usuario -->
<div class="contenedor-crearusuario">
    <h2>Crear Nuevo Usuario</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"] . "?ruta=crearusuarios"; ?>">
        <!-- Campos del formulario -->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>

        <label for="apellido1">Apellido 1:</label>
        <input type="text" id="apellido1" name="apellido1" required>

        <label for="apellido2">Apellido 2:</label>
        <input type="text" id="apellido2" name="apellido2" required>

        <label for="correo">Correo:</label>
        <input type="email" id="correo" name="correo" required>

        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>

        <label for="rol">Rol:</label>
        <select id="rol" name="rol" required>
            <option value="alumno">Alumno</option>
            <option value="admin">Admin</option>
        </select>

        <!-- Botón para enviar el formulario -->
        <input type="submit" name="crearUsuario" value="Crear Usuario">
    </form>
</div>

<?php
// Mostrar un mensaje si el usuario no tiene permisos de administrador
} else {
    echo "No tienes permisos para acceder a esta página.";
}
?>
