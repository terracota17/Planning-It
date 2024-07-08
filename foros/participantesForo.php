<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/foro.php';

$idForo= filter_input(INPUT_POST,'idForo',FILTER_SANITIZE_NUMBER_INT);

$tituloPagina = 'Mensajes Foro';
$contenidoPrincipal = '';
$contenidoForo = '';

$contenidoPrincipal .= <<<EOS
<h2> Todos los foros </h2>
EOS;
$contenidoPrincipal .= listaForos();
$contenidoForo .= visualizaParticipantes($idForo);

require_once __DIR__.'/../includes/vistas/plantillas/plantillaForo.php';