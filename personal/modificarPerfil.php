<?php
require_once __DIR__.'/../includes/config.php';

$form = new es\ucm\fdi\aw\Usuario\FormularioEditarPerfil();
$htmlFormEvento = $form->gestiona();

$tituloPagina = 'Editar perfil';

$contenidoPrincipal = <<<EOS
<h1>Editar Perfil</h1>
$htmlFormEvento
EOS;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaEditar.php';