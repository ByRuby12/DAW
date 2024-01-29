<?php
require_once("funciones.php");

// Verificar si el usuario tiene permisos de administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    // Obtener los libros eliminados
    $librosEliminados = obtenerLibrosEliminados();

    // Verificar si hay libros eliminados
    if ($librosEliminados) {
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

        // Mostrar la información de los libros eliminados
        foreach ($librosEliminados as $libroEliminado) {
            echo '<tr>';
            echo '<td>' . $libroEliminado['id'] . '</td>';
            echo '<td>' . $libroEliminado['isbn'] . '</td>';
            echo '<td>' . $libroEliminado['titulo'] . '</td>';
            echo '<td>' . $libroEliminado['autor'] . '</td>';
            echo '<td>' . $libroEliminado['editorial'] . '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id_libro_restaurar" value="' . $libroEliminado['id'] . '">';
            echo '<input type="submit" name="restaurarLibro" value="Restaurar">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    } else {
        // Mensaje si no hay libros eliminados
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
        echo '</table>';
        echo '</div>';
    }
} else {
    // Mensaje si el usuario no tiene permisos de administrador
    echo "No tienes permisos para acceder a esta página.";
}

// Verificar si se ha enviado el formulario de restaurar libro
if (isset($_POST['restaurarLibro'])) {
    // Obtener el ID del libro a restaurar
    $idLibroRestaurar = $_POST['id_libro_restaurar'];

    // Llamar a la función para restaurar el libro
    if (restaurarLibro($idLibroRestaurar)) {
        echo '<script>alert("El libro ha sido restaurado.");</script>';
        echo '<script>window.location.href = window.location.href;</script>';
    } else {
        echo "Error al restaurar el libro.";
    }
}
?>
