<?php
    require_once "../includes/config.php";
    require_once __DIR__.'/../includes/utils.php';

    $conn = es\ucm\fdi\aw\Aplicacion::getInstance()->getConexionBd();

    $title = isset($_POST['title']) ? $_POST['title'] : "";
    $start = isset($_POST['start']) ? $_POST['start'] : "";
    $end = isset($_POST['end']) ? $_POST['end'] : "";
    $idEvento = isset($_POST['idEvento']) ? $_POST['idEvento'] : "";

    es\ucm\fdi\aw\Calendario::añadirEvent($title, $start, $end, $idEvento);
?>
