<?php
    require_once __DIR__.'/../includes/config.php';
    use es\ucm\fdi\aw\Usuario\Usuario as Usuario;

	$tituloPagina = 'ConfigUsuarioNotificaciones';
	$contenidoNota1 = '';
    $contenidoNota2 = '';
    $valor = filter_input(INPUT_POST,'notif',FILTER_SANITIZE_NUMBER_INT);


    Usuario::actualizarRecibirNotificaciones($_SESSION['id'], $valor);

    header('Location: areapersonal.php');
    exit();
    
    require_once __DIR__.'/../includes/vistas/plantillas/plantillaAreaPersonal.php';
?>