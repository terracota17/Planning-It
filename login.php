<?php
require_once __DIR__.'/includes/config.php';

$login = new es\ucm\fdi\aw\Usuario\FormularioLogin();
$html = $login->gestiona();

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS
$html
EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaAcceso.php';
