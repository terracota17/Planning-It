<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';

  $idPedido= filter_input(INPUT_POST,'idPedido',FILTER_SANITIZE_NUMBER_INT);
  
  es\ucm\fdi\aw\Pedido\Pedido::borrarPedido($idPedido);
  header('Location: misCompras.php');
?>