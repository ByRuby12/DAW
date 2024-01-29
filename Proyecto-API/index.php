<?php
header("Content-Type: application/json");

// Cargar el documento XML
$xml = simplexml_load_file('data.xml');

// Obtener parámetros de la solicitud
$id = isset($_GET['id']) ? $_GET['id'] : null;
$author = isset($_GET['author']) ? $_GET['author'] : null;
$genre = isset($_GET['genre']) ? $_GET['genre'] : null;
$page = isset($_GET['page']) ? $_GET['page'] : null;

// Función para filtrar libros según parámetros
function filterBooks($xml, $id, $author, $genre, $page) {
    $filteredBooks = [];

    foreach ($xml->book as $book) {
        if (
            (!$id || $book['id'] == $id) &&
            (!$author || stripos($book->author, $author) !== false) &&
            (!$genre || stripos($book->genre, $genre) !== false)
        ) {
            $filteredBooks[] = [
                'id' => (string)$book['id'],
                'author' => (string)$book->author,
                'title' => (string)$book->title,
                'genre' => (string)$book->genre,
                'price' => (float)$book->price,
                'publish_date' => (string)$book->publish_date,
                'description' => (string)$book->description,
            ];
        }
    }

    // Paginar si se proporciona el parámetro 'page'
    if ($page && is_numeric($page)) {
        $perPage = 5; // Número de libros por página
        $start = ($page - 1) * $perPage;
        $filteredBooks = array_slice($filteredBooks, $start, $perPage);
    }

    return $filteredBooks;
}

// Procesar la solicitud y devolver la respuesta JSON
$response = [];

if (!$id && !$author && !$genre && !$page) {
    // Si no se proporcionan parámetros, devolver todo el documento
    $response = $xml;
} else {
    // Filtrar libros según parámetros
    $response['books'] = filterBooks($xml, $id, $author, $genre, $page);
}

echo json_encode($response, JSON_PRETTY_PRINT);
?>
