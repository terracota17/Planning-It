<?php
require_once __DIR__.'/../includes/config.php';

$form = new es\ucm\fdi\aw\Nota\FormularioNotas();
$htmlFormNota = $form->gestiona();

$tituloPagina = 'Nueva Nota';
$contenidoNota2 = '';
$contenidoNota1 = <<<EOS
<h1>Registro de Nota</h1>
EOS;
if( isset($_SESSION['login'])  &&  $_SESSION['login'] === true){
    $contenidoNota1 .= $htmlFormNota;
}
else{
    $contenidoNota1 .=  "<p>Inicia sesion para crear una nota</p>";
}

$contenidoNota2 .= <<<EOS
<div>
<button><a class="boton" href="MisNotas.php">Mis Notas</a></button>
</div>
EOS;


require_once __DIR__.'/../includes/vistas/plantillas/plantillaAreaPersonal.php';