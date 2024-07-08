<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?></title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    <link rel="stylesheet" type="text/css" href="css/all.min.css" />
    <script type="text/javascript" src="../../../js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../../../js/registro.js"></script>
</head>
<body>
    <div id="contenedor">
    <?php
        require_once __DIR__.'/../comun/cabecera.php';
    ?>
    <main>
	    <article>
            <?= $contenidoPrincipal ?>		
        </article>
	</main>
    </div>
</body>
</html>