function getData() {
    const id = document.getElementById('id').value;
    const author = document.getElementById('author').value;
    const genre = document.getElementById('genre').value;
    const page = document.getElementById('page').value;

    // Realizar llamada a la API con los parámetros proporcionados
    fetch(`https://localhost/DWES/Proyeto-WebDinamica/modelo/index.php?id=${id}&author=${author}&genre=${genre}&page=${page}`)
        .then(response => response.json())
        .then(data => displayResults(data));
}

function displayResults(data) {
    const resultSection = document.getElementById('result-section');
    resultSection.innerHTML = ''; // Limpiar resultados anteriores

    if (data.books && data.books.length > 0) {
        data.books.forEach(book => {
            const bookElement = document.createElement('div');
            bookElement.innerHTML = `
                <h3>${book.title}</h3>
                <p><strong>Autor:</strong> ${book.author}</p>
                <p><strong>Género:</strong> ${book.genre}</p>
                <p><strong>Precio:</strong> ${book.price}</p>
                <p><strong>Fecha de Publicación:</strong> ${book.publish_date}</p>
                <p><strong>Descripción:</strong> ${book.description}</p>
                <hr>
            `;
            resultSection.appendChild(bookElement);
        });
    } else {
        resultSection.innerHTML = '<p>No se encontraron resultados.</p>';
    }
}
