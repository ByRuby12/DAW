<?php
// Incluimos el archivo que contiene la definición de la clase Zapatilla
require_once "../Model/Zapatilla.php";

// Obtenemos la URL de la solicitud actual y la dividimos en partes usando el delimitador "/"
$arrBasename = explode("/", $_SERVER["REQUEST_URI"]);

// Reconstruimos la ruta base de la aplicación utilizando los elementos relevantes del array $arrBasename
$ruta = "/" . $arrBasename[1] . "/" . $arrBasename[2];

// Obtenemos el ID de la zapatilla a eliminar desde la solicitud GET
$id = $_GET["id"];

// Creamos una nueva instancia de la clase Zapatilla con el ID proporcionado y la eliminamos de la base de datos
$zapatillaAux = new Zapatilla($id);
$zapatillaAux->delete();

// Redirigimos al usuario de vuelta a la página principal
header("Location: " . $ruta);
?>
