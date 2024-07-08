<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/evento.php';

$form = new es\ucm\fdi\aw\Evento\FormularioCalendarioEvento(); 
$htmlFormEvento = $form->gestiona();

$tituloPagina = 'Eventos';
$contenidoPrincipal = '';
$contenidoEvento = '';

$contenidoPrincipal .= <<<EOS
<h2> Todos los eventos </h2>
EOS;
$contenidoPrincipal .= listaEventos();

$contenidoEvento = <<<EOS
<h2>Selecciona la fecha</h2>
$htmlFormEvento
EOS;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaEventos.php';