<?php
// Incluir el archivo de funciones necesario
require_once("funciones.php");

// Verificar si se ha enviado el formulario de alquiler (POST)
if (isset($_POST['id_usuario']) && isset($_POST['id_libro'])) {
    // Obtener el ID de usuario de la sesión
    $idUsuario = $_SESSION["id"];
    // Obtener el ID del libro enviado por el formulario
    $idLibro = $_POST['id_libro'];

    // Intentar alquilar el libro para el usuario actual
    if (alquilarLibro($idUsuario, $idLibro)) {
        // Alquiler exitoso, muestra una alerta en JavaScript
        echo '<script>alert("El alquiler ha sido aceptado.");</script>';
    } else {
        // Mostrar mensaje de error si el alquiler falla
        echo "Error al alquilar el libro.";
    }
}

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['usuario'])) {
    // Obtener el ID de usuario de la sesión
    $idUsuario = $_SESSION['usuario'];

    // Obtener la lista de libros disponibles
    $libros = obtenerLibrosDisponibles();

    // Mostrar una tabla con información de los libros disponibles
    echo '<div class="contenedor3">';
    echo '<table class="tabla-libros">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>ISBN</th>';
    echo '<th>Título</th>';
    echo '<th>Autor</th>';
    echo '<th>Editorial</th>';
    echo '<th>Acciones</th>';
    echo '</tr>';

    // Iterar sobre cada libro y mostrar sus detalles en la tabla
    foreach ($libros as $libro) {
        echo '<tr>';
        echo '<td>' . $libro['id'] . '</td>';
        echo '<td>' . $libro['isbn'] . '</td>';
        echo '<td>' . $libro['titulo'] . '</td>';
        echo '<td>' . $libro['autor'] . '</td>';
        echo '<td>' . $libro['editorial'] . '</td>';
        echo '<td>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="id_libro" value="' . $libro['id'] . '">';
        echo '<input type="hidden" name="id_usuario" value="' . $idUsuario . '">';
        echo '<input type="submit" value="Alquilar">';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
} else {
    // Mostrar mensaje si el usuario no ha iniciado sesión
    echo "Debes iniciar sesión para alquilar un libro.";
}
?>
