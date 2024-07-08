<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/foro.php';

$idForo= filter_input(INPUT_GET,'idForo',FILTER_SANITIZE_NUMBER_INT);
$accesoNotificacion =  filter_input(INPUT_GET,'acesso',FILTER_SANITIZE_NUMBER_INT);

$form = new es\ucm\fdi\aw\Foro\FormularioRespuestasForo($idForo);

$htmlFormMensaje = $form->gestiona();
 
$tituloPagina = 'Mensajes Foro';
$contenidoPrincipal = '';
$contenidoForo = '';

$contenidoPrincipal .= <<<EOS
<h2> Todos los foros </h2>
EOS;
$contenidoPrincipal .= listaForos();
$contenidoForo .= listaMensajesForo($idForo, $accesoNotificacion);
$contenidoForo .= $htmlFormMensaje;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaForo.php';