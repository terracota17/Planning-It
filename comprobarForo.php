<?php
    use es\ucm\fdi\aw\Foro\Foro as Foro;
    require_once __DIR__.'/includes/config.php';

    $tema = $_REQUEST["tema"];

    $foro = Foro::buscarForo($tema);

    if ($foro) {
        echo "existe";
    } 
    else {
        echo "disponible";
    }
?>