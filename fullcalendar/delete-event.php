<?php
    require_once "../includes/config.php";
    
    use es\ucm\fdi\aw\Evento\Evento as Evento;
    use es\ucm\fdi\aw\Calendario as Calendario;
   
  
    $idTLBEvent= $_POST['id'];

    $idEvento = Evento::buscarTBLEventPorId($idTLBEvent);

    //Evento::borraEvento($idEvento);

    Calendario::eliminarEvent($idTLBEvent);

    header('Location: index.php');
?>