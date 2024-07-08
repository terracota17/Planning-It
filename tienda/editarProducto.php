<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/producto.php';

$idProducto= filter_input(INPUT_POST,'idProducto',FILTER_SANITIZE_NUMBER_INT);
$form = new es\ucm\fdi\aw\Producto\FormularioEditarProducto($idProducto);
$htmlFormProducto= $form->gestiona();

$tituloPagina = 'Gestion Productos';
$contenidoPrincipal = '';

$contenidoPrincipal = <<<EOS
<h2>Editar producto</h2>
EOS;
$contenidoPrincipal .= $htmlFormProducto;


require_once __DIR__.'/../includes/vistas/plantillas/plantillaTienda.php';
