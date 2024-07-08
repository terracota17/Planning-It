<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';

  $idNotificacion= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
  es\ucm\fdi\aw\Notificacion\Notificacion::borraNotificacion($idNotificacion);
  
  header('Location: listarNotificaciones.php');
  exit();
?>