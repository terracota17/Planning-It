<?php

use es\ucm\fdi\aw\Producto\Producto as Producto;
use es\ucm\fdi\aw\Pedido\Pedido as Pedido;
use es\ucm\fdi\aw\Imagen as Imagen;

$cantidad = 1;
function verProducto($idProducto){
	$producto = Producto:: buscaPorductoId($idProducto);
	$html = '';
	$html .= visualizaProducto($producto);
	return $html;
}
function botonAñadirProducto(){
	return <<< EOS
	<button class = "botonMas" onclick="location.href='anadirProductos.php'" type="button"><img id = "mas"  src="../img/mas.png"></button>
	EOS;
}
function listaProductosGestion($nombre = null){
	if($nombre){
		$Producto = Producto::buscarProductoGestion($nombre);
	}
	else{
		$Producto = Producto::todosProductos();
	}
	
	$html = '<div class = "productos">';
	if($Producto){
	foreach($Producto as $Producto) {
		
			$html .= '<div>';
			$html .= visualizaResumenProducto($Producto);
			$html .= botonEditar($Producto);
			if($Producto->getEstado() === "descatalogado"){
				$html .= botonagregar($Producto);
			}
			else{
				$html .= botonDescatalogar($Producto);
			}
			$html .= botonInsertarImagen($Producto);
			
			$html .= '</div>';
			
	} 
	$html .= '</div>';
	}
	
	if(!$Producto){
		$html .= sinProductos();
	}
	return $html;
}
function verPedido($idPedido){
	$html = '';
	$Pedido = Pedido::buscaPedidoId($idPedido);
	$Productos = Pedido::ProductosPedido($Pedido);
	$html .= "<div style='margin:10px;padding:10px;'";
	$html .=  visualizaPedido($Pedido);
	if($Pedido->getEstado() === "pendiente"){
		$html .= botonEliminarPedido($Pedido);
		$html .= botonPagarPedido($Pedido);
	}
	$html .= '</div><div class = "tienda">';
	foreach($Productos as $Productos) {
		$html .= '<div class=producto>';
		$html .=visualizaResumenProducto($Productos,$Pedido->getEstado());
		$cantidad = Pedido::yaEnCarrito($Productos->getId(),$Pedido->getId());
		$html .=<<<EOS
		<p>Unidades: $cantidad</p>
		EOS;
		if($Pedido->getEstado() === "pendiente"){
			$html .= botonEliminarProductoPedido($Productos,$Pedido);
		}
		$html .= '</div>';
	}
	$html .= '</div>';
	return $html;
}
function listaPedidosUsuario($idUsuario){

	$Pedido = Pedido::PedidosUsuario($idUsuario);
	$html = '';
	if($Pedido){
		foreach($Pedido as $Pedido) {
			$html .= "<div style = 'width:fit-content;box-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;padding:20px;margin:10px;'>";
			$html .= visualizaPedido($Pedido);
			if($Pedido->getEstado() === "pendiente"){
				$html .= botonEliminarPedido($Pedido);
			}
			$html .= botonVerPedido($Pedido);
			$html .= "</div>";
		}
	} 
	else{
		$html .= sinPedidos();
	}
	return $html;
}

function listaProductosTienda($nombre = null)
{
	if($nombre){
		$Producto = Producto::buscarProductoTienda($nombre);
	}
	else{
		$Producto = Producto::Productos();
	}
	$html = '<div class = "tienda">';
	if($Producto){
		foreach($Producto as $Producto) {

			$html .= '<a class = "linkProducto" href="verProducto.php?id={';
			$html .=$Producto->getId();
			$html .= '}">';

			$html .= '<div style = "padding:10px;">';
			$html .= visualizaResumenProducto($Producto);
			$html .= '</div>';
			$html .= '</a>';
		} 
	}
	else{
		$html .= sinProductos();
	}
	$html .= '</div>';

	return $html;
}
function botonVer($Producto){
	return <<<EOS
	<a class="boton" href="verProducto.php?id={$Producto->getId()}">Ver</a>
	EOS;
}
function botonSubirImagenProducto($Producto){
	return <<<EOS
	<div class = "formSubidaImagenProducto">
	<form action="subirImagenProducto.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="idProducto" value = "{$Producto->getId()}">
	Imagen del producto: <input type="file" name="file" />
	<input class = "buttonupload" type="submit" name="submit" value="Upload">
	</form>
	</div>
	EOS;
}
function botonPagarPedido($Pedido){
	return <<<EOS
	<form action="pagarPedido.php" method = "post">
	<input type="hidden" name="idPedido" value = "{$Pedido->getId()}">
	<input class = "pagarPedido" type= "submit" value="Pagar">
	</form>
	EOS;
}
function botonEliminarPedido($Pedido){
	return <<<EOS
	<form action="eliminaPedido.php" method = "post">
	<input  type="hidden" name="idPedido" value = "{$Pedido->getId()}">
	<input class = "eliminarPedido" type= "submit" value="Eliminar Pedido">
	</form>
	EOS;

}
function botonVerPedido($Pedido){
	return <<<EOS
	<form action="verPedido.php" method = "get">
	<input  type="hidden" name="idPedido" value = "{$Pedido->getId()}">
	<input class = "eliminarPedido" type= "submit" value="Ver">
	</form>
	EOS;
}

