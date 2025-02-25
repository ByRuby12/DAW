// Variables del Historial de los documentos Guardados y para rastrear el documento en edicion.
let historial = [];
let indiceHistorial = -1;
let currentEditingDocument = null;

// Función para aplicar formato al texto seleccionado en un elemento contenteditable (como negrita, cursiva o subrayado)
function formatText(command) {
    document.execCommand(command, false, null);
}

// Constantes de edición, palabras del textarea y caracteres del Textarea.
const editor = document.getElementById('editor');
const palabrasSpan = document.getElementById('palabras');
const caracteresSpan = document.getElementById('caracteres');

// Nada más acceder a la web o refrescar la web, cargue todos los elementos en la Web
document.addEventListener('DOMContentLoaded', () => {
    loadDocuments();
    editor.addEventListener('input', () => {
        actualizarEstadisticas();
        guardarEstado();
    });
});

// Funcion para deshacer lo que hubieramos escrito en el Textarea
function deshacer() {
    if (indiceHistorial > 0) {
        indiceHistorial--;
        editor.innerHTML = historial[indiceHistorial]; 
        actualizarEstadisticas();
    }
}

// Funcion para rehacer lo que hubieramos escrito en el Textarea
function rehacer() {
    if (indiceHistorial < historial.length - 1) {
        indiceHistorial++;
        editor.innerHTML = historial[indiceHistorial]; 
        actualizarEstadisticas();
    }
}

// Función para guardar el estado de la edición que estemos desde TextArea
function guardarEstado() {
    historial = historial.slice(0, indiceHistorial + 1); 
    historial.push(editor.innerHTML); // Guardar el contenido HTML
    indiceHistorial++; // Avanzamos en el historial
}

// Función para que se valla actualizando de manera constante el Nº de palabras y de Caracteres que estemos escribiendo en el Textarea
function actualizarEstadisticas() {
    const texto = editor.innerText.trim(); 
    const palabras = texto.split(/\s+/).filter((palabra) => palabra.length > 0);
    const caracteres = texto.replace(/\s/g, '').length;

    palabrasSpan.textContent = palabras.length; 
    caracteresSpan.textContent = caracteres; 
}

// Función para cambiar el Fondo del Textarea con codigo hexadecimal (#121212)
function cambiarFondoEditor() {
    const color = prompt("Introduce el color de fondo (código hexadecimal):");
    if (color) {
        editor.style.backgroundColor = color;
    }
}

// Función para guardar el documento al LocalStorage
function saveDocument() {
    const content = document.getElementById('editor').innerHTML;
    const documents = JSON.parse(localStorage.getItem('documents')) || {};

    if (currentEditingDocument) {
        documents[currentEditingDocument] = content;
        alert(`Cambios guardados en "${currentEditingDocument}".`);
    } else {
        const title = prompt("Introduce el título del documento:");
        if (!title) return alert("El título es obligatorio.");
        if (documents[title]) {
            return alert("Ya existe un documento con este título. Usa otro nombre o edita el existente.");
        }

        documents[title] = content;
        alert("Documento guardado con éxito.");
    }

    localStorage.setItem('documents', JSON.stringify(documents));
    currentEditingDocument = null;
    loadDocuments();
}

// Funciones para editar, eliminar, y cargar documentos
function toggleEditTitle(title) {
    const titleSpan = document.querySelector(`#title-${title}`);
    const editDiv = document.querySelector(`#edit-input-${title}`).parentElement;

    if (editDiv.style.display === 'none' || editDiv.style.display === '') {
        titleSpan.style.display = 'none';
        editDiv.style.display = 'flex';
    } else {
        titleSpan.style.display = 'block';
        editDiv.style.display = 'none';
    }
}

// Función para Guardar un documento al LocalStorage con un titulo en especifico.
function saveEditedTitle(title) {
    const newTitle = document.querySelector(`#edit-input-${title}`).value;
    const documents = JSON.parse(localStorage.getItem('documents')) || {};

    if (documents[newTitle]) {
        alert("Ya existe un documento con este título. Usa otro nombre.");
        return;
    }

    documents[newTitle] = documents[title];
    delete documents[title];
    localStorage.setItem('documents', JSON.stringify(documents));

    loadDocuments();
}

