<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/utils.php';

$idEvento= filter_input(INPUT_POST,'idEvento',FILTER_SANITIZE_NUMBER_INT);
es\ucm\fdi\aw\Participantes::crearParticipacion($idEvento,$_SESSION['id']);
$evento = es\ucm\fdi\aw\Evento\Evento::buscarEventoPorId($idEvento);
if( ! es\ucm\fdi\aw\Calendario::yaExiste($idEvento,$_SESSION['id'])){
    es\ucm\fdi\aw\Calendario::anhadirEvent($evento->getNombre(), $evento->getFecha(), $evento->getFecha(),  $evento->getId());
}
header('Location: listarEventos.php');
exit();