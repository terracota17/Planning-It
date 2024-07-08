<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/estilo.css" />
    <link rel="stylesheet" type="text/css" href="../css/all.min.css" />
    <title><?= $tituloPagina ?></title>
    <script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../js/general.js"></script>
    <script type="text/javascript" src="../js/reload.js"></script>
</head>
<body>
    <div id="contenedor">
    <?php
        require_once __DIR__.'/../comun/cabeceraMensaje.php';
    ?>
    <main>
        <ul class="sidebar">
            <?= $contenidoPrincipal ?>		
        </ul>
        <article class ="mensaje">
            <?= $contenidoMensaje ?>		
        </article>
	</main>
    </div>
</body>
</html>