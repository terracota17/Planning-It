<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';

  $idEvento= filter_input(INPUT_POST,'idEvento',FILTER_SANITIZE_NUMBER_INT);
  es\ucm\fdi\aw\Evento\Evento::borraEvento($idEvento);
  header('Location: listarEventos.php');
?>