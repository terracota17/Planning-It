<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/evento.php';

    $tituloPagina = 'Eventos';
    $contenidoPrincipal = '';
    $contenidoEvento = '';

    $contenidoPrincipal .= <<<EOS
    <h2> Todos los eventos </h2>
    EOS;
    $contenidoPrincipal .= listaEventos();
    

    require_once __DIR__.'/../includes/vistas/plantillas/plantillaEventos.php';
?>
