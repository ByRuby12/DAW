<?php
require_once("funciones.php");
if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin') {

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["crearLibro"])) {
    $isbn = $_POST["isbn"];
    $titulo = $_POST["titulo"];
    $autor = $_POST["autor"];
    $editorial = $_POST["editorial"];

    if (!isbnExistente($isbn) && crearLibro($isbn, $titulo, $autor, $editorial)) {
        echo '<script>alert("Libro creado con éxito.");</script>';
        echo '<script>window.location.href = window.location.href;</script>';
    } else {
        echo '<script>alert("Error al crear el libro. El ISBN ya existe.") </script>';
        echo '<script>window.location.href = window.location.href;</script>';
    }
}
?>

<div class="contenedor-crearusuario">
    <h2>Crear Nuevo Libro</h2>
    <form method="post" action="<?php echo $_SERVER["PHP_SELF"] . "?ruta=crearlibros"; ?>">
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>

        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="autor">Autor:</label>
        <input type="text" id="autor" name="autor" required>

        <label for="editorial">Editorial:</label>
        <input type="text" id="editorial" name="editorial" required>

        <input type="submit" name="crearLibro" value="Crear Libro">
    </form>
</div>

<?php

} else {
    echo "No tienes permisos para acceder a esta página.";
}

?>