// Función para cargar los documentos que tengamos en el LocalSotrage (en este caso, para que se cargue el ultimo guardado)
function loadDocuments() {
    const documents = JSON.parse(localStorage.getItem('documents')) || {};
    const documentList = document.getElementById('document-list');
    
    documentList.innerHTML = '';

    const titles = Object.keys(documents);
    const maxDisplay = 1; // Número máximo de documentos a mostrar

    titles.slice(0, maxDisplay).forEach(title => { // Esto es para que muestre solamente 1
        const li = document.createElement('li');
        li.innerHTML = `
            <div>
                <span id="title-${title}">${title}</span>
                <div class="edit-title" style="display: none;">
                    <input type="text" id="edit-input-${title}" value="${title}" />
                    <button onclick="saveEditedTitle('${title}')">Guardar</button>
                </div>
            </div>
            <div>
                <button onclick="editDocument('${title}')">Editar</button>
                <button onclick="deleteDocument('${title}')">Borrar</button>
                <button onclick="toggleEditTitle('${title}')"><i class="fas fa-edit"></i></button>
            </div>
        `;
        documentList.appendChild(li);
    });
}

// Funcion para cambiar la tipografía y tamaño de la letra dentro del textarea
function cambiarTipografia(tipo) {
    const fonts = {
        "Times New Roman": "Times New Roman, serif",
        "Arial": "Arial, sans-serif",
        "Courier New": "Courier New, monospace",
        "Georgia": "Georgia, serif",
        "Verdana": "Verdana, sans-serif"
    };
    editor.style.fontFamily = fonts[tipo];
}

// Función para poder cambiar el tamaño de la letra dentro del textarea (mas grande o mas pequeño)
function cambiarTamanoLetra(accion) {
    let currentSize = window.getComputedStyle(editor, null).getPropertyValue('font-size');
    currentSize = parseInt(currentSize); // Convertir de px a número

    if (accion === 'aumentar') {
        currentSize += 2;
    } else if (accion === 'reducir') {
        currentSize -= 2;
    }

    editor.style.fontSize = currentSize + 'px';
}

// Función para borrar todos los documentos guardados que tengamos almacenados en el LocalStorage
function borrarTodosLosDocumentos() {
    if (confirm("¿Estás seguro de que deseas borrar todos los documentos guardados?")) {
        localStorage.removeItem('documents');
        loadDocuments();
        alert("Todos los documentos han sido borrados.");
    }
}

// Función para editar un documento que tengamos almacenados en el LocalStorage
function editDocument(title) {
    const documents = JSON.parse(localStorage.getItem('documents')) || {};
    const content = documents[title];

    document.getElementById('editor').innerHTML = content;
    currentEditingDocument = title;
    alert(`Editando el documento: "${title}"`);
}

// Función para eliminar un documento que tengamos almacenados en el LocalStorage
function deleteDocument(title) {
    const documents = JSON.parse(localStorage.getItem('documents')) || {};

    if (confirm(`¿Estás seguro de que deseas borrar el documento: "${title}"?`)) {
        delete documents[title];
        localStorage.setItem('documents', JSON.stringify(documents));
        loadDocuments();
        alert("Documento eliminado con éxito.");
    }
}

