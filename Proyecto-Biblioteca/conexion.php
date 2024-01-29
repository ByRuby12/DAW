<?php
$servername = "localhost";
$username = "alumno"; //clase es --> alumno
$password = "1234";
$database = "alumno"; //clase es --> alumno

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

?>
