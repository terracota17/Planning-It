<?php
    /*Lista todas las noticias */
    require_once('../includes/config.php');
    require ('../includes/vistas/helpers/noticia.php');
   
    $tituloPagina = 'Noticias';
    
    $contenidoPrincipal = <<<EOS
    <h2>Noticias</h2>
    EOS;
    $contenidoPrincipal .= listaNoticias();
    $contenidoNoticia = '';

    require ('../includes/vistas/plantillas/plantillaNoticias.php');
?>