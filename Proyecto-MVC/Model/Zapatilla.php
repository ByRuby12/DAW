<?php
require_once 'ZapatilleriaDB.php';

class Zapatilla {
    private $id;
    private $modelo;
    private $imagen;
    private $descripcion;

    public function __construct($id, $modelo = "", $imagen = "", $descripcion = "") {
        // Constructor de la clase Zapatilla, inicializa sus propiedades
        $this->id = $id;
        $this->modelo = $modelo;
        $this->imagen = $imagen;
        $this->descripcion = $descripcion;
    }

    public function getId() {
        return $this->id;
    }

    public function getModelo() {
        return $this->modelo;
    }

    public function getImagen() {
        return $this->imagen;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function insert() {
        // Método para insertar una nueva zapatilla en la base de datos
        $conexion = ZapatilleriaDB::connectDB();
        $insercion = "INSERT INTO zapatilla (modelo, imagen, descripcion) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($insercion);
        $stmt->execute([$this->modelo, $this->imagen, $this->descripcion]);
    }

    public function delete() {
        // Método para eliminar una zapatilla de la base de datos
        $conexion = ZapatilleriaDB::connectDB();
        $borrado = "DELETE FROM zapatilla WHERE id=?";
        $stmt = $conexion->prepare($borrado);
        $stmt->execute([$this->id]);
    }

    public static function getZapatillas() {
        // Método para obtener todas las zapatillas almacenadas en la base de datos
        $conexion = ZapatilleriaDB::connectDB();
        $seleccion = "SELECT id, modelo, imagen, descripcion FROM zapatilla";
        $consulta = $conexion->query($seleccion);

        $zapatillas = [];

        // Se recorren los resultados y se crean instancias de Zapatilla para cada uno
        while ($registro = $consulta->fetchObject()) {
            $zapatillas[] = new Zapatilla($registro->id, $registro->modelo, $registro->imagen, $registro->descripcion);
        }

        // Se devuelve un array con todas las zapatillas
        return $zapatillas;
    }

    public static function getZapatillaById($id) {
        // Método para obtener una zapatilla específica por su ID
        $conexion = ZapatilleriaDB::connectDB();
        $seleccion = "SELECT id, modelo, imagen, descripcion FROM zapatilla WHERE id=?";
        $stmt = $conexion->prepare($seleccion);
        $stmt->execute([$id]);
        $registro = $stmt->fetchObject();
        $zapatilla = new Zapatilla($registro->id, $registro->modelo, $registro->imagen, $registro->descripcion);

        // Se devuelve la zapatilla encontrada
        return $zapatilla;
    }
}
?>
