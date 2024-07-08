<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/mensaje.php';

$idrem = filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
$idmsg = filter_input(INPUT_POST,'idMensaje',FILTER_SANITIZE_NUMBER_INT);
$texto = filter_input(INPUT_POST,'textoa',FILTER_UNSAFE_RAW);

$form = new es\ucm\fdi\aw\Mensaje\FormularioMensaje($idrem, $idmsg, $texto);
$htmlFormMensaje = $form->gestiona();

$tituloPagina = 'Mensajes';
$contenidoPrincipal = '';
$contenidoMensaje = '';

$contenidoPrincipal .= <<<EOS
<h1> Chats </h1>
EOS;
$contenidoPrincipal .= listaUsuario();

$contenidoMensaje .= visualizaUsuarioChat($idrem);
$contenidoMensaje .= listaMensajes($_SESSION['id'], $idrem, NUll);
$contenidoMensaje .= $htmlFormMensaje;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaMensajes.php';
