<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';

  $idEvento= filter_input(INPUT_POST,'idEvento',FILTER_SANITIZE_NUMBER_INT);
  $idUsuario= filter_input(INPUT_POST,'idUsuario',FILTER_SANITIZE_NUMBER_INT);
  es\ucm\fdi\aw\Participantes::eliminarParticipante($idUsuario, $idEvento);
  $evento = es\ucm\fdi\aw\Evento\Evento::buscarEventoPorId($idEvento);
  if($evento->getIdUsuario() !== $_SESSION['id']){
    es\ucm\fdi\aw\Calendario::eliminarEventParticipacion($idEvento, $idUsuario);

  }
  header('Location: listarEventos.php');
?>