<?php
     require_once __DIR__.'/../includes/config.php';
     require_once __DIR__.'/../includes/vistas/helpers/notificacion.php';
    
    $tituloPagina = 'Notificaciones';
    $contenidoPrincipal = '';
    $contenidoEvento = '';

    $contenidoNotificacion = '';
    
    $contenidoPrincipal .= <<<EOS
    <h2> Centro de Notificaciones </h2>
    EOS;
    $id = '';
    if(isset($_SESSION['id'])){
        $id = $_SESSION['id'];
    }

    $contenidoNotificacion .= listaNotificaciones($id);
    

    require_once __DIR__.'/../includes/vistas/plantillas/plantillaNotificaciones.php';
?>
