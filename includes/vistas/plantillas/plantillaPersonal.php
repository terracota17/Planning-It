<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/estilo.css" />
    <link rel="stylesheet" type="text/css" href="../css/all.min.css" />
    <title><?= $tituloPagina ?></title>
</head>
<body>
    <div id="contenedor">
        <?php
            require_once __DIR__.'/../comun/cabeceraArea.php';        
        ?>
        <main>
            <article class="menup">
                <?= $contenidoPrincipal ?>	
            </article>
        </main>
    <div>   
</body>
</html>