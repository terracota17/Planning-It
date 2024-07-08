<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/evento.php';

$form = new es\ucm\fdi\aw\Evento\FormularioEvento();
$htmlFormEvento = $form->gestiona();

$tituloPagina = 'Eventos';
$contenidoPrincipal = '';
$contenidoEvento = '';

$contenidoPrincipal .= <<<EOS
<h2> Todos los eventos </h2>
EOS;
$contenidoPrincipal .= listaEventos();

$contenidoEvento = <<<EOS
<h2>Registro de evento</h2>
EOS;
if( isset($_SESSION['login'])  &&  $_SESSION['login'] === true){
    $contenidoEvento .= $htmlFormEvento;
}
else{
    $contenidoEvento .=  "<p>Inicia sesion para crear un evento</p>";
}

require_once __DIR__.'/../includes/vistas/plantillas/plantillaEventos.php';