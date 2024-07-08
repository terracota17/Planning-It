<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';

  $idNoticia= filter_input(INPUT_POST,'idNoticia',FILTER_SANITIZE_NUMBER_INT);
  es\ucm\fdi\aw\Noticia\Noticia::borraNoticia($idNoticia);
  header('Location: listarNoticias.php');
?>