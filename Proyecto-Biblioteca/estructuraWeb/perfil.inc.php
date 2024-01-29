<?php

require_once("funciones.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se ha enviado el formulario de edición
    if (isset($_POST['nombre']) && isset($_POST['apellido1']) && isset($_POST['apellido2']) && isset($_POST['correo']) && isset($_POST['usuario'])) {
        $nombre = $_POST['nombre'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        $nuevaContrasena = $_POST['contrasena'];

        $usuarioActual = $_SESSION['usuario'];

        if (actualizarPerfil($usuarioActual, $nombre, $apellido1, $apellido2, $correo, $usuario, $nuevaContrasena)) {
        // Redireccionar al usuario a la página de inicio después de guardar los cambios
            header("Location: index.php");
        //eliminamos las variables de sesion 
            session_unset();
        //elimnamos la sesion
            session_destroy();
        //redireccionamos a index
            header("Location: ".$_SERVER["PHP_SELF"]);
            exit;
        } else {
            echo "Error al actualizar el perfil.";
        }
    }
}
?>

<div class="container2">
    <section class="perfil">
        <h2>Perfil de Usuario</h2>
        <?php

// Verifica si el usuario está autenticado
if (isset($_SESSION['usuario'])) {
    $usuarioActual = $_SESSION['usuario']; // Obtiene el usuario de la sesión
    $datosPerfil = obtenerDatosPerfil($usuarioActual);

    if ($datosPerfil) {
        // Muestra los datos del perfil
        echo "<h3>Nombre:</h3> <p>" . $datosPerfil['nombre'] . "</p>";
        echo "<h3>Primer Apellido: </h3> <p>" . $datosPerfil['apellido1'] . "</p>";
        echo "<h3>Segundo Apellido: </h3> <p>" . $datosPerfil['apellido2'] . "</p>";
        echo "<h3>Correo Electronico: </h3> <p>" . $datosPerfil['correo'] . "</p>";
        echo "<h3>Usuario:</h3> <p>" . $datosPerfil['usuario'] . "</p>";
        echo "<h3>Contraseña:</h3> <p>****** </p>"; 
    } else {
        echo "No se encontraron datos de perfil para el usuario actual.";
    }
} else {
    echo "El usuario no está autenticado. Por favor, inicie sesión para ver su perfil.";
}
?>
    <button class="logoutmenu"> <a href="<?php echo $_SERVER["PHP_SELF"]."?ruta=logout"; ?>"> Cerrar Sesión</button> </a>
        
</section>
<section class="editar">
            <h2>Editar Perfil</h2>
            <form action="" method="post">
                <label for="nombre">Nombre:</label> <br>
                <input type="text" id="nombre" name="nombre" value="" required> <br>
                <label for="apellido1">Apellido 1:</label> <br>
                <input type="text" id="apellido1" name="apellido1" value="" required> <br>
                <label for="apellido2">Apellido 2:</label> <br>
                <input type="text" id="apellido2" name="apellido2" value="" required> <br>
                <label for="correo">Correo:</label> <br>
                <input type="email" id="correo" name="correo" value="" required> <br>
                <label for="usuario">Usuario:</label> <br>
                <input type="text" id="usuario" name="usuario" value="" required> <br>
                <label for="contrasena">Nueva Contraseña:</label> <br>
                <input type="password" id="contrasena" name="contrasena" required><br>
                <button type="submit">Guardar Cambios</button>
            </form>
</section>
</div>