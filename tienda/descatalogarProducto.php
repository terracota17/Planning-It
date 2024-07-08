<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';

  $idProducto= filter_input(INPUT_POST,'idProducto',FILTER_SANITIZE_NUMBER_INT);
  
  es\ucm\fdi\aw\Producto\Producto::descatalogaProducto($idProducto);
  header('Location: gestionarProductos.php');
?>