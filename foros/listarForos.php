<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/foro.php';

    $tituloPagina = 'Foros';
    $contenidoPrincipal = '';
    $contenidoForo = '';
 
    $contenidoPrincipal .= <<<EOS
    <h2> Todos los foros </h2>
    EOS;
    $contenidoPrincipal .= listaForos();
    if(isset($_SESSION['id'])){
        $contenidoForo = <<<EOS
        <div>
            <button id="agregar" onclick="location.href='CrearForo.php'" type="button"><img class = "botonMas" src= ../img/mas.png></button>
        </div>
        EOS;    
    }
    else {
        $contenidoForo = '<p> Inicia sesion para crear un foro </p>';
    }

    require_once __DIR__.'/../includes/vistas/plantillas/plantillaForo.php';
?>