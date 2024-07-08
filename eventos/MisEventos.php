<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/evento.php';

    $tituloPagina = 'Eventos';
    $contenidoPrincipal = '';
    $contenidoEvento = '';

    
    $contenidoPrincipal = <<<EOS
    <h2>Mis eventos</h2>
    EOS;
    if( isset($_SESSION['login'])  &&  $_SESSION['login'] === true){
        $contenidoPrincipal .= listaEventos($_SESSION['id']);
    }
    else{
        $contenidoPrincipal .=  "<p>Inicia sesion para ver tus eventos</p>";
    };
    
    require_once __DIR__.'/../includes/vistas/plantillas/plantillaEventos.php';
?>