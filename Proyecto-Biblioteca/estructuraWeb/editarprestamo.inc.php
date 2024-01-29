<?php
// Incluir el archivo de funciones necesario
require_once("funciones.php");

// Verificar si el usuario tiene permisos de administrador
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {
    
    // Procesar el formulario de cancelación de préstamo si se ha enviado por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancelarPrestamo"])) {
        // Obtener los datos del formulario
        $idUsuario = $_POST["id_usuario"];
        $idLibro = $_POST["id_libro"];

        // Intentar cancelar el préstamo
        if (cancelarPrestamo($idUsuario, $idLibro)) {
            // Mostrar mensaje de éxito y recargar la página
            echo '<script>alert("El préstamo ha sido cancelado.");</script>';
            echo '<script>window.location.href = window.location.href;</script>';
        } else {
            // Mostrar mensaje de error si la cancelación falla
            echo "Error al cancelar el préstamo.";
        }
    }
?>

<!-- Contenedor principal para mostrar los préstamos -->
<div class="contenedor3">
    <?php
    // Obtener todos los préstamos de la base de datos
    $prestamos = obtenerTodosLosPrestamos();

    // Verificar si se encontraron préstamos
    if ($prestamos) {
        // Mostrar una tabla con información de los préstamos
        echo '<div class="contenedor3">';
        echo '<table class="tabla-libros">';
        echo '<tr>';
        echo '<th>ID Usuario</th>';
        echo '<th>ID Libro</th>';
        echo '<th>Título</th>';
        echo '<th>Autor</th>';
        echo '<th>Fecha de Finalización</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';

        // Iterar sobre cada préstamo y mostrar sus detalles en la tabla
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
            echo '<input type="submit" name="cancelarPrestamo" value="Cancelar Préstamo">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</div>';
    } else {
        // Mostrar mensaje si no se encontraron préstamos en la base de datos
        echo '<table class="tabla-libros">';
        echo '<tr>';
        echo '<th>ID Usuario</th>';
        echo '<th>ID Libro</th>';
        echo '<th>Título</th>';
        echo '<th>Autor</th>';
        echo '<th>Fecha de Finalización</th>';
        echo '<th>Acciones</th>';
        echo '</tr>';
        echo '</table>';
        echo '</div>';
    }
    } else {
        // Mostrar mensaje si el usuario no tiene permisos de administrador
        echo "No tienes permisos para acceder a esta página.";
    }
    ?>
</div>
