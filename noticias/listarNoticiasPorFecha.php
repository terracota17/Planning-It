<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/noticia.php';

    $form = new es\ucm\fdi\aw\Noticia\FormularioOrdenarPorFecha(); 
    $htmlFormNoticia = $form->gestiona();

    $fecha = filter_input(INPUT_GET,'fecha',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $tituloPagina = 'Noticias';
    $contenidoPrincipal = '';
    $contenidoNoticia = '';

    $contenidoPrincipal = <<<EOS
    <h2>Noticias</h2>
    EOS;
    $contenidoPrincipal .= listaNoticiasPorFecha($fecha);

    $contenidoNoticia = <<<EOS
    <h2>Selecciona la fecha</h2>
    $htmlFormNoticia
    EOS;
    
    require_once __DIR__.'/../includes/vistas/plantillas/plantillaNoticias.php';
?>