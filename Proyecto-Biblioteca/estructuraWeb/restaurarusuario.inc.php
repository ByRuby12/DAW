<?php
require_once("funciones.php");

// Verificar si el usuario tiene permisos de administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    // Obtener los usuarios eliminados
    $usuariosEliminados = obtenerTodosLosUsuariosEliminados();

    // Verificar si hay usuarios eliminados
    if ($usuariosEliminados) {
        echo '<div class="contenedor3">';
        echo '<table class="tabla-libros">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nombre</th>';
        echo '<th>Apellido 1</th>';
        echo '<th>Apellido 2</th>';
        echo '<th>Correo</th>';
        echo '<th>Usuario</th>';
        echo '<th>Rol</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';

        // Mostrar la información de los usuarios eliminados
        foreach ($usuariosEliminados as $usuarioEliminado) {
            echo '<tr>';
            echo '<td>' . $usuarioEliminado['id'] . '</td>';
            echo '<td>' . $usuarioEliminado['nombre'] . '</td>';
            echo '<td>' . $usuarioEliminado['apellido1'] . '</td>';
            echo '<td>' . $usuarioEliminado['apellido2'] . '</td>';
            echo '<td>' . $usuarioEliminado['correo'] . '</td>';
            echo '<td>' . $usuarioEliminado['usuario'] . '</td>';
            echo '<td>' . $usuarioEliminado['rol'] . '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id_usuario_restaurar" value="' . $usuarioEliminado['id'] . '">';
            echo '<input type="submit" name="restaurarUsuario" value="Restaurar">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    } else {
        // Mensaje si no hay usuarios eliminados
        echo '<div class="contenedor3">';
        echo '<table class="tabla-libros">';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Nombre</th>';
        echo '<th>Apellido 1</th>';
        echo '<th>Apellido 2</th>';
        echo '<th>Correo</th>';
        echo '<th>Usuario</th>';
        echo '<th>Rol</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
    }
} else {
    // Mensaje si el usuario no tiene permisos de administrador
    echo "No tienes permisos para acceder a esta página.";
}

// Verificar si se ha enviado el formulario de restaurar usuario
if (isset($_POST['restaurarUsuario'])) {
    // Obtener el ID del usuario a restaurar
    $idUsuarioRestaurar = $_POST['id_usuario_restaurar'];
    $usuarioRestaurar = obtenerUsuarioEliminadoPorID($idUsuarioRestaurar);

    // Verificar si se obtuvo el usuario eliminado
    if ($usuarioRestaurar) {
        // Llamar a la función para restaurar el usuario
        if (restaurarUsuario($usuarioRestaurar)) {
            echo '<script>alert("El usuario ha sido restaurado.");</script>';
            echo '<script>window.location.href = window.location.href;</script>';
        } else {
            echo "Error al restaurar el usuario.";
        }
    }
}
?>
