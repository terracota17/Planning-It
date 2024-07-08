<?php
require_once __DIR__.'/../includes/config.php';
$idNota= filter_input(INPUT_POST,'idNota',FILTER_SANITIZE_NUMBER_INT);

$form = new es\ucm\fdi\aw\Nota\FormularioActualizarNotas($idNota);
$htmlFormEvento = $form->gestiona();

$tituloPagina = 'Actualizar Nota';

$contenidoNota1 = <<<EOS
<h1>Actualizar Nota</h1>
$htmlFormEvento
EOS;

$contenidoNota2 = '';

require_once __DIR__.'/../includes/vistas/plantillas/plantillaAreaPersonal.php';