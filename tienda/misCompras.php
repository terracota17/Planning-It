<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/producto.php';

    $tituloPagina = 'MisCompras';
    $contenidoPrincipal = '';
    $contenidoPrincipal .= <<<EOS
    <p>Mis Compras: </p>
    EOS;
    if( isset($_SESSION['login'])  &&  $_SESSION['login'] === true){
        
        $contenidoPrincipal .= listaPedidosUsuario($_SESSION['id']);
    }

    require_once __DIR__.'/../includes/vistas/plantillas/plantillaTienda.php';
?>