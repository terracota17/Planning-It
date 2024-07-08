<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/foro.php';

$form = new es\ucm\fdi\aw\Foro\FormularioOrdenarPorFecha(); 
$htmlFormForo = $form->gestiona();

$tituloPagina = 'Foros';
$contenidoPrincipal = '';
$contenidoForo = '';

$contenidoPrincipal .= <<<EOS
<h2> Todos los Foros </h2>
EOS;
$contenidoPrincipal .= listaForos();

$contenidoForo = <<<EOS
<h2>Selecciona la fecha</h2>
$htmlFormForo
EOS;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaForo.php';