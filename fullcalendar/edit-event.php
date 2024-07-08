<?php
    require_once "../includes/config.php";
    require_once __DIR__.'/../includes/utils.php';
    
    use es\ucm\fdi\aw\Evento\Evento as Evento;
    use es\ucm\fdi\aw\Calendario as Calendario;


    $idTLBEvent = $_POST['id'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    Calendario::editEvent($idTLBEvent, $start, $end);

    $idEvento = Evento::buscarTBLEventPorId($idTLBEvent);
    
    Evento::modificarFechaEventoPorId($start, $idEvento);

?>