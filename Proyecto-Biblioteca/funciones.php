<?php
/*--------------------------------------ENLACE DE CONEXION-------------------------------------------------*/

require_once("conexion.php");

/*--------------------------------------REGISTRO Y LOGIN-------------------------------------------------*/

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verificarInicioSesion($usuario, $password) {
    global $conn;

    $stmt = $conn->prepare("SELECT id, usuario, contrasena, rol FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($dbId, $dbUsuario, $dbContrasena, $rol);

    if ($stmt->fetch() && password_verify($password, $dbContrasena)) {
        $userData = [
            'id' => $dbId,
            'usuario' => $dbUsuario,
            'contrasena' => $dbContrasena,
            'rol' => $rol
        ];
        return $userData;
    } else {
        return false;
    }

    $stmt->close();
}

function registrarUsuario($nombre, $apellido1, $apellido2, $correo, $usuario, $contrasena, $rol) {
    global $conn;

    $contrasena = hashPassword($contrasena);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido1, apellido2, correo, usuario, contrasena, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nombre, $apellido1, $apellido2, $correo, $usuario, $contrasena, $rol);

    return $stmt->execute();

    $stmt->close();
}

/*--------------------------------------PERFIL USUARIO-------------------------------------------------*/

function obtenerDatosPerfil($usuario) {
    global $conn;

    $stmt = $conn->prepare("SELECT nombre, apellido1, apellido2, correo, usuario, contrasena FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $stmt->bind_result($nombre, $apellido1, $apellido2, $correo, $usuario, $contrasena);

    if ($stmt->fetch()) {
        return [
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2,
            'correo' => $correo,
            'usuario' => $usuario,
            'contrasena' => $contrasena,
        ];
    } else {
        return false;
    }

    $stmt->close();
}

function actualizarPerfil($usuario, $nombre, $apellido1, $apellido2, $correo, $nuevoUsuario, $nuevaContrasena) {
    global $conn;

    if (!empty($nuevaContrasena)) {
        $nuevaContrasena = hashPassword($nuevaContrasena);
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, apellido1=?, apellido2=?, correo=?, usuario=?, contrasena=? WHERE usuario=?");
        $stmt->bind_param("sssssss", $nombre, $apellido1, $apellido2, $correo, $nuevoUsuario, $nuevaContrasena, $usuario);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, apellido1=?, apellido2=?, correo=?, usuario=? WHERE usuario=?");
        $stmt->bind_param("ssssss", $nombre, $apellido1, $apellido2, $correo, $nuevoUsuario, $usuario);
    }

    return $stmt->execute();
}

/*--------------------------------------LIBROS USUARIO-------------------------------------------------*/

function obtenerLibrosDisponibles() {
    global $conn;
    $sql = "SELECT * FROM libro WHERE disponible = 1";
    $result = $conn->query($sql);

    $libros = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $libros[] = $row;
        }
    }

    return $libros;
}

/*--------------------------------------ALQUILAR LIBRO-------------------------------------------------*/

function alquilarLibro($idUsuario, $idLibro) {
    global $conn;

    // Calcular la fecha de finalización del préstamo (10 días desde hoy)
    $fechaPrestamo = date('Y-m-d');
    $fechaFinPrestamo = date('Y-m-d', strtotime('+10 days', strtotime($fechaPrestamo)));

    $stmt = $conn->prepare("INSERT INTO prestamo (id_usuario, id_libro, fin_prestamo) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $idUsuario, $idLibro, $fechaFinPrestamo);

    // Actualizar el libro para marcarlo como no disponible (disponible = 0)
    $stmt2 = $conn->prepare("UPDATE libro SET disponible = 0 WHERE id = ?");
    $stmt2->bind_param("i", $idLibro);

    if ($stmt->execute() && $stmt2->execute()) {
        return true;
    } else {
        return false;
    }

    $stmt->close();
    $stmt2->close();
}

function obtenerLibrosAlquilados($idUsuario) {
    global $conn;

    $sql = "SELECT p.id_usuario, p.id_libro, l.isbn, l.titulo, l.autor, l.editorial, p.fin_prestamo
            FROM prestamo AS p
            INNER JOIN libro AS l ON p.id_libro = l.id
            WHERE p.id_usuario = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();

    $result = $stmt->get_result();

    $librosAlquilados = array();

    while ($row = $result->fetch_assoc()) {
        $librosAlquilados[] = $row;
    }

    return $librosAlquilados;
}

function desalquilarLibro($idUsuario, $idLibro) {
    global $conn;

    // Realizar las operaciones necesarias para desalquilar un libro
    // Por ejemplo, eliminar el registro de préstamo y marcar el libro como disponible (disponible = 1)

    $stmt = $conn->prepare("DELETE FROM prestamo WHERE id_usuario = ? AND id_libro = ?");
    $stmt->bind_param("ii", $idUsuario, $idLibro);

    $stmt2 = $conn->prepare("UPDATE libro SET disponible = 1 WHERE id = ?");
    $stmt2->bind_param("i", $idLibro);

    if ($stmt->execute() && $stmt2->execute()) {
        return true;
    } else {
        return false;
    }
}

/*--------------------------------------FILTRADO DE USUARIO-------------------------------------------------*/

function obtenerTodosLosUsuarios() {
    global $conn;

    $sql = "SELECT id, nombre, apellido1, apellido2, correo, usuario, rol FROM usuarios";
    $result = $conn->query($sql);

    $usuarios = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
    }

    return $usuarios;
}

