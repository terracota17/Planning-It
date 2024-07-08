<?php
  require_once __DIR__.'/../includes/config.php';
  require_once __DIR__.'/../includes/utils.php';
  require_once __DIR__.'/../includes/vistas/helpers/foro.php';

  use es\ucm\fdi\aw\Foro\MensajesForo as MensajesForo;

  $idMensajeForo = filter_input(INPUT_POST,'idMensajeForo',FILTER_SANITIZE_NUMBER_INT);
    
  $form = new es\ucm\fdi\aw\Foro\FormularioEditarMensajeForo($idMensajeForo);

  $htmlFormMensaje = $form->gestiona();

    $tituloPagina = 'Editar Mensaje Foro';
    $contenidoPrincipal = '';
    $contenidoForo = '';

    $contenidoPrincipal .= <<<EOS
    <h2> Editar Mensaje </h2>
    EOS; 
    $contenidoForo .= $htmlFormMensaje;

    require_once __DIR__.'/../includes/vistas/plantillas/plantillaForo.php';