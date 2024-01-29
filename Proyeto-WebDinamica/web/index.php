<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/styles.css">
    <title>Librería Online</title>
</head>
<body>

    <header>
        <h1>Librería Online</h1>
    </header>

    <section id="filter-section">
        <!-- Formulario para enviar parámetros al servicio web -->
        <form id="filter-form">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id">

            <label for="author">Autor:</label>
            <input type="text" id="author" name="author">

            <label for="genre">Género:</label>
            <input type="text" id="genre" name="genre">

            <label for="page">Página:</label>
            <input type="text" id="page" name="page">

            <button type="button" onclick="getData()">Buscar</button>
        </form>
    </section>

    <section id="result-section">
        <!-- Aquí se mostrarán los resultados de la búsqueda -->
    </section>

    <script src="js/main.js"></script>
</body>
</html>
