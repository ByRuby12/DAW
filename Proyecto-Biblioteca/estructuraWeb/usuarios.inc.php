<?php
require_once("funciones.php");

// Verificar si el usuario tiene permisos de administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    // Obtener todos los usuarios
    $usuarios = obtenerTodosLosUsuarios();

    // Verificar si hay usuarios
    if ($usuarios) {
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

        // Mostrar la información de los usuarios
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
            echo '<input type="submit" name="modificarUsuario" value="Modificar">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    } else {
        // Mensaje si no hay usuarios
        echo "No se encontraron usuarios en la base de datos.";
    }
} else {
    // Mensaje si el usuario no tiene permisos de administrador
    echo "No tienes permisos para acceder a esta página.";
}

// Verificar si se ha enviado el formulario de modificar usuario
if (isset($_POST['modificarUsuario'])) {
    // Obtener el ID del usuario a modificar
    $idUsuarioModificar = $_POST['id_usuario'];
    $usuarioModificar = obtenerUsuarioPorID($idUsuarioModificar);

    // Verificar si se obtuvo el usuario
    if ($usuarioModificar) {
        // Mostrar formulario para editar usuario
        echo '<div class="contenedor-usuario">';
        echo '<h3>Editar Usuario</h3>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="id_usuario_modificar" value="' . $idUsuarioModificar . '">';
        echo 'Nombre: <input type="text" name="nombre" value="' . $usuarioModificar['nombre'] . '"><br>';
        echo 'Apellido 1: <input type="text" name="apellido1" value="' . $usuarioModificar['apellido1'] . '"><br>';
        echo 'Apellido 2: <input type="text" name="apellido2" value="' . $usuarioModificar['apellido2'] . '"><br>';
        echo 'Correo: <input type="text" name="correo" value="' . $usuarioModificar['correo'] . '"><br>';
        echo 'Usuario: <input type="text" name="usuario" value="' . $usuarioModificar['usuario'] . '"><br>';
        echo 'Contraseña: <input type="password" name="nuevaContrasena" placeholder="Nueva contraseña"><br>';
        echo 'Rol: <input type="text" name="rol" value="' . $usuarioModificar['rol'] . '"><br>';
        echo '<input type="submit" name="guardarCambiosUsuario" value="Guardar Cambios">';
        echo '</form>';
        echo '</div>';
    }
}

// Verificar si se ha enviado el formulario de guardar cambios de usuario
if (isset($_POST['guardarCambiosUsuario'])) {
    // Obtener datos del formulario
    $idUsuarioModificar = $_POST['id_usuario_modificar'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $nuevaContrasena = $_POST['nuevaContrasena'];
    $rol = $_POST['rol'];

    // Llamar a la función para actualizar el usuario
    if (actualizarUsuarioAdmin($idUsuarioModificar, $nombre, $apellido1, $apellido2, $correo, $usuario, $nuevaContrasena, $rol)) {
        echo '<script>alert("Los cambios han sido guardados.");</script>';
        echo '<script>window.location.href = window.location.href;</script>';
    } else {
        echo "Error al guardar los cambios.";
    }
}
?>
