<?php
// Incluir el archivo de funciones necesario
require_once("funciones.php");

// Procesar el formulario de búsqueda si se ha enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar las entradas del formulario utilizando la función limpiarEntrada
    $isbn = limpiarEntrada($_POST["isbn"]);
    $titulo = limpiarEntrada($_POST["titulo"]);
    $autor = limpiarEntrada($_POST["autor"]);
    $editorial = limpiarEntrada($_POST["editorial"]);

    // Realizar la búsqueda de libros utilizando los valores filtrados
    $librosFiltrados = buscarLibros($isbn, $titulo, $autor, $editorial);
}
?>

<!-- Formulario de búsqueda con campos para ISBN, título, autor y editorial -->
<form action="<?php echo $_SERVER["PHP_SELF"] . "?ruta=buscador"; ?>" method="post" class="filtrador">
    <label for="isbn">ISBN:</label>
    <input type="text" name="isbn">

    <label for="titulo">Título:</label>
    <input type="text" name="titulo">

    <label for="autor">Autor:</label>
    <input type="text" name="autor">

    <label for="editorial">Editorial:</label>
    <input type="text" name="editorial">

    <input type="submit" value="Buscar">
</form>

<?php
// Mostrar resultados de la búsqueda en una tabla si existen libros filtrados
if (isset($librosFiltrados) && !empty($librosFiltrados)) {
    echo '<div class="contenedor3">';
    echo '<table class="tabla-libros">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>ISBN</th>';
    echo '<th>Título</th>';
    echo '<th>Autor</th>';
    echo '<th>Editorial</th>';
    echo '</tr>';

    // Iterar sobre los libros filtrados y mostrar cada uno en una fila de la tabla
    foreach ($librosFiltrados as $libro) {
        echo '<tr>';
        echo '<td>' . $libro['id'] . '</td>';
        echo '<td>' . $libro['isbn'] . '</td>';
        echo '<td>' . $libro['titulo'] . '</td>';
        echo '<td>' . $libro['autor'] . '</td>';
        echo '<td>' . $libro['editorial'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
    echo '</div>';
} elseif (isset($librosFiltrados) && empty($librosFiltrados)) {
    // Mostrar un mensaje si no se encuentran libros después de la búsqueda
    echo '<div class="contenedor3">';
    echo '<table class="tabla-libros">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>ISBN</th>';
    echo '<th>Título</th>';
    echo '<th>Autor</th>';
    echo '<th>Editorial</th>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
} else {
    // Mostrar una tabla vacía si no se ha realizado la búsqueda
    echo '<div class="contenedor3">';
    echo '<table class="tabla-libros">';
    echo '<tr>';
    echo '<th>ID</th>';
    echo '<th>ISBN</th>';
    echo '<th>Título</th>';
    echo '<th>Autor</th>';
    echo '<th>Editorial</th>';
    echo '</tr>';
    echo '</table>';
    echo '</div>';
}
?>