function obtenerUsuarioPorID($idUsuario) {
    global $conn;

    $stmt = $conn->prepare("SELECT id, nombre, apellido1, apellido2, correo, usuario, rol FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->bind_result($id, $nombre, $apellido1, $apellido2, $correo, $usuario, $rol);

    if ($stmt->fetch()) {
        return [
            'id' => $id,
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2,
            'correo' => $correo,
            'usuario' => $usuario,
            'rol' => $rol,
        ];
    } else {
        return false;
    }

    $stmt->close();
}

/*--------------------------------------ACTUALIZAR USUARIO-------------------------------------------------*/

function actualizarUsuarioAdmin($idUsuario, $nombre, $apellido1, $apellido2, $correo, $usuario, $nuevaContrasena, $rol) {
    global $conn;

    if (!empty($nuevaContrasena)) {
        $nuevaContrasena = hashPassword($nuevaContrasena);
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, apellido1=?, apellido2=?, correo=?, usuario=?, contrasena=?, rol=? WHERE id=?");
        $stmt->bind_param("sssssssi", $nombre, $apellido1, $apellido2, $correo, $usuario, $nuevaContrasena, $rol, $idUsuario);
    } else {
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, apellido1=?, apellido2=?, correo=?, usuario=?, rol=? WHERE id=?");
        $stmt->bind_param("ssssssi", $nombre, $apellido1, $apellido2, $correo, $usuario, $rol, $idUsuario);
    }

    return $stmt->execute();
}

/*--------------------------------------CREAR USUARIO-------------------------------------------------*/

function crearUsuario($nombre, $apellido1, $apellido2, $correo, $usuario, $contrasena, $rol) {
    global $conn;

    $contrasenaHash = hashPassword($contrasena);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellido1, apellido2, correo, usuario, contrasena, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $nombre, $apellido1, $apellido2, $correo, $usuario, $contrasenaHash, $rol);

    return $stmt->execute();
}

/*--------------------------------------FILTRADO DE LIBRO-------------------------------------------------*/

function obtenerTodosLosLibros() {
    global $conn;

    $sql = "SELECT id, isbn, titulo, autor, editorial FROM libro";
    $result = $conn->query($sql);

    $libros = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $libros[] = $row;
        }
    }

    return $libros;
}

function obtenerLibroPorId($idLibro) {
    global $conn;

    $stmt = $conn->prepare("SELECT id, isbn, titulo, autor, editorial FROM libro WHERE id = ?");
    $stmt->bind_param("i", $idLibro);
    $stmt->execute();
    $stmt->bind_result($id, $isbn, $titulo, $autor, $editorial);

    if ($stmt->fetch()) {
        $libro = [
            'id' => $id,
            'isbn' => $isbn,
            'titulo' => $titulo,
            'autor' => $autor,
            'editorial' => $editorial,
        ];

        return $libro;
    } else {
        return false;
    }

    $stmt->close();
}

/*--------------------------------------ACTUALIZAR LIBRO-------------------------------------------------*/

function actualizarLibro($idLibro, $isbn, $titulo, $autor, $editorial) {
    global $conn;

    $stmt = $conn->prepare("UPDATE libro SET isbn=?, titulo=?, autor=?, editorial=? WHERE id=?");
    $stmt->bind_param("ssssi", $isbn, $titulo, $autor, $editorial, $idLibro);

    $result = $stmt->execute();

    $stmt->close();

    return $result;
}

/*--------------------------------------CREAR LIBRO-------------------------------------------------*/

