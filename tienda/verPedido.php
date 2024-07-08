<?php
    /*Muestra la informacion mas especifica de un producto*/
    require_once('../includes/config.php');
    require ('../includes/vistas/helpers/producto.php');
    use es\ucm\fdi\aw\Pedido\Pedido as Pedido;
    use es\ucm\fdi\aw\Notificacion\Notificacion as Notificacion;

    $form = new es\ucm\fdi\aw\Pedido\FormularioPedido();
    $htmlFormPedido = $form->gestiona();
    $tituloPagina = 'Tu pedido';
    $contenidoPrincipal = '';
    $contenidoPrincipal .= <<<EOS
    <h2 style="margin:10px;padding:10px;">Tu pedido: </h2>
    EOS;
    $idPedido= filter_input(INPUT_GET,'idPedido',FILTER_SANITIZE_NUMBER_INT);
    $accesoPedido= filter_input(INPUT_GET,'acesso',FILTER_SANITIZE_NUMBER_INT);
    $pedido = Pedido::buscaPedidoId($idPedido);
    Pedido::calculaPrecio($pedido);
    
    if($accesoPedido !== null){
     
		Notificacion::EliminarNotificacionesPedido($idPedido);
	}
    $contenidoPrincipal .= verPedido($idPedido);

    require ('../includes/vistas/plantillas/plantillaTienda.php');
?>