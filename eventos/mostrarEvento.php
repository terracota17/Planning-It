<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/evento.php';

$idEvento= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

$tituloPagina = 'Eventos';
$contenidoPrincipal = '';
$contenidoEvento = '';

$contenidoPrincipal .= <<<EOS
<h2> Todos los eventos </h2>
EOS;
$contenidoPrincipal .= listaEventos();

$contenidoEvento .= visualizaEventoCompleto($idEvento);

require_once __DIR__.'/../includes/vistas/plantillas/plantillaEventos.php';