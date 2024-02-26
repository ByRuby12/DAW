<?php
// Incluimos el archivo que contiene la definición de la clase Zapatilla
require_once '../Model/Zapatilla.php';

// Obtenemos la URL de la solicitud actual y la dividimos en partes usando el delimitador "/"
$arrBasename = explode("/", $_SERVER["REQUEST_URI"]);

// Reconstruimos la ruta base de la aplicación utilizando los elementos relevantes del array $arrBasename
$ruta = "/" . $arrBasename[1] . "/" . $arrBasename[2];

// Obtenemos todas las zapatillas desde la base de datos y las asignamos al arreglo $data['zapatillas']
$data['zapatillas'] = Zapatilla::getZapatillas();

// Incluimos la vista listado.php para mostrar el listado de zapatillas
include "../View/listado.php";
?>
