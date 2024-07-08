<?php

function anhadirProducto() {
    $html = '';
    if (isset($_SESSION['login'])){
        if (!isset($_SESSION['esAdmin']) || !$_SESSION['esAdmin']) { 
            return '';
        }
        else { 
            return "| <a style = 'text-decoration:none;' href='gestionarProductos.php'>Gestión</a>";
        }
    }

    return $html;
}

use es\ucm\fdi\aw\Producto\Producto as Producto;

    /*Lista todos los productos */
    require_once('../includes/config.php');
    require ('../includes/vistas/helpers/producto.php');
   
    $tituloPagina = 'Tienda';

    $nombre = filter_input(INPUT_GET,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $form = new es\ucm\fdi\aw\Producto\FormularioBuscaProductoTienda();
    $htmlFormProducto = $form->gestiona();
    $mas = anhadirProducto();
    $contenidoPrincipal = <<<EOS
    <h2 style = "padding:10px; margin10px;">Tienda 
    {$mas}
    </h2>
    EOS;

    $contenidoPrincipal .= $htmlFormProducto;
    if($nombre){
        $contenidoPrincipal .= listaProductosTienda($nombre);
    }
    else{
        $contenidoPrincipal .= listaProductosTienda();
    };

    require ('../includes/vistas/plantillas/plantillaTienda.php');
?>


