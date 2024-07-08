<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/foro.php';

    $form = new es\ucm\fdi\aw\Foro\FormularioOrdenarPorFecha(); 
    $htmlFormForo = $form->gestiona();

    $fecha = filter_input(INPUT_GET,'fecha',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $tituloPagina = 'Foros';
    $contenidoPrincipal = '';

    $contenidoPrincipal = <<<EOS
    <h2>Todos los foros por fecha</h2>
    EOS;
    $contenidoPrincipal .= listaForosPorFecha($fecha);

    $contenidoForo = <<<EOS
    <h2>Selecciona la fecha</h2>
    $htmlFormForo
    EOS;
    
    require_once __DIR__.'/../includes/vistas/plantillas/plantillaForo.php';
?>
