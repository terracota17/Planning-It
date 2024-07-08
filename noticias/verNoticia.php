<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/noticia.php';
   
    $tituloPagina = 'Noticias';
    $contenidoPrincipal = '';
    $contenidoPrincipal = <<<EOS
    <h2>Noticias</h2>
    EOS;
    $contenidoPrincipal .= listaNoticias();
    $contenidoNoticia = '';

    $idNoticia= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $contenidoNoticia .= verNoticia($idNoticia);

    require_once __DIR__.'/../includes/vistas/plantillas/plantillaNoticias.php';
?>