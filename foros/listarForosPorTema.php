<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/foro.php';

    $form = new es\ucm\fdi\aw\Foro\FormularioOrdenarPorTema(); 
    $htmlFormForo = $form->gestiona();

    $tema = filter_input(INPUT_GET,'tema',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $tituloPagina = 'Foros';
    $contenidoPrincipal = '';

    $contenidoPrincipal = <<<EOS
    <h2>Todos los foros por tema</h2>
    EOS;
    $contenidoPrincipal .= listaForosPorTema($tema);

    $contenidoForo = <<<EOS
    <h2>Selecciona el tema</h2>
    $htmlFormForo
    EOS;
    
    require_once __DIR__.'/../includes/vistas/plantillas/plantillaForo.php';
?>
