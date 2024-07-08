<?php
    use es\ucm\fdi\aw\Noticia\Noticia as Noticia;
    require_once __DIR__.'/includes/config.php';

    $titulo = $_REQUEST["titulo"];

    $noticia = Noticia::buscarNoticia($titulo);

    if ($noticia) {
        echo "existe";
    } 
    else {
        echo "disponible";
    }
?>