<?php
// Incluimos el archivo que contiene la definición de la clase Zapatilla
require_once '../Model/Zapatilla.php';

// Obtenemos la URL de la solicitud actual y la dividimos en partes usando el delimitador "/"
$arrBasename = explode("/", $_SERVER["REQUEST_URI"]);

// Reconstruimos la ruta base de la aplicación utilizando los elementos relevantes del array $arrBasename
$ruta = "/" . $arrBasename[1] . "/" . $arrBasename[2];

// Movemos el archivo de imagen subido al directorio de imágenes de la vista
move_uploaded_file($_FILES["imagen"]["tmp_name"], "../View/images/" . $_FILES["imagen"]["name"]);

// Creamos una nueva instancia de la clase Zapatilla con los datos del formulario y la insertamos en la base de datos
$zapatillaAux = new Zapatilla("", $_POST['modelo'], $_FILES["imagen"]["name"], $_POST['descripcion']);
$zapatillaAux->insert();

// Redirigimos al usuario de vuelta a la página principal
header("Location: " . $ruta);
?>
