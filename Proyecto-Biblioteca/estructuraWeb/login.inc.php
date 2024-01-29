<?php
// Incluir el archivo de funciones necesario
require_once("funciones.php");

// Verificar si se ha enviado el formulario de inicio de sesión (POST)
if (isset($_POST["enviarLogin"])) {
    // Obtener los datos del formulario
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Verificar el inicio de sesión y obtener el rol del usuario
    $rol = verificarInicioSesion($usuario, $password);

    // Si el inicio de sesión es exitoso, configurar las variables de sesión y redirigir a la página principal
    if ($rol) {
        $_SESSION["usuario"] = $usuario;
        $_SESSION["rol"] = $rol;

        header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=principal");
        exit;
    } else {
        // Si el inicio de sesión falla, establecer una variable de error válida
        $errValido = true;
    }
}
?>

<section class="login-section">
    <h2>Iniciar Sesión</h2>
    <?php if (isset($errValido) && $errValido == true) { ?>
        <!-- Mostrar un mensaje de error si la variable de error es válida -->
        <p class="error">Usuario o contraseña incorrecta</p>
    <?php } ?>
    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <?php if (isset($errUsuario) && $errUsuario == true) { ?>
            <!-- Mostrar un mensaje de error si la variable de error de usuario es válida -->
            <p class="error">Usuario incorrecto</p>
        <?php } ?>
        <!-- Campo de entrada para el usuario -->
        <label for="usuario">Escribe tu usuario</label>
        <input type="text" id="usuario" name="usuario" placeholder="Usuario" value="<?php if (isset($usuario)) echo $usuario; ?>">
        <?php if (isset($errPassword) && $errPassword == true) { ?>
            <!-- Mostrar un mensaje de error si la variable de error de contraseña es válida -->
            <p class="error">Contraseña incorrecta</p>
        <?php } ?>
        <!-- Campo de entrada para la contraseña -->
        <label for="password">Escribe una contraseña</label>
        <input type="password" id="password" name="password" placeholder="Contraseña">
        <!-- Botón para enviar el formulario de inicio de sesión -->
        <input type="submit" id="enviarLogin" name="enviarLogin" value="Enviar">
        <!-- Botón para redirigir a la página de registro -->
        <input type="submit" id="registrar" name="registrar" value="Registrarse">
    </form>
</section>
