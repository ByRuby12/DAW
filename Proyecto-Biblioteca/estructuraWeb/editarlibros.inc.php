<?php
// Incluir el archivo de funciones necesario
require_once("funciones.php");

// Verificar si el usuario tiene permisos de administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    
    // Obtener todos los libros de la base de datos
    $libros = obtenerTodosLosLibros();

    // Verificar si se encontraron libros
    if ($libros) {
        // Mostrar una tabla con información de los libros
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
            echo '<input type="submit" name="modificarLibro" value="Modificar">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    } else {
        // Mostrar mensaje si no se encontraron libros en la base de datos
        echo "No se encontraron libros en la base de datos.";
    }
} else {
    // Mostrar mensaje si el usuario no tiene permisos de administrador
    echo "No tienes permisos para acceder a esta página.";
}

// Procesar el formulario de modificación de libro si se ha enviado por POST
if (isset($_POST['modificarLibro'])) {
    // Obtener el ID del libro a modificar
    $idLibroModificar = $_POST['id_libro'];
    
    // Obtener la información del libro a modificar
    $libroModificar = obtenerLibroPorId($idLibroModificar);

    // Verificar si se encontró el libro a modificar
    if ($libroModificar) {
        // Mostrar formulario para modificar el libro
        echo '<div class="contenedor-libro">';
        echo '<h3>Modificar Libro</h3>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="id_libro_modificar" value="' . $idLibroModificar . '">';
        echo 'ISBN: <input type="text" name="isbn" value="' . $libroModificar['isbn'] . '" required><br>';
        echo 'Título: <input type="text" name="titulo" value="' . $libroModificar['titulo'] . '" required><br>';
        echo 'Autor: <input type="text" name="autor" value="' . $libroModificar['autor'] . '" required><br>';
        echo 'Editorial: <input type="text" name="editorial" value="' . $libroModificar['editorial'] . '" required><br>';
        echo '<input type="submit" name="guardarCambiosLibro" value="Guardar Cambios">';
        echo '</form>';
        echo '</div>';
    }
}

// Procesar el formulario de guardar cambios si se ha enviado por POST
if (isset($_POST['guardarCambiosLibro'])) {
    // Obtener los datos del formulario
    $idLibroModificar = $_POST['id_libro_modificar'];
    $isbn = $_POST['isbn'];
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $editorial = $_POST['editorial'];

    // Intentar actualizar la información del libro en la base de datos
    if (actualizarLibro($idLibroModificar, $isbn, $titulo, $autor, $editorial)) {
        // Mostrar mensaje de éxito y recargar la página
        echo '<script>alert("Los cambios han sido guardados.");</script>';
        echo '<script>window.location.href = window.location.href;</script>';
    } else {
        // Mostrar mensaje de error si la actualización falla
        echo "Error al guardar los cambios.";
    }
}
?>
