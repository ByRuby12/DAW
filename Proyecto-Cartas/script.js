// Creo un arreglo vacío donde voy a guardar las tarjetas que se vayan creando
let tarjetas = [];

// Variable para saber cuál tarjeta estoy editando
let tarjetaEnEdicion = null;

// Al cargar la página, recupero las tarjetas guardadas en el localStorage
window.onload = function () {
    const tarjetasGuardadas = localStorage.getItem("tarjetas");
    if (tarjetasGuardadas) {
        tarjetas = JSON.parse(tarjetasGuardadas); // Las convierto en objetos otra vez
        tarjetas.forEach(tarjeta => crearTarjetaEnDOM(tarjeta)); // Las muestro en la página
        actualizarContador(); // Actualizo el número total de tarjetas
    }
};

// Función para crear una nueva tarjeta cuando se hace clic en "Crear Tarjeta"
document.getElementById("crearTarjeta").addEventListener("click", function () {
    const titulo = document.getElementById("titulo").value; // Título de la tarjeta
    const descripcion = document.getElementById("descripcion").value; // Descripción
    const color = document.getElementById("color").value; // Color de fondo

    // Si falta rellenar algo, aviso con una alerta
    if (!titulo || !descripcion) {
        alert("Completa todos los campos.");
        return;
    }

    // Objeto con los datos de la tarjeta
    const tarjeta = { id: Date.now(), titulo, descripcion, color };

    tarjetas.push(tarjeta); // Meto la tarjeta en el arreglo

    crearTarjetaEnDOM(tarjeta); // La muestro en la página

    guardarEnLocalStorage(); // Actualizo el localStorage
    actualizarContador(); // Actualizo el contador de tarjetas

    document.getElementById("formularioTarjeta").reset(); // Limpio el formulario
});

// Función para mostrar la tarjeta en la página
function crearTarjetaEnDOM(tarjeta) {
    const contenedor = document.getElementById("contenedorTarjetas");
    const tarjetaDiv = document.createElement("div");

    tarjetaDiv.className = "tarjeta"; // Clase CSS
    tarjetaDiv.style.backgroundColor = tarjeta.color; // Color de fondo
    tarjetaDiv.id = tarjeta.id; // ID único de la tarjeta

    // Contenido de la tarjeta
    tarjetaDiv.innerHTML = `
        <h3>${tarjeta.titulo}</h3>
        <p>${tarjeta.descripcion}</p>
        <button onclick="editarTarjeta(${tarjeta.id})">Editar</button>
        <button onclick="eliminarTarjeta(${tarjeta.id})">Eliminar</button>
    `;

    contenedor.appendChild(tarjetaDiv); // Añado la tarjeta al contenedor
}

// Función para eliminar una tarjeta
function eliminarTarjeta(id) {
    tarjetas = tarjetas.filter(t => t.id !== id); // Quito la tarjeta del arreglo
    document.getElementById(id).remove(); // Borro la tarjeta de la página

    guardarEnLocalStorage(); // Actualizo el localStorage
    actualizarContador(); // Actualizo el número total de tarjetas
}

// Función para editar una tarjeta
function editarTarjeta(id) {
    tarjetaEnEdicion = id; // Guardo qué tarjeta estoy editando
    const tarjeta = tarjetas.find(t => t.id === id); // Encuentro la tarjeta en el arreglo

    // Relleno el formulario con los datos de la tarjeta
    document.getElementById("titulo").value = tarjeta.titulo;
    document.getElementById("descripcion").value = tarjeta.descripcion;
    document.getElementById("color").value = tarjeta.color;

    // Cambio los botones (oculto "Crear" y muestro "Guardar Cambios")
    document.getElementById("crearTarjeta").style.display = "none";
    document.getElementById("guardarEdicion").style.display = "block";
}

// Función para guardar los cambios de una tarjeta editada
document.getElementById("guardarEdicion").addEventListener("click", function () {
    const tarjeta = tarjetas.find(t => t.id === tarjetaEnEdicion); // Busco la tarjeta a editar

    // Actualizo los datos de la tarjeta con lo que puse en el formulario
    tarjeta.titulo = document.getElementById("titulo").value;
    tarjeta.descripcion = document.getElementById("descripcion").value;
    tarjeta.color = document.getElementById("color").value;

    recargarTarjetas(); // Vuelvo a mostrar todas las tarjetas
    guardarEnLocalStorage(); // Guardo en localStorage
    actualizarContador(); // Actualizo el contador

    // Limpio el formulario y cambio los botones de vuelta
    document.getElementById("formularioTarjeta").reset();
    document.getElementById("guardarEdicion").style.display = "none";
    document.getElementById("crearTarjeta").style.display = "block";
});

// Función para borrar y volver a cargar todas las tarjetas en la página
function recargarTarjetas() {
    document.getElementById("contenedorTarjetas").innerHTML = ""; // Limpio el contenedor
    tarjetas.forEach(t => crearTarjetaEnDOM(t)); // Añado todas las tarjetas otra vez
}

// Función para guardar las tarjetas en localStorage
function guardarEnLocalStorage() {
    localStorage.setItem("tarjetas", JSON.stringify(tarjetas)); // Guardo como texto
}

// Función para actualizar el contador de tarjetas
function actualizarContador() {
    document.getElementById("contador").textContent = tarjetas.length; // Muestro el total
}
