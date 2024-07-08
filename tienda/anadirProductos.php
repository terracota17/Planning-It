<?php

use es\ucm\fdi\aw\Usuario\Usuario as Usuario;

require_once '../includes/config.php';
//solo puede añadir un admin, mejorar roles

$contenidoPrincipal = '';
$tituloPagina = 'Nuevo Producto';
if(isset($_SESSION['id'])){
    if (($_SESSION['esAdmin'])){
        $tituloPagina = 'Nuevo producto';
        
        $form = new es\ucm\fdi\aw\Producto\FormularioProducto();
       
        $htmlFormProducto = $form->gestiona();
       
        $contenidoPrincipal = '';
        $contenidoPrincipal .= <<<EOS
        <h1>Registro de producto</h1>
        $htmlFormProducto
        EOS;
    
    
    }else{
        $contenidoPrincipal .=<<<EOS
        <h1>Area Restringida a los Usuarios  (Salga de Aqui)  :)</h1>
        <img class = "NotAdmin" src = "../img/NotEvenAnAdmin.jpg">
        EOS;
    }
}
else{
    $contenidoPrincipal .=<<<EOS
    <h2>Inicie Sesion para acceder a esta seccion</h2>
    EOS;
}

require_once '../includes/vistas/plantillas/plantillaTienda.php';