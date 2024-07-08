<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/foro.php';

$form = new es\ucm\fdi\aw\Foro\FormularioForo();
$htmlFormForo = $form->gestiona();

$tituloPagina = 'Foros';
$contenidoPrincipal = '';
$contenidoForo = '';

$contenidoPrincipal .= <<<EOS
<h2> Todos los foros </h2>
EOS;
$contenidoPrincipal .= listaForos();

$contenidoForo = <<<EOS
<h2>Crear un Foro</h2>
EOS;
if( isset($_SESSION['login'])  &&  $_SESSION['login'] === true){
    $contenidoForo .= $htmlFormForo;
}
else{
    $contenidoForo .=  "<p>Inicia sesion para crear un foro</p>";
}

require_once __DIR__.'/../includes/vistas/plantillas/plantillaForo.php';