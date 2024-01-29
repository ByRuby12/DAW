<?php
require_once("funciones.php"); // Incluye las funciones necesarias
session_start();

// Verificar si se envió el formulario de inicio de sesión
if (isset($_POST["enviarLogin"])) {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    // Verificar las credenciales del usuario
    $rol = verificarInicioSesion($usuario, $password);

    if ($rol) {
        // Establecer las variables de sesión
        $_SESSION["usuario"] = $rol["usuario"];
        $_SESSION["rol"] = $rol["rol"];
        $_SESSION["id"] = $rol["id"];

        // Redirigir a la página principal
        header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=principal");
        exit;
    } else {
        $errValido = true;
    }
}

// Verificar si se envió el formulario de registro
if (isset($_POST["registrarse"])) {
    $nombre = $_POST["nombre"];
    $apellido1 = $_POST["apellido1"];
    $apellido2 = $_POST["apellido2"];
    $correo = $_POST["correo"];
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];
    $rol = $_POST["rol"];

    // Registrar al usuario
    if (registrarUsuario($nombre, $apellido1, $apellido2, $correo, $usuario, $contrasena, $rol)) {
        echo '<script>alert("Los datos se han insertado correctamente.");</script>';
    }
}

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION["usuario"]) && isset($_SESSION["rol"])) {
    $rol = $_SESSION["rol"];

    // Redirigir si el usuario intenta acceder a la ruta de administrador sin permisos
    if ($rol === "alumno" && isset($_GET["ruta"]) && $_GET["ruta"] === "admin") {
        header("Location: " . $_SERVER["PHP_SELF"] . "?ruta=principal");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bibliotech</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php include_once "estructuraWeb/cabezera.inc.php"; ?>
    <div class="container">

        <?php include_once "estructuraWeb/menu.inc.php"; ?>
        <?php 
        // Mostrar formularios de inicio de sesión o registro si no hay una ruta específica
        if (empty($_GET["ruta"]) || !isset($_SESSION["usuario"])) { 
            if (isset($_POST["registrar"])) {
                include_once "estructuraWeb/registrar.inc.php"; 
            } else {
                include_once "estructuraWeb/login.inc.php"; 
            }
        } else if (isset($_SESSION["usuario"])) {
            // Mostrar contenido específico según la ruta
            if (isset($_GET["ruta"]) && ($_GET["ruta"] == "principal")) {
                include_once "estructuraWeb/principal.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "perfil")) {
                include_once "estructuraWeb/perfil.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "logout")) {
                include_once "estructuraWeb/logout.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "contacto")) {
                include_once "estructuraWeb/contacto.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "libros")) {
                include_once "estructuraWeb/libros.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "prestamos")) {
                include_once "estructuraWeb/prestamos.inc.php"; 
            }


            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "usuarios")) {
                include_once "estructuraWeb/usuarios.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "crearusuarios")) {
                include_once "estructuraWeb/crearusuarios.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "editarlibros")) {
                include_once "estructuraWeb/editarlibros.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "crearlibros")) {
                include_once "estructuraWeb/crearlibros.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "editarprestamo")) {
                include_once "estructuraWeb/editarprestamo.inc.php"; 
            }


            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "eliminarusuario")) {
                include_once "estructuraWeb/eliminarusuario.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "eliminarlibro")) {
                include_once "estructuraWeb/eliminarlibro.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "restaurarlibro")) {
                include_once "estructuraWeb/restaurarlibro.inc.php"; 
            }
            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "restaurarusuario")) {
                include_once "estructuraWeb/restaurarusuario.inc.php"; 
            }

            else if (isset($_GET["ruta"]) && ($_GET["ruta"] == "buscador")) {
                include_once "estructuraWeb/buscador.inc.php"; 
            }
        }
    ?>
    </div>
        <?php include_once "estructuraWeb/pie.inc.php"; ?>
</body>
</html>