function crearLibro($isbn, $titulo, $autor, $editorial) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO libro (isbn, titulo, autor, editorial) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $isbn, $titulo, $autor, $editorial);

    return $stmt->execute();
}

function isbnExistente($isbn) {
    global $conn;

    $stmt = $conn->prepare("SELECT id FROM libro WHERE isbn = ?");
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $stmt->store_result();

    return $stmt->num_rows > 0;
}

/*--------------------------------------FILTRADO DE PORESTAMOS-------------------------------------------------*/

function obtenerTodosLosPrestamos() {
    global $conn;

    $stmt = $conn->prepare("SELECT prestamo.id_usuario, prestamo.id_libro, libro.titulo, libro.autor, prestamo.fin_prestamo FROM prestamo JOIN libro ON prestamo.id_libro = libro.id");
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_all(MYSQLI_ASSOC);
}

function cancelarPrestamo($idUsuario, $idLibro) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM prestamo WHERE id_usuario = ? AND id_libro = ?");
    $stmt->bind_param("ii", $idUsuario, $idLibro);

    return $stmt->execute();
}

/*--------------------------------------ELIMINAR USUARIO-------------------------------------------------*/

function insertarUsuarioEliminado($usuario) {
    global $conn;

    $stmt = $conn->prepare("INSERT INTO usuarioseliminados (id, nombre, apellido1, apellido2, correo, usuario, contrasena, fecha_registro, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $usuario['id'], $usuario['nombre'], $usuario['apellido1'], $usuario['apellido2'], $usuario['correo'], $usuario['usuario'], $usuario['contrasena'], $usuario['fecha_registro'], $usuario['rol']);

    return $stmt->execute();
}

function eliminarUsuario($idUsuario) {
    global $conn;

    // Obtener los préstamos asociados al usuario
    $prestamos = obtenerLibrosAlquilados($idUsuario);

    // Cancelar cada préstamo antes de eliminar el usuario
    foreach ($prestamos as $prestamo) {
        $idLibro = $prestamo['id_libro'];
        cancelarPrestamo($idUsuario, $idLibro);
    }

    // Desactivar temporalmente restricciones de clave externa
    $conn->query("SET foreign_key_checks = 0");

    // Eliminar el usuario
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $idUsuario);
    $result = $stmt->execute();

    // Volver a activar restricciones de clave externa
    $conn->query("SET foreign_key_checks = 1");

    return $result;
}

/*----------------------------------RESTAURAR USUARIO----------------------------------------*/

function obtenerTodosLosUsuariosEliminados() {
    global $conn;

    $sql = "SELECT id, nombre, apellido1, apellido2, correo, usuario, rol FROM usuarioseliminados";
    $result = $conn->query($sql);

    $usuariosEliminados = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuariosEliminados[] = $row;
        }
    }

    return $usuariosEliminados;
}

function obtenerUsuarioEliminadoPorID($idUsuario) {
    global $conn;

    $stmt = $conn->prepare("SELECT id, nombre, apellido1, apellido2, correo, usuario, rol FROM usuarioseliminados WHERE id = ?");
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $stmt->bind_result($id, $nombre, $apellido1, $apellido2, $correo, $usuario, $rol);

    if ($stmt->fetch()) {
        return [
            'id' => $id,
            'nombre' => $nombre,
            'apellido1' => $apellido1,
            'apellido2' => $apellido2,
            'correo' => $correo,
            'usuario' => $usuario,
            'rol' => $rol,
        ];
    } else {
        return false;
    }

    $stmt->close();
}

