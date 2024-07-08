<?php
    /*Lista todos los eventos */
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/evento.php';

    $form = new es\ucm\fdi\aw\Evento\FormularioCalendarioEvento(); 
    $htmlFormEvento = $form->gestiona();

    $fecha = filter_input(INPUT_GET,'fecha',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $tituloPagina = 'Eventos';
    $contenidoPrincipal = '';
    $contenidoEvento = '';

    $contenidoPrincipal = <<<EOS
    <h2>Todos los eventos por fecha</h2>
    EOS;
    $contenidoPrincipal .= listaEventosPorFecha($fecha);

    $contenidoEvento = <<<EOS
    <h2>Selecciona la fecha</h2>
    $htmlFormEvento
    EOS;
    
    require_once __DIR__.'/../includes/vistas/plantillas/plantillaEventos.php';
?>
