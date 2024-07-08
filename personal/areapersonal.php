<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/menu.php';

    $tituloPagina = 'Area Personal';
    
    $contenidoNota1 = '';
    $contenidoNota2 = '';
    $contenidoNota3 = '';
    
    $contenidoNota1 = <<<EOS
    <a class="boton" href="CrearNota.php"><img class = "botonMas" src = "../img/mas.png" ></img></a>
    EOS;
    
    //$contenidoNota3 .= fullcalendar();

    require_once("MisNotas.php");
    require_once __DIR__.'/../includes/vistas/plantillas/plantillaAreaPersonal.php';
?>
