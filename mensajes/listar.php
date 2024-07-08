<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/mensaje.php';

    $form = new es\ucm\fdi\aw\Mensaje\FormularioBuscaUsuario();
    $htmlFormUsuario = $form->gestiona();

    $nombre = filter_input(INPUT_GET,'nombre',FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $tituloPagina = 'Mensaje';
    $contenidoPrincipal = '';
    $contenidoMensaje = '';

    if( isset($_SESSION['login'])  &&  $_SESSION['login'] === true){
        $contenidoPrincipal .= <<<EOS
        <h1> Chats </h1>
        $htmlFormUsuario
        EOS;
        if($nombre){
            $contenidoPrincipal .= listaUsuario($nombre);
        }
        else{
            $contenidoPrincipal .= listaUsuario();
        }
        
    }
    else{
        $contenidoMensaje .=  "<p>Inicia sesion para usar esta función.</p>";
    }
    
    require_once __DIR__.'/../includes/vistas/plantillas/plantillaMensajes.php';
?>
