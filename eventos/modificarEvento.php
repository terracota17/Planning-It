<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/evento.php';

$idEvento= filter_input(INPUT_POST,'idEvento',FILTER_SANITIZE_NUMBER_INT);

$form = new es\ucm\fdi\aw\Evento\FormularioEvento($idEvento);
$htmlFormEvento = $form->gestiona();

$tituloPagina = 'Eventos';
$contenidoPrincipal = ''; 
$contenidoEvento = '';

$contenidoPrincipal = <<<EOS
<h2>Mis eventos</h2>
EOS;
if( isset($_SESSION['login'])  &&  $_SESSION['login'] === true){
    $contenidoPrincipal .= listaEventos($_SESSION['id']);
}
else{
    $contenidoPrincipal .=  "<p>Inicia sesion para ver tus eventos</p>";
};

$contenidoEvento = <<<EOS
<h2>Modifica aquí</h2>
$htmlFormEvento
EOS;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaEventos.php';