// Función para poder filtrar los documentos guardados en el LocalStorage
function filterDocuments() {
    const searchValue = document.getElementById('search').value.toLowerCase();
    const documents = JSON.parse(localStorage.getItem('documents')) || {};
    const documentList = document.getElementById('document-list');

    documentList.innerHTML = '';

    // Si el campo de búsqueda está vacío, no muestra ningún documento
    if (searchValue.trim() === '') {
        return;
    }

    Object.keys(documents)
        .filter(title => title.toLowerCase().includes(searchValue))
        .forEach(title => {
            const li = document.createElement('li');
            li.innerHTML = `
                <div>
                    <span id="title-${title}">${title}</span>
                    <div class="edit-title" style="display: none;">
                        <input type="text" id="edit-input-${title}" value="${title}" />
                        <button onclick="saveEditedTitle('${title}')">Guardar</button>
                    </div>
                </div>
                <div>
                    <button onclick="editDocument('${title}')">Editar</button>
                    <button onclick="deleteDocument('${title}')">Borrar</button>
                    <button onclick="toggleEditTitle('${title}')"><i class="fas fa-edit"></i></button>
                </div>
            `;
            documentList.appendChild(li);
        });
}

// Funcion para exportar lo que hemos escrito en el Textarea a un .txt
function exportToTxt() {
    const content = document.getElementById('editor').innerText;
    const blob = new Blob([content], { type: 'text/plain' });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = 'documento.txt';
    a.click();
}

// Función para exportar todos los documentos almacenados en el LocalStorage aun JSON.
function exportToJson() {
    let documents = [];

    for (let i = 0; i < localStorage.length; i++) {
        let key = localStorage.key(i);
        let value = localStorage.getItem(key);

        try {
            let doc = JSON.parse(value); // Intentar parsear el JSON
            documents.push({ key, data: doc }); // Guardar junto con su clave
        } catch (error) {
            console.warn(`El valor de la clave "${key}" no es un JSON válido. Se omitirá.`);
        }
    }

    if (documents.length === 0) {
        alert("No hay documentos válidos para exportar.");
        return;
    }

    let blob = new Blob([JSON.stringify(documents, null, 2)], { type: 'application/json' });

    let link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'documentos.json';
    document.body.appendChild(link); // Agregar al DOM
    link.click();
    document.body.removeChild(link); // Eliminar después de la descarga
}


// Para exportarlo a PDF con una personalización (se puede ampliar pero es lo unico que he podio encontrar para poder personalizarlo)
function exportToPdf() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        format: 'a4',
        unit: 'mm'
    });

    // Configuración de la fuente
    doc.setFont('times');
    doc.setFontSize(20);
    doc.setFont('times', 'bold');

    // Título centrado
    doc.text('Documento Personalizado', 105, 20, { align: 'center' });

    // Línea separadora
    doc.setLineWidth(0.5);
    doc.line(10, 25, 200, 25);

    // Sección de introducción
    doc.setFontSize(12);
    doc.setFont('times', 'normal');
    doc.text('Introducción:', 10, 35);
    doc.setFontSize(10);
    doc.text(
        'Este documento ha sido generado automáticamente desde el editor. Aquí se muestra el contenido editado con una estructura clara y ordenada.',
        10, 40, { maxWidth: 190 }
    );

    // Otra línea separadora
    doc.setLineWidth(0.2);
    doc.line(10, 50, 200, 50);

    // Sección del contenido
    doc.setFontSize(12);
    doc.setFont('times', 'bold');
    doc.text('Contenido del Documento:', 10, 60);
    doc.setFont('times', 'normal');

    // Obtener el contenido del editor
    const content = document.getElementById('editor').innerText;

    // Ajustes para texto extenso
    let yOffset = 70; // Posición inicial en la página
    const pageHeight = doc.internal.pageSize.height;
    const lineHeight = 7; // Espaciado entre líneas
    const maxWidth = 180; // Ancho máximo de línea

    // Dividir el texto en líneas para ajustarse al ancho del PDF
    const lines = doc.splitTextToSize(content, maxWidth);

    // Iterar sobre las líneas y agregarlas al documento
    lines.forEach(line => {
        if (yOffset + lineHeight > pageHeight - 20) { // Salto de página si se llega al final
            doc.addPage();
            yOffset = 20; // Reiniciar la posición Y
            doc.setFontSize(10);
            doc.text('Continúa...', 10, 15);
            doc.addPage();
        }
        doc.text(line, 10, yOffset);
        yOffset += lineHeight;
    });
    
    // Guardar el documento como archivo PDF
    doc.save('documento.pdf');
}    