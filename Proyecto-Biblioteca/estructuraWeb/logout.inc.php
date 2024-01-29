<section>
    
    <?php 
        //eliminamos las variables de sesion 
        session_unset();
        //elimnamos la sesion
        session_destroy();
        //redireccionamos a index
        header("Location: ".$_SERVER["PHP_SELF"]."");

    ?>
</section>