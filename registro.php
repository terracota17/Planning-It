<?php
require_once __DIR__.'/includes/config.php';

$register = new es\ucm\fdi\aw\Usuario\FormularioRegistro();
$html = $register->gestiona();

$tituloPagina = 'Registro';
$contenidoPrincipal = <<<EOS
$html
EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaAcceso.php';
