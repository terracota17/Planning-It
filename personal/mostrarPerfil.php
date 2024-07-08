<?php 
require_once __DIR__.'/../includes/config.php'; 
require_once __DIR__.'/../includes/vistas/helpers/menu.php';

$idUsuario= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);

$tituloPagina = 'Perfil';
$contenidoPrincipal = '';
$contenidoPrincipal .= cargaMenuOtro($idUsuario);

require_once __DIR__.'/../includes/vistas/plantillas/plantillaPersonal.php';