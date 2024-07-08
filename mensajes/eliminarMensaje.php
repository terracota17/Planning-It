<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';

  $idmsg= filter_input(INPUT_POST,'idMensaje',FILTER_SANITIZE_NUMBER_INT);
  $idrem= filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
  es\ucm\fdi\aw\Mensaje\Mensaje::eliminarMensaje($idmsg, $idrem);
  header("Location: chat.php?id={$idrem}");
?>