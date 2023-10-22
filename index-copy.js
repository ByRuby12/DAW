// Obtención de referencias a elementos del DOM
const formulario = document.getElementById('formulario'); 
const seleccionados = document.getElementById("seleccionados");
const delegado = document.getElementById("delegado"); 
const subdelegado = document.getElementById("subDelegado"); 
const numVotos = document.getElementById("numVotos"); 
const grabarBtn = document.getElementById("grabar"); 
const eliminarBtn = document.getElementById("eliminar"); 

// Objeto de control que maneja la lógica de la aplicación
const control = {
    listaVotados:[], // Array que almacena los votados
    votosEmitidos:0, // Contador de votos emitidos

    // Método para aumentar el voto de un candidato
    aumentaVoto(id){
        this.listaVotados[id].votos++; 
        this.votosEmitidos++; 
        numVotos.textContent = this.votosEmitidos; 
    },

    // Método para insertar un nuevo votado en la lista
    insertaVotado(nombre)  {
        this.listaVotados.push({ 
            nombre:nombre, 
            votos:0, 
        });
        const id = this.listaVotados.length-1; // Obtener el ID del votado en la lista
        
        // Crear un nuevo elemento HTML para mostrar el votado en la interfaz
        const elementoListaSeleccionados = document.createElement('div');
        elementoListaSeleccionados.innerHTML = `<p>${nombre}</p>
            <input type="button" class="boton-modificado" value="0" id="C${id}" data-counter>`;                     
        elementoListaSeleccionados.id = nombre; 
        seleccionados.append(elementoListaSeleccionados); 

        // Asignar un evento al botón para incrementar votos cuando se hace clic
        document.getElementById(`C${id}`).addEventListener("click",(event)=>{  
            if (event.target.dataset.counter != undefined ) {
                this.aumentaVoto(id); 
                event.target.value++; 
                this.dameDelegado(); 
                formulario["nombre"].focus(); 
            }
        });
    },  

    // Método para resetear el formulario después de añadir un votado
    reseteaFormulario() {
        formulario['nombre'].value=''; 
        formulario['nombre'].focus(); 
    },

    // Método para determinar el delegado y subdelegado basándose en los votos
    dameDelegado(){
        const nombreDelegado = [...this.listaVotados].sort((ele1, ele2)=>
                    ele2.votos - ele1.votos); 
        delegado.textContent=`Delegado: ${nombreDelegado[0].nombre}`; 
        const divDelegado = document.getElementById(`${nombreDelegado[0].nombre}`); 
        seleccionados.insertAdjacentElement('afterbegin', divDelegado); 
        if (nombreDelegado.length > 1){ 
            subdelegado.textContent=`SubDelegado: ${nombreDelegado[1].nombre}`; 
            const divSubDelegado = document.getElementById(`${nombreDelegado[1].nombre}`); 
            divDelegado.insertAdjacentElement('afterend', divSubDelegado); 
        }
    },

    /* Aquí empieza la guardada de datos en el LocalStorage en formato JSON para que pueda ser recuperado posteriormente */
    grabarDatosEnLocalStorage() {
        localStorage.setItem("votacion", JSON.stringify(this.listaVotados)); // Guardar la lista de votados en el LocalStorage
    },

    // Método para cargar datos desde el LocalStorage y restaurar el estado anterior
    cargarDatosDesdeLocalStorage() {
        const datosGuardados = localStorage.getItem("votacion"); 
        if (datosGuardados) { // Si hay datos guardados
            this.listaVotados = JSON.parse(datosGuardados); // Parsear los datos guardados
            this.votosEmitidos = this.listaVotados.reduce((total, votado) => total + votado.votos, 0); 
            numVotos.textContent = this.votosEmitidos; 
            this.listaVotados.forEach((votado, id) => {
                this.insertaVotado(votado.nombre);
                document.getElementById(`C${id}`).value = votado.votos;
            });
            this.dameDelegado(); 
        }
    },

    // Método para eliminar datos del LocalStorage
    eliminarDatosEnLocalStorage() {
        localStorage.removeItem("votacion"); 
    }
};

// Evento cuando se envía el formulario
formulario.addEventListener("submit", (event) => {
    event.preventDefault(); 
    if (formulario['nombre'].value !== "") {
        control.insertaVotado(formulario['nombre'].value); 
        control.reseteaFormulario(); 
    }
});

// Evento cuando se hace clic en el botón de grabar
grabarBtn.addEventListener("click", () => {
    control.grabarDatosEnLocalStorage(); 
    alert("Datos guardados en el LocalStorage."); 
});

// Evento cuando se hace clic en el botón de eliminar
eliminarBtn.addEventListener("click", () => {
    seleccionados.innerHTML = ""; 
    control.listaVotados = []; 
    control.votosEmitidos = 0; 
    numVotos.textContent = 0; 
    delegado.textContent = ""; 
    subdelegado.textContent = ""; 
    control.eliminarDatosEnLocalStorage(); 
    alert("Datos eliminados del LocalStorage y de la pantalla."); 
});

// Evento cuando se carga la página
window.addEventListener("DOMContentLoaded", () => {
    control.cargarDatosDesdeLocalStorage(); 
});
