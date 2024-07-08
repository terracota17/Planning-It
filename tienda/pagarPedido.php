<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/utils.php';

$pago = new es\ucm\fdi\aw\Pedido\FormularioPago($_SESSION['id']);
$html = $pago->gestiona();
$contenidoPrincipal = '';
$tituloPagina = 'Pago';
$contenidoPrincipal .= $html;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaTienda.php';
