<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';
  require_once __DIR__.'/../includes/vistas/helpers/foro.php';

 
  $idMensajeForo = filter_input(INPUT_POST,'idMensajeForo',FILTER_SANITIZE_NUMBER_INT);
  es\ucm\fdi\aw\Foro\MensajesForo::borraMensaje($idMensajeForo);
  
  header("Location:".$_SERVER['HTTP_REFERER']);
?>