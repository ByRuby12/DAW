<?php
require_once("funciones.php");

// Verificar si se ha enviado el formulario de cancelar alquiler
if (isset($_POST['cancelarAlquiler'])) {
    $idUsuario = $_POST['id_usuario'];
    $idLibro = $_POST['id_libro'];

    // Realizar la operación de cancelar alquiler aquí
    if (desalquilarLibro($idUsuario, $idLibro)) {
        echo '<script>alert("El alquiler ha sido cancelado.");</script>';
        // Puedes redirigir o realizar alguna acción adicional si es necesario
    } else {
        echo "Error al cancelar el alquiler.";
    }
}

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    $idUsuario = $_SESSION['id'];

    // Obtener los préstamos del usuario actual
    $prestamos = obtenerLibrosAlquilados($idUsuario);

    if ($prestamos) {
        echo '<div class="contenedor3">';
        echo '<table class="tabla-libros">';
        echo '<tr>';
        echo '<th>ID Usuario</th>';
        echo '<th>ID Libro</th>';
        echo '<th>Título</th>';
        echo '<th>Autor</th>';
        echo '<th>Fecha de Préstamo</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';

        // Mostrar información sobre los préstamos
        foreach ($prestamos as $prestamo) {
            echo '<tr>';
            echo '<td>' . $prestamo['id_usuario'] . '</td>';
            echo '<td>' . $prestamo['id_libro'] . '</td>';
            echo '<td>' . $prestamo['titulo'] . '</td>';
            echo '<td>' . $prestamo['autor'] . '</td>';
            echo '<td>' . $prestamo['fin_prestamo'] . '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id_usuario" value="' . $prestamo['id_usuario'] . '">';
            echo '<input type="hidden" name="id_libro" value="' . $prestamo['id_libro'] . '">';
            echo '<input type="submit" name="cancelarAlquiler" value="Cancelar Alquiler">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    } else {
        // Mostrar un mensaje si no hay préstamos
        echo '<div class="contenedor3">';
        echo '<table class="tabla-libros">';
        echo '<tr>';
        echo '<th>ID Usuario</th>';
        echo '<th>ID Libro</th>';
        echo '<th>Título</th>';
        echo '<th>Autor</th>';
        echo '<th>Fecha de Préstamo</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
    }

} else {
    // Mostrar mensaje si el usuario no ha iniciado sesión
    echo "Debes iniciar sesión para ver tus préstamos.";
}
?>
