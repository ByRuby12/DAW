<?php
// Incluir el archivo de funciones necesario
require_once("funciones.php");
?>

<!-- Encabezado de la página con el logo y un mensaje de bienvenida -->
<header id="header-cabezera">
    <!-- Mostrar el logo de Bibliotech -->
    <img src="./img/logo.png" alt="Logo de Bibliotech" class="logo-img">
    
    <!-- Contenedor para el mensaje de bienvenida -->
    <div class="header-text">
        <!-- Mensaje de bienvenida personalizado -->
        Bienvenido/a a la Aplicación de Bibliotech:
        <b>
            <?php 
            // Verificar si hay un usuario en la sesión
            if (isset($_SESSION['usuario'])) {
                // Obtener el usuario de la sesión
                $usuarioActual = $_SESSION['usuario']; 
                
                // Obtener los datos del perfil del usuario
                $datosPerfil = obtenerDatosPerfil($usuarioActual);

                // Mostrar el nombre de usuario o "Anonimo" si no se encuentran datos del perfil
                echo ($datosPerfil) ? $datosPerfil['usuario'] : "Anonimo";
            } 
            ?>
        </b>
    </div>
</header>
