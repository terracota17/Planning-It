<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/estilo.css" />
    <link rel="stylesheet" type="text/css" href="../css/all.min.css" />
    <script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
	<script type="text/javascript" src="../js/general.js"></script>
        <title><?= $tituloPagina ?></title>
</head>
<body>
    
    <div id="contenedor">
        <?php
            require_once __DIR__.'/../comun/cabeceraArea.php';        
        ?>
        <main>
            <article class="menup">
                <?php require_once __DIR__.'/../../../personal/menuPersonal.php';?>
                <?= $contenidoPrincipal ?>	
            </article>  
            <article class="ap1">
                <?= $contenidoNota1 ?>
            </article>
            <article class="ap2">
                <?= $contenidoNota2 ?>
            </article>

            <article class="ap3">
                <?= $contenidoNota3 ?>
            </article>
        </main>
    <div>   
</body>
</html>