<?php
require_once('../includes/config.php');
require ('../includes/vistas/helpers/producto.php');

$tituloPagina = 'Productos';
$contenidoPrincipal = '';
$contenidoEvento = '';
$nombre = filter_input(INPUT_GET,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$form = new es\ucm\fdi\aw\Producto\FormularioBuscaProducto();
$htmlFormProducto = $form->gestiona();

$contenidoPrincipal .= <<<EOS
<h2> Gestion de productos </h2>
EOS;
$contenidoPrincipal .= botonAñadirProducto();
$contenidoPrincipal .= $htmlFormProducto;
if($nombre){
    $contenidoPrincipal .= listaProductosGestion($nombre);
}
else{
    $contenidoPrincipal .= listaProductosGestion();
}
require_once __DIR__.'/../includes/vistas/plantillas/plantillaTienda.php';
?>