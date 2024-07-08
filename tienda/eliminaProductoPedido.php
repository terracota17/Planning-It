<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';
  use es\ucm\fdi\aw\Pedido\Pedido as Pedido;
  $idProducto= filter_input(INPUT_POST,'idProducto',FILTER_SANITIZE_NUMBER_INT);
  $idPedido= filter_input(INPUT_POST,'idPedido',FILTER_SANITIZE_NUMBER_INT);
  Pedido::eliminaProducto($idPedido,$idProducto);
  $pedido = Pedido::buscaPedidoId($idPedido);
  if( Pedido::PedidoVacio($pedido)){
    header("Location:misCompras.php");
  }
  else{
  header("Location: verPedido.php?idPedido={ $idPedido}");
  }
?>