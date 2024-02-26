<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tomas Cano</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #cfcfcf;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
        
        h1 {
            margin: 20px 0; /* Añadido un margen top y bottom */
            font-size: 36px;
            text-align: center; /* Centrar el texto */
        }

        a.boton-crear {
            display: inline-block;
            margin: 10px 0;
            padding: 15px 30px; /* Aumentado el padding para mayor prominencia */
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 8px; /* Aumentado el radio del borde para esquinas redondeadas */
            transition: background-color 0.3s ease;
        }

        a.boton-crear:hover {
            background-color: #267bb9; /* Cambiando el color al pasar el ratón */
        }

        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #ccc;
        }

        .zapatilla-card {
            max-width: 800px;
            margin: 20px auto;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .zapatilla-card:hover {
            transform: translateY(-5px);
        }

        .zapatilla-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #ffffff;
            width: 1000px;
            height: 350px;
        }

        .zapatilla-info {
            flex-grow: 1;
            padding: 20px;
        }

        h3 {
            color: #333;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            max-height: 300px;
        }

        p {
            color: #666;
            font-size: 18px;
            margin-bottom: 10px;
        }

        a.borrar {
            background-color: #3498db; /* Cambiado a un tono azul claro */
            color: #fff;
            padding: 10px 15px; /* Ajustado el padding para un aspecto más compacto */
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease, color 0.3s ease; /* Añadida transición para el cambio de color */
        }

        a.borrar:hover {
            background-color: #2980b9; /* Cambiado a un tono azul oscuro al pasar el ratón */
            color: #fff;
        }


        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0px 10px rgb(183, 183, 183);
            margin-bottom: 10px;
            max-height: 300px;
            transition: transform 0.3s ease;
        }

        img:hover {
            transform: scale(1.05);
        }

        .contenedor {
            background-color: #d8f8ff;
            width: 1111px;
        }

    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Tienda de Zapatillas de Tomas Cano</h1>
        <a class="boton-crear" href="<?= $ruta; ?>/Zapatilla">Nueva zapatilla</a>
        <hr>
        <?php
        foreach ($data['zapatillas'] as $zapatilla) {
        ?>
            <div class="zapatilla-card">
                <div class="zapatilla-container">
                    <img src="<?= "View/images/" . $zapatilla->getImagen(); ?>" alt="<?= $zapatilla->getModelo(); ?>">
                    <div class="zapatilla-info">
                        <h3><?= $zapatilla->getModelo(); ?></h3>
                        <p><?= $zapatilla->getDescripcion(); ?></p>
                        <a class="borrar" href="<?= $ruta . "/BorraZapatilla/" . $zapatilla->getId(); ?>">Borrar</a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</body>
</html>
