<?php

abstract class ZapatilleriaDB {
    private static $server = 'localhost';
    private static $db = 'zapatilleria';
    private static $user = 'alumno';
    private static $password = '1234';

    public static function connectDB() {
        try {
            // Se establece una conexión con la base de datos utilizando PDO
            $connection = new PDO("mysql:host=" . self::$server . ";dbname=" . self::$db . ";charset=utf8", self::$user, self::$password);
            
            // Se establece el modo de manejo de errores como excepciones para una mejor gestión de errores
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Si hay un error en la conexión, se muestra un mensaje de error y se termina el script
            echo "No se ha podido establecer conexión con el servidor de bases de datos.<br>";
            die("Error: " . $e->getMessage());
        }

        // Se devuelve la conexión establecida
        return $connection;
    }
}
?>
