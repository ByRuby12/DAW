<nav class="menu">
    <ul>

        <!-- PARTE DE USUARIOS ------------------------------------------------------------------>

        <?php if(isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])): ?>
            <li class="color"> --Menu User-- </li>
        <?php endif; ?>

        <?php if(isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=perfil"; ?>">Perfil</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=buscador"; ?>">Buscador</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=libros"; ?>">Libros</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=prestamos"; ?>">Prestamos</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=contacto"; ?>">Contacto</a></li>
        <?php endif; ?>


        <!-- PARTE DE ADMINISTRACIÓN ------------------------------------------------------------------>

        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li class="color"> --Menu Admin-- </li>
        <?php endif; ?>

        <!-- USUARIO DE ADMINISTRACIÓN ------------------------------------------------------------------>

        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=crearusuarios"; ?>">Crear Usuarios</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=usuarios"; ?>">Editar Usuarios</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=eliminarusuario"; ?>">Eliminar Usuario</a></li>
        <?php endif; ?>


        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=restaurarusuario"; ?>">Restaurar Usuario</a></li>
        <?php endif; ?>

        <!-- LIBRO DE ADMINISTRACIÓN ------------------------------------------------------------------>

        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=crearlibros"; ?>">Crear Libros</a></li>
        <?php endif; ?>
        
        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=editarlibros"; ?>">Editar Libros</a></li>
        <?php endif; ?>

        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=eliminarlibro"; ?>">Eliminar Libro</a></li>
        <?php endif; ?>


        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=restaurarlibro"; ?>">Restaurar Libro</a></li>
        <?php endif; ?>

        <!-- PRESTAMOS DE ADMINISTRACIÓN ------------------------------------------------------------------>

        <?php if(isset($_SESSION["rol"]) && !empty($_SESSION["usuario"]) && $_SESSION["rol"]=="admin"): ?>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]. "?ruta=editarprestamo"; ?>">Editar Prestamos</a></li>
        <?php endif; ?>

        <!-- CERRAR SESION ACCESO RAPIDO ------------------------------------------------------------------>
    </ul>
    <?php if(isset($_SESSION["usuario"]) && !empty($_SESSION["usuario"])): ?>
            <button class="logoutmenu"> <a href="<?php echo $_SERVER["PHP_SELF"]."?ruta=logout"; ?>"> Cerrar Sesión</button> </a>
    <?php endif; ?>

</nav>