function botonagregar($Producto){
	return <<<EOS
	<form action="agregarProducto.php" method = "post">
	<input  type="hidden" name="idProducto" value = "{$Producto->getId()}">
	<input class = "agregarProducto" type= "submit" value="Agregar">
	</form>
	EOS;
}
function botonDescatalogar($Producto){
	return <<<EOS
	<form action="descatalogarProducto.php" method = "post">
	<input  type="hidden" name="idProducto" value = "{$Producto->getId()}">
	<input class = "descatalogarProducto" type= "submit" value="Descatalogar">
	</form>
	EOS;
}
function botonEditar($Producto){
	return <<<EOS
	<form action="editarProducto.php" method = "post">
	<input  type="hidden" name="idProducto" value = "{$Producto->getId()}">
	<input class = "editarProducto" type= "submit" value="Editar">
	</form>
	EOS;
}
function botonEliminarProductoPedido($Producto,$Pedido){
	return <<<EOS
	<form action="eliminaProductoPedido.php" method = "post">
	<input  type="hidden" name="idProducto" value = "{$Producto->getId()}">
	<input  type="hidden" name="idPedido" value = "{$Pedido->getId()}">
	<input class = "eliminarPedido" type= "submit" value="Eliminar Producto" style = "padding:0; align-items:center;">
	</form>
	EOS;
}
function sinProductos(){
	return <<<EOS
	<p>No hay Productos disponibles ahora mismo</p>
	EOS;
}
function sinPedidos(){
	return <<<EOS
	<p>No hay Pedidos disponibles ahora mismo</p>
	EOS;
}
function visualizaResumenProducto($Producto,$estado = null){
	$html = '';
	$id = $Producto->getId();
	$imagen = Imagen::buscarImagenProductoPorId($id);
	$htmlImagen  = '';
	if($imagen){
		$htmlImagen .= <<<EOS
		<div class= fotoContainer><img  id = "imagenProducto" src = {$imagen}></div>
		EOS;
	}else{
		$htmlImagen .= <<<EOS
		<div class= fotoContainer><img id = "imagenProducto" src = "../img/sinImagenProducto.png"></div>
		EOS;
	}
	if($estado === "Pagado"){
		$html .= <<<EOS
		{$htmlImagen}
		<p style="color:black;">Nombre del Producto: {$Producto->getNombre()} </p>
		EOS;
	}
	else{
		$html .= <<<EOS
		{$htmlImagen}
		<p style="color:black;">Nombre del Producto: {$Producto->getNombre()} </p>
		<p style="color:black;">Precio del Producto: {$Producto->getPrecio()} €</p>
		EOS;
	}
	return $html;
}
function visualizaProducto($Producto){
	$html = '<div class=verTienda>';
	$id = $Producto->getId();
	$imagen = Imagen::buscarImagenProductoPorId($id);
	$htmlImagen  = '';
	if($imagen){
		$htmlImagen .= <<<EOS
		<div class= fotoTienda><img  id = "imagenProducto" src = {$imagen}></div>
		EOS;
	}else{
		$htmlImagen .= <<<EOS
		<div class= fotoTienda><img id = "imagenProducto" src = "../img/sinImagenProducto.png"></div>
		EOS;
	}
	$html .= <<<EOS
		{$htmlImagen}
		<div class=datosCompra>
		<p class = textoNombreTienda>Nombre del Producto: {$Producto->getNombre()} </p>
		<p class = textoPrecioTienda>Precio del Producto: </p>
		<p class = PrecioTienda>{$Producto->getPrecio()} €</p>
		<p class = infoTienda>Descripción: {$Producto->getInfo()}</p>
		</div>
		<div>
		</div>
		EOS;
	return $html;
}
function visualizaPedido($Pedido){
	$html = '';
	$html .= <<<EOS
	<p>Coste total: {$Pedido->getPrecio()}€  </p>
	<p>Estado: {$Pedido->getEstado()} </p>
	EOS;
	return $html;
}

function botonInsertarImagen($Producto) {
    return <<<EOS
	<form action = "../tienda/subirImagenProducto.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="idProducto" value = "{$Producto->getId()}">
	<input  class = "buttonupload" type="submit" name="submit" value="Upload">
	<input type="file" name="file"/>
	</form>
	EOS;
}