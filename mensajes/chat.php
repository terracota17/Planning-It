<?php
use es\ucm\fdi\aw\Notificacion\Notificacion as Notificacion;

require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/utils.php';
require_once __DIR__.'/../includes/vistas/helpers/mensaje.php';

$idrem= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
$nombre = filter_input(INPUT_GET,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$accesoNotificacion = filter_input(INPUT_GET,'acesso',FILTER_SANITIZE_NUMBER_INT);


  /**Eliminar todos la notificaciones asociades a este chat */
if($accesoNotificacion){
    $notificaciones = Notificacion::buscarYEliminarNotificacionesChat($idrem);
}

$form = new es\ucm\fdi\aw\Mensaje\FormularioMensaje($idrem);
$htmlFormMensaje = $form->gestiona();


$form = new es\ucm\fdi\aw\Mensaje\FormularioBuscaUsuario();
$htmlFormUsuario = $form->gestiona();

$tituloPagina = 'Mensajes';
$contenidoPrincipal = '';
$contenidoMensaje = '';

$contenidoPrincipal .= <<<EOS
<h1> Chats </h1>
$htmlFormUsuario
EOS;

if($nombre){
    $contenidoPrincipal .= listaUsuario($nombre);
}
else{
    $contenidoPrincipal .= listaUsuario();
}

$contenidoMensaje .= visualizaUsuarioChat($idrem);
$contenidoMensaje .= listaMensajes($_SESSION['id'], $idrem);
$contenidoMensaje .= $htmlFormMensaje;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaMensajes.php';
