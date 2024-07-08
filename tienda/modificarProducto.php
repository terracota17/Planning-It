<?php

require_once '../includes/config.php';

$tituloPagina = 'Nuevo producto';
//solo puede añadir un admin, mejorar roles
    $form = new es\ucm\fdi\aw\Producto\FormularioModificarProducto();
    $htmlFormProducto = $form->gestiona();

    $contenidoPrincipal = <<<EOS
    <h1>Registro de producto</h1>
    $htmlFormProducto
    EOS;


require_once '../includes/vistas/plantillas/plantillaTienda.php';