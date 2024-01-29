<?php
// Incluir el archivo de funciones necesario
require_once("funciones.php");

// Verificar si el usuario tiene permisos de administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    
    // Obtener todos los usuarios de la base de datos
    $usuarios = obtenerTodosLosUsuarios();

    // Verificar si se encontraron usuarios
    if ($usuarios) {
        // Mostrar una tabla con información de los usuarios
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

        // Iterar sobre cada usuario y mostrar sus detalles en la tabla
        foreach ($usuarios as $usuario) {
            echo '<tr>';
            echo '<td>' . $usuario['id'] . '</td>';
            echo '<td>' . $usuario['nombre'] . '</td>';
            echo '<td>' . $usuario['apellido1'] . '</td>';
            echo '<td>' . $usuario['apellido2'] . '</td>';
            echo '<td>' . $usuario['correo'] . '</td>';
            echo '<td>' . $usuario['usuario'] . '</td>';
            echo '<td>' . $usuario['rol'] . '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id_usuario" value="' . $usuario['id'] . '">';
            echo '<input type="submit" name="eliminarUsuario" value="Eliminar">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    } else {
        // Mostrar mensaje si no se encontraron usuarios en la base de datos
        echo "No se encontraron usuarios en la base de datos.";
    }
} else {
    // Mostrar mensaje si el usuario no tiene permisos de administrador
    echo "No tienes permisos para acceder a esta página.";
}

// Procesar el formulario de eliminar usuario si se ha enviado por POST
if (isset($_POST['eliminarUsuario'])) {
    // Obtener el ID del usuario a eliminar
    $idUsuarioEliminar = $_POST['id_usuario'];
    
    // Obtener la información del usuario a eliminar
    $usuarioEliminar = obtenerUsuarioPorID($idUsuarioEliminar);

    // Verificar si se encontró el usuario a eliminar
    if ($usuarioEliminar) {
        // Insertar el usuario en la tabla usuarioseliminados
        if (insertarUsuarioEliminado($usuarioEliminar)) {
            // Eliminar el usuario de la tabla usuarios
            if (eliminarUsuario($idUsuarioEliminar)) {
                // Mostrar mensaje de éxito y recargar la página
                echo '<script>alert("El usuario ha sido eliminado correctamente.");</script>';
                echo '<script>window.location.href = window.location.href;</script>';
            } else {
                // Mostrar mensaje de error si la eliminación del usuario falla
                echo "Error al eliminar el usuario.";
            }
        } else {
            // Mostrar mensaje de error si la inserción en usuarioseliminados falla
            echo "Error al insertar el usuario en la tabla usuarioseliminados.";
        }
    }
}
?>
