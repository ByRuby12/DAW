/*--------------------------TRIVIAL SCRIPT ENTERO-------------------------*/

/* Lista de Objetos de las preguntas trivial (pregunta, respuestas y correctas*/
const preguntas_array = [
    {
        question: "¿Qué significa que JavaScript es 'ligero'?",
        options: [
            "Consume muchos recursos del sistema",
            "Ocupa poco espacio en memoria y es fácil de implementar",
            "Es muy complicado de aprender"
        ],
        correct: 1
    },
    {
        question: "¿Qué tipo de tipado tiene JavaScript?",
        options: [
            "Fuertemente tipado",
            "Dinámicamente tipado",
            "Débilmente tipado"
        ],
        correct: 2
    },
    {
        question: "¿Qué característica describe a JavaScript como un lenguaje 'case sensitive'?",
        options: [
            "No distingue entre mayúsculas y minúsculas",
            "Distingue entre mayúsculas y minúsculas",
            "Solo usa minúsculas"
        ],
        correct: 1
    },
    {
        question: "¿Qué significa que JavaScript es 'monohilo'?",
        options: [
            "Puede ejecutar múltiples hilos a la vez",
            "Usa un único hilo de ejecución",
            "No utiliza hilos en absoluto"
        ],
        correct: 1
    },
    {
        question: "¿Cómo se crean objetos en JavaScript?",
        options: [
            "Instanciando clases",
            "Clonando otros objetos o creándolos directamente",
            "Utilizando funciones especiales"
        ],
        correct: 1
    },
    {
        question: "¿Cuál es el modelo que utiliza JavaScript para manipular un documento HTML?",
        options: [
            "JSON",
            "DOM (Document Object Model)",
            "XML"
        ],
        correct: 1
    },
    {
        question: "¿Cuál es la etiqueta HTML utilizada para incluir código JavaScript en una página web?",
        options: [
            "<js>",
            "<code>",
            "<script>"
        ],
        correct: 2
    },
    {
        question: "¿Cuál es una característica de la programación declarativa?",
        options: [
            "Describir qué se quiere obtener",
            "Describir cómo se quiere obtener",
            "Ejecutar pasos detallados uno por uno"
        ],
        correct: 0
    },
    {
        question: "¿Qué atributo del tag <script> permite cargar un archivo JavaScript externo?",
        options: [
            "type",
            "src",
            "link"
        ],
        correct: 1
    },
    {
        question: "¿Cuál es el símbolo utilizado para comentarios de una línea en JavaScript?",
        options: [
            "//",
            "/*",
            "#!"
        ],
        correct: 0
    },
    {
        question: "¿Qué es un identificador en JavaScript?",
        options: [
            "Un nombre que asignamos a elementos como variables y funciones",
            "Un número de referencia para objetos",
            "Un valor predefinido del lenguaje"
        ],
        correct: 0
    },
    {
        question: "¿Qué palabra reservada se utiliza para declarar variables que pueden ser reasignadas en JavaScript?",
        options: [
            "let",
            "const",
            "var"
        ],
        correct: 0
    },
    {
        question: "¿Qué es el 'prompt' en la consola del navegador?",
        options: [
            "Un símbolo que espera una orden del usuario",
            "Un comando que inicia un programa",
            "Un error del navegador"
        ],
        correct: 0
    },
    {
        question: "¿Qué tipo de modelo de programación permite JavaScript?",
        options: [
            "Solo programación orientada a objetos",
            "Programación orientada a objetos, imperativa y declarativa",
            "Solo programación declarativa"
        ],
        correct: 1
    },
    {
        question: "¿Cómo se organizan las sentencias de JavaScript en el código?",
        options: [
            "Entre paréntesis",
            "En bloques delimitados por llaves",
            "Entre corchetes"
        ],
        correct: 1
    },
    {
        question: "¿Qué significa que JavaScript sea dinámico?",
        options: [
            "El código no puede cambiar durante la ejecución",
            "El lenguaje puede modificar la estructura de un objeto o el tipo de una variable en tiempo de ejecución",
            "Solo se pueden cambiar las funciones"
        ],
        correct: 1
    },
    {
        question: "¿Cómo se crea un comentario de varias líneas en JavaScript?",
        options: [
            "Con /* */",
            "Con #",
            "Con //"
        ],
        correct: 0
    },
    {
        question: "¿Qué palabra reservada se utiliza para declarar constantes en JavaScript?",
        options: [
            "var",
            "let",
            "const"
        ],
        correct: 2
    },
    {
        question: "¿Cuál es el propósito principal de JavaScript del lado servidor?",
        options: [
            "Controlar el DOM en un navegador",
            "Gestionar bases de datos, archivos y solicitudes HTTP",
            "Diseñar la interfaz de usuario"
        ],
        correct: 1
    },
    {
        question: "¿Cuál es una de las principales ventajas de usar bloques en JavaScript?",
        options: [
            "Permiten declarar variables globales",
            "Mejoran la visibilidad y el alcance de las variables",
            "Solo se usan para comentarios"
        ],
        correct: 1
    }
];

