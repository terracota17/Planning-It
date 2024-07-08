<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/foro.php';

$idForo = filter_input(INPUT_POST, 'idForo', FILTER_SANITIZE_NUMBER_INT);

$form = new es\ucm\fdi\aw\Foro\FormularioForo($idForo);
$htmlFormForo = $form->gestiona();

$tituloPagina = 'Foros';
$contenidoPrincipal = '';
$contenidoForo = '';

$contenidoPrincipal = <<<EOS
<h2>Foros</h2>
EOS;
if( isset($_SESSION['login'])  &&  $_SESSION['login'] === true){
    $contenidoPrincipal .= listaForos();
}else{
    $contenidoPrincipal .= "<p>Inicia sesion para modificar</p>";
};

$contenidoForo = <<<EOS
<h2>Modifica aquí</h2>
$htmlFormForo 
EOS;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaForo.php';
?>