<?php
    /*Muestra la informacion mas especifica de un producto*/
    require_once('../includes/config.php');
    require ('../includes/vistas/helpers/producto.php');
   
    $form = new es\ucm\fdi\aw\Pedido\FormularioPedido();
    $htmlFormPedido = $form->gestiona();
    $tituloPagina = 'Tienda';
    $contenidoPrincipal = '';
    $idProducto= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    $contenidoPrincipal .= verProducto($idProducto);
    $contenidoPrincipal .= $htmlFormPedido;
    require ('../includes/vistas/plantillas/plantillaTienda.php');
?>