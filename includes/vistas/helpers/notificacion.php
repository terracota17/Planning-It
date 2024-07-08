<?php

use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
use es\ucm\fdi\aw\Mensaje\Mensaje as Mensaje;
use es\ucm\fdi\aw\Imagen as Imagen;
use es\ucm\fdi\aw\Notificacion\Notificacion as Notificacion;

function listaUsuario()
{
    $usuario = Usuario::listarUsuarios();
    $html = '';
    if($usuario){
        foreach($usuario as $usuario) {
            if (isset($_SESSION['login'])) {
                $html .= visualizaUsuario($usuario);
            }
        } 
    }
    else{
        $html .= sinUsuarios();
    }
    return $html;
}

function listaNotificaciones($idRemitente) {
    $notificacion = Notificacion::listarNotificacion($idRemitente);
    $html = '';
    if($notificacion){
        foreach($notificacion as $notificacion) {
                $html .= visualizaNotificacion($notificacion);
             /* Notificacion::actualizaNotificacion($notificacion->getId());*/
                
        } 
    }
    else{
        $html .= sinNotificaciones();
    }
    return $html;
}

function visualizaImagenPerfil($usuarioiD){
    $image = '';
    $imagenPerfil = Imagen::buscarImagen($usuarioiD);
    if(!$imagenPerfil){
        $image .= <<<EOS
        <img class = "chatImagenPerfil"  src= "../img/sinImagenPerfil.jpg">
        EOS;
    }else{
        $image .= <<<EOS
        <img class = "chatImagenPerfil"  src= {$imagenPerfil}>
        EOS;
    }
   
    return $image;
}

function visualizaUsuario($usuario){
    $img = '';
    $img .= visualizaImagenPerfil($usuario->getId());
    $html = '';
    $html .= <<<EOS
    <div id = "chatIndividual">
        {$img}
        <li><a href="chat.php?id={$usuario->getId()}">{$usuario->getNombre()} @{$usuario->getNombreUsuario()}</a></li>
    </div>
    EOS;
    return $html;
}

function visualizaUsuarioChat($idRemitente){
    $usuario = Usuario::buscaPorId($idRemitente);
    $html = '';
    $img = '';
    $img .= visualizaImagenPerfil($usuario->getId());  
    $html .= <<<EOS
    {$img}
    <h2>{$usuario->getNombre()} @{$usuario->getNombreUsuario()}</h2>
    EOS;
    return $html;
}


function visualizaNotificacion($notificacion){
    $usuario = Usuario::buscaPorId($notificacion->getIdRemitente());
    $uno = 1;
    $html = '';
    $redireccion = '';
    if( $notificacion->getIdForo() !== NULL){
     
        $redireccion = '../foros/mensajesForo.php?idForo='.$notificacion->getIdForo().'&submit=Entrar'.'&acesso='.$uno;
    }
    else if($notificacion->getIdPedido() !== NULL){
        $redireccion = '../tienda/verPedido.php?idPedido='.$notificacion->getIdPedido().'&submit=Entrar'.'&acesso='.$uno;
    }
   else {
        /*tipo de la notificacion : foro */

       $redireccion = '../mensajes/chat.php?id='.$notificacion->getIdEmisor().'&acesso='.$uno;
     }    

    $idNotificacion = $notificacion->getId();
     $html .= <<<EOS
    <a class = 'enlaceNotificacion' href = {$redireccion}>
    <div class = 'notificacion'>
    <p id = 'md'>{$usuario->getNombre()} @ {$usuario->getNombreUsuario()}   {$notificacion->getFecha()}</p>
    <p>{$notificacion->getIntro()} </p>
    <p>{$notificacion->getTexto()}</p>
    <button class = 'botonEliminarNotificacion' 'type = 'button'>
    <a class = 'eliminarNotificacion' href = 'eliminarNotificacion.php?id={$idNotificacion}'>Eliminar
    </a>
    </button>
    </div>
    </a>
    EOS;
    return $html;
}


function sinNotificaciones(){
    return <<<EOS
    <p>No hay Notificaciones en este momento</p>
    EOS; 
}



?>