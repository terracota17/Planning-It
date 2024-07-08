<?php

use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
use es\ucm\fdi\aw\Mensaje\Mensaje as Mensaje;
use es\ucm\fdi\aw\Imagen as Imagen;
use es\ucm\fdi\aw\Notificacion\Notificacion as Notificacion;

function listaUsuario($nombre = null)
{
    $html = '';
    if($nombre){
        $usuario = Usuario::buscaUsuario($nombre);
        if($usuario){
            if (isset($_SESSION['login'])) {
                $html .= visualizaUsuario($usuario);
            }
        }
        else{
            $html .= sinUsuarios();
        }
    }
    else{
        $usuario = Usuario::listarUsuarios();
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
    }
   
    return $html;
}

function listaMensajes($idEmisor, $idRemitente) {

    $mensaje = Mensaje::listarMensajes($idEmisor, $idRemitente);
    $html = '';
  
    if($mensaje){ 
        foreach($mensaje as $mensaje) {
            if ($mensaje->getIdEmisor() == $_SESSION['id']) {
                $html .= visualizaMensaje1($mensaje, $idRemitente);
            }
            else {
                $html .= visualizaMensaje2($mensaje, $idRemitente);
               // Mensaje::actualizaLeido($mensaje, $idRemitente);
            }
        } 
    }
    else{
        $html .= sinMensajes();
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
        <img class = "chatImagenPerfil"  src= ../{$imagenPerfil}>
        EOS;
    }
   
    return $image;
}

function visualizaUsuario($usuario){
    $img = '';
    $img .= visualizaImagenPerfil($usuario->getId());
    $html = '';
    $html .= <<<EOS
    <div class = "box">
        {$img}
        <form action="../mensajes/chat.php"method="GET">
        <input type= "hidden" name="id" value = "{$usuario->getId()}">
        <input class = 'msg' type= "submit" value="{$usuario->getNombre()} @{$usuario->getNombreUsuario()}">
        </form>
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
    <div class = "box2">
    {$img}
    <h2>{$usuario->getNombre()} @{$usuario->getNombreUsuario()}</h2>
    </div>
    EOS;
    return $html;
}

function visualizaMensaje1($mensaje, $idrem){
    $usuario = Usuario::buscaPorId($mensaje->getIdEmisor());
    $time = time_elapsed_string($mensaje->getFecha());
    $html = '';
    $html .= <<<EOS
    <div class = 'mimensaje'>
        <div class = 'mensaje'>
            <p id = 'md'>{$usuario->getNombre()} @{$usuario->getNombreUsuario()} {$time}</p>
            <p>{$mensaje->getTexto()}</p>
        </div>
        <div class = 'opciones'>
            <form action="../mensajes/eliminarMensaje.php"method="POST">
            <input type= "hidden" name="id" value = "{$idrem}">
            <input type= "hidden" name="idMensaje" value = "{$mensaje->getId()}">
            <input class = "bmensaje" type= "image" src="../img/delete.png">
            </form>
            <form action="../mensajes/editarMensaje.php"method="POST">
            <input type= "hidden" name="id" value = "{$idrem}">
            <input type= "hidden" name="idMensaje" value = "{$mensaje->getId()}">
            <input type= "hidden" name="textoa" value = "{$mensaje->getTexto()}">
            <input class = "bmensaje" type= "image" src="../img/edit.png">
            </form>
        </div>
    </div>
    EOS;
    return $html;   
}

function visualizaMensaje2($mensaje){
    $usuario = Usuario::buscaPorId($mensaje->getIdEmisor());
    $time = time_elapsed_string($mensaje->getFecha());
    $html = '';
    $html .= <<<EOS
    <div class = 'mensaje'>
    <p id = 'md'>{$usuario->getNombre()} @{$usuario->getNombreUsuario()}</p>
    <p>{$mensaje->getTexto()}</p>
    <p>{$time}</p>
    </div>
    EOS;
    return $html;
}

function sinMensajes(){
    return <<<EOS
    <p style="padding-left: 20px; padding-right: 20px">No hay mensajes</p>
    EOS; 
}

function sinUsuarios(){
    return <<<EOS
    <p>No hay usuarios disponibles ahora mismo</p>
    EOS; 
}

/*
	Función extraída de: 
	https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
*/
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'año',
        'm' => 'mes',
        'w' => 'semana',
        'd' => 'dia',
        'h' => 'hora',
        'i' => 'minuto',
        's' => 'segundo',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? 'Hace '.implode(', ', $string) : 'Justo ahora';
}

?>