function restaurarUsuario($usuarioRestaurar) {
    global $conn;

    // Desactivar temporalmente restricciones de clave externa
    $conn->query("SET foreign_key_checks = 0");

    // Insertar el usuario restaurado en la tabla de usuarios
    $stmt = $conn->prepare("INSERT INTO usuarios (id, nombre, apellido1, apellido2, correo, usuario, contrasena, fecha_registro, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $usuarioRestaurar['id'], $usuarioRestaurar['nombre'], $usuarioRestaurar['apellido1'], $usuarioRestaurar['apellido2'], $usuarioRestaurar['correo'], $usuarioRestaurar['usuario'], $usuarioRestaurar['contrasena'], $usuarioRestaurar['fecha_registro'], $usuarioRestaurar['rol']);
    $result = $stmt->execute();

    // Eliminar el usuario de la tabla de usuarios eliminados
    $stmt2 = $conn->prepare("DELETE FROM usuarioseliminados WHERE id = ?");
    $stmt2->bind_param("i", $usuarioRestaurar['id']);
    $result2 = $stmt2->execute();

    // Volver a activar restricciones de clave externa
    $conn->query("SET foreign_key_checks = 1");

    return $result && $result2;
}

/*--------------------------------------ELIMIAR LIBRO---------------------------------------------*/

function eliminarLibro($libroEliminar) {
    global $conn;

    // Desactivar temporalmente restricciones de clave externa
    $conn->query("SET foreign_key_checks = 0");

    // Insertar el libro eliminado en la tabla de libros eliminados
    $stmt = $conn->prepare("INSERT INTO libroseliminados (id, isbn, titulo, autor, editorial) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $libroEliminar['id'], $libroEliminar['isbn'], $libroEliminar['titulo'], $libroEliminar['autor'], $libroEliminar['editorial']);
    $result = $stmt->execute();

    // Eliminar el libro de la tabla de libros
    $stmt2 = $conn->prepare("DELETE FROM libro WHERE id = ?");
    $stmt2->bind_param("i", $libroEliminar['id']);
    $result2 = $stmt2->execute();

    // Volver a activar restricciones de clave externa
    $conn->query("SET foreign_key_checks = 1");

    return $result && $result2;
}

function obtenerTodosLosLibrosAdmin() {
    global $conn;

    $sql = "SELECT id, isbn, titulo, autor, editorial, disponible FROM libro";
    $result = $conn->query($sql);

    $libros = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Asegúrate de que el campo "disponible" esté presente en el resultado
            $row['disponible'] = isset($row['disponible']) ? $row['disponible'] : null;
            $libros[] = $row;
        }
    }

    return $libros;
}

/*--------------------------------------RESTARUAR LIBRO---------------------------------------------*/

function obtenerLibrosEliminados() {
    global $conn;

    $sql = "SELECT * FROM libroseliminados";
    $result = $conn->query($sql);

    $librosEliminados = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $librosEliminados[] = $row;
        }
    }

    return $librosEliminados;
}

function restaurarLibro($idLibro) {
    global $conn;

    // Obtener los datos del libro eliminado
    $libroEliminado = obtenerLibroEliminadoPorId($idLibro);

    if ($libroEliminado) {
        // Insertar el libro en la tabla de libros
        $stmt = $conn->prepare("INSERT INTO libro (id, isbn, titulo, autor, editorial) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $libroEliminado['id'], $libroEliminado['isbn'], $libroEliminado['titulo'], $libroEliminado['autor'], $libroEliminado['editorial']);
        $insertResult = $stmt->execute();

        // Eliminar el libro de la tabla de libroseliminados
        $stmt2 = $conn->prepare("DELETE FROM libroseliminados WHERE id = ?");
        $stmt2->bind_param("i", $idLibro);
        $deleteResult = $stmt2->execute();

        $stmt->close();
        $stmt2->close();

        return $insertResult && $deleteResult;
    }

    return false;
}

function obtenerLibroEliminadoPorId($idLibro) {
    global $conn;

    $stmt = $conn->prepare("SELECT * FROM libroseliminados WHERE id = ?");
    $stmt->bind_param("i", $idLibro);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
}

/*----------------------------------------FILTRADOR LIBROS---------------------------------------*/

function buscarLibros($isbn, $titulo, $autor, $editorial) {
    global $conn;

    $sql = "SELECT * FROM libro WHERE 1=1";
    $params = array();

    if (!empty($isbn)) {
        $sql .= " AND isbn LIKE ?";
        $params[] = "%" . $isbn . "%";
    }

    if (!empty($titulo)) {
        $sql .= " AND titulo LIKE ?";
        $params[] = "%" . $titulo . "%";
    }

    if (!empty($autor)) {
        $sql .= " AND autor LIKE ?";
        $params[] = "%" . $autor . "%";
    }

    if (!empty($editorial)) {
        $sql .= " AND editorial LIKE ?";
        $params[] = "%" . $editorial . "%";
    }

    $stmt = $conn->prepare($sql);

    // Bind parameters
    if (count($params) > 0) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $librosFiltrados = array();

    while ($row = $result->fetch_assoc()) {
        $librosFiltrados[] = $row;
    }

    $stmt->close();

    return $librosFiltrados;
}

function limpiarEntrada($entrada) {
    $entrada = trim($entrada); // Elimina espacios en blanco al principio y al final
    $entrada = stripslashes($entrada); // Elimina barras invertidas
    $entrada = htmlspecialchars($entrada); // Convierte caracteres especiales a entidades HTML

    return $entrada;
}

?>