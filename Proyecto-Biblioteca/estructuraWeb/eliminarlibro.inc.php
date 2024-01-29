<?php
// Incluir el archivo de funciones necesario
require_once("funciones.php");

// Verificar si el usuario tiene permisos de administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    
    // Obtener todos los libros de la base de datos para administradores
    $libros = obtenerTodosLosLibrosAdmin();

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
        echo '<th>Disponible</th>';
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
            echo '<td>' . ($libro['disponible'] ? 'Sí' : 'No') . '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="id_libro_eliminar" value="' . $libro['id'] . '">';
            echo '<input type="submit" name="eliminarLibro" value="Eliminar">';
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

// Procesar el formulario de eliminar libro si se ha enviado por POST
if (isset($_POST['eliminarLibro'])) {
    // Obtener el ID del libro a eliminar
    $idLibroEliminar = $_POST['id_libro_eliminar'];
    
    // Obtener la información del libro a eliminar
    $libroEliminar = obtenerLibroPorID($idLibroEliminar);

    // Verificar si se encontró el libro a eliminar
    if ($libroEliminar) {
        // Intentar eliminar el libro
        if (eliminarLibro($libroEliminar)) {
            // Mostrar mensaje de éxito y recargar la página
            echo '<script>alert("El libro ha sido eliminado.");</script>';
            echo '<script>window.location.href = window.location.href;</script>';
        } else {
            // Mostrar mensaje de error si la eliminación falla
            echo "Error al eliminar el libro.";
        }
    }
}
?>