/* Variables del juego (Numero preguntas, preguntas correctas y las incorrectas)*/
let numero_pregunta = 0;
let preguntas_correctas = 0;
let preguntas_incorrectas = 0;

/* Elementos del DOM (Textos de las "preguntas_array", el numero de la pregunta, opciones
boton de enviar respuesta de la pregunta, texto de resultado de la respuesta y salirse del juego*/
const texto_pregunta = document.getElementById("texto-pregunta");
const texto_numero_pregunta = document.getElementById("numero-pregunta");
const texto_opcion = [
    document.getElementById("opcion-0"),
    document.getElementById("opcion-1"),
    document.getElementById("opcion-2")];
const boton_enviar = document.getElementById("boton-enviar");
const resultado_respuesta = document.getElementById("resultado-respuesta"); 
const salir_juego = document.getElementById("salir-juego"); 

/* Función para mostrar la pregunta actual (Va recorriendo las preguntas de "preguntas_array"
y va incrementado tanto el numero de pregunta y la pregunta, a funcion de que va corrigiendo 
las preguntas del trivial y finalmente "resultado_respuesta" se va borrando cada vez que corrige)*/
function mostrar_pregunta() {
    const current = preguntas_array[numero_pregunta];
    texto_pregunta.textContent = current.question;
    texto_numero_pregunta.textContent = numero_pregunta + 1;
    console.clear();
    console.log("Pregunta " + numero_pregunta + " :" + texto_pregunta.textContent)

    for (let i = 0; i < 3; i++) {
        texto_opcion[i].textContent = current.options[i];
        texto_opcion[i].previousElementSibling.checked = false;  // Desmarcar las opciones
        console.log("Respuesta " + i + " : " + texto_opcion[i].textContent);
    }
    resultado_respuesta.textContent = ""; 
}

/* Función para comprobar la respuesta (Si no hay ninguna marcada, te salta un alert de que
tienes que marcar una de ellas. Y si está marcada, dependiendo de la opcion marcada y el "correct"
de "preguntas_array" compara si es correcta o no. Si es correcta, lanza mensaje. Si es incorrecta, 
lanza mensaje de que esta incorrecta y te indica la correcta. Tarda 6 segundos hasta que se quite 
ese mensaje y valla a la siguiente pregunta)*/
boton_enviar.addEventListener("click", () => {
    const seleccionar_opcion = document.querySelector('input[name="option"]:checked');
    if (!seleccionar_opcion) {
        alert("Por favor, selecciona una respuesta");
        return;
    }

    const pregunta = parseInt(seleccionar_opcion.value);
    const respuesta_correcta = preguntas_array[numero_pregunta].correct;

    if (pregunta === respuesta_correcta) {
        resultado_respuesta.textContent = "¡Correcto! Has acertado la pregunta.";
        preguntas_correctas++;
    } else {
        resultado_respuesta.textContent = `Incorrecto. La respuesta correcta era: ${preguntas_array[numero_pregunta].options[respuesta_correcta]}.`;
        preguntas_incorrectas++;
    }

    boton_enviar.disabled = true;

    setTimeout(() => {
        boton_enviar.disabled = false;
        siguiente_pregunta();
    }, 5000);
});

/* Función para cargar la siguiente pregunta*/
function siguiente_pregunta() {
    numero_pregunta++; 
    if (numero_pregunta < preguntas_array.length) {
        mostrar_pregunta();
    } else {
        terminar_juego();
    }
}

/* Función para finalizar el juego y mostrar los resultados*/


function terminar_juego() {
    document.write(`
        <html>
        <head>
            <link rel="stylesheet" href="../estilos/style_trivial.css">
        </head>
        <body>
            <div id="menu" class="end-game-container">
                <h2>JUEGO FINALIZADO</h2>
                <p>Respuestas correctas: <span class="correct-count">${preguntas_correctas}</span></p>
                <p>Respuestas incorrectas: <span class="incorrect-count">${preguntas_incorrectas}</span></p>
                <a href="../index.html">
                    <button class="menu-btn">Volver al menú</button>
                </a>
            </div>
        </body>
        </html>
    `);
}

/* Cargar la primera pregunta al iniciar*/
mostrar_pregunta();