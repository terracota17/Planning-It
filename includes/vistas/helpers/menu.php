<?php

use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
use es\ucm\fdi\aw\Evento\Evento as Evento;
use es\ucm\fdi\aw\Imagen as Imagen;
use es\ucm\fdi\aw\Participantes as Participantes;

function cargaMenu(){
    $menu = '';

    if(isset($_SESSION["login"])){
        $usuario = Usuario::buscaPorId($_SESSION['id']);
        $img = Imagen::buscarImagen($_SESSION['id']);
        $menu .= cargaDatos($usuario, $img);

        $menu .= botonInsertarImagen();

        $menu .= botonCalendario();
        $menu .= botonModificar();
        $menu .= botonConf();
        $menu .= botonCompras();
        $menu .= botonMisEventos();
        $menu .= botonNotificaciones();
        $menu .= botonCerrarSesion();
    }else{ 
        $menu = <<<EOS
        <p>Usuario desconocido. <a href='../login.php'>Iniciar sesion</a> o <a href='../registro.php'>Registrarse</a></p>
        EOS;
    }
    
    return $menu;
}


function fullcalendar(){
    require_once("../fullcalendar/index.php"); 
}

function cargaMenuOtro($idUsuario){
    $menu = '';
    $usuario = Usuario::buscaPorId($idUsuario);
    $img = Imagen::buscarImagen($idUsuario);
    $evento = Evento::eventosUsuario($_SESSION['id']);
    $menu .= cargaDatos($usuario, $img);

    if(isset($_SESSION["login"])){
        $menu .= botonEnviarMensaje($usuario);
        foreach($evento as $evento) {
            if (Participantes::estaParticipandoEvento($evento->getId(), $idUsuario)) {
                $menu .= botonExpulsar($evento, $usuario);
            }
        }
    }
    else{ 
        $menu = <<<EOS
        <p>Usuario desconocido. <a href='login.php'>Iniciar sesion</a> o <a href='registro.php'>Registrarse</a></p>
        EOS;
    }
    
    return $menu;
}


function cargaDatos($usuario, $img){
   if(!$img){
        return <<<EOS
        <img class = "imagenUsuario" src="../img/sinImagenPerfil.jpg">
        <div class = "centered" ><i class="fa-solid fa-user extraClass"></i>{$usuario->getNombre()} {$usuario->getApellido()} </div>
        <div class = "centered" > <i class="fa-solid fa-envelope extraClass"></i> {$usuario->getCorreo()} </div>
        <div class = "centered" ><i class="fa-solid fa-square-phone extraClass"></i> {$usuario->getTelefono()}</div>
        EOS;

    }else{
        return <<<EOS
        <img class = "imagenUsuario" src=../{$img}>
        <div class = "centered" ><i class="fa-solid fa-user extraClass"></i>{$usuario->getNombre()} {$usuario->getApellido()} </div>
        <div class = "centered" > <i class="fa-solid fa-envelope extraClass"></i> {$usuario->getCorreo()} </div>
        <div class = "centered" ><i class="fa-solid fa-square-phone extraClass"></i> {$usuario->getTelefono()}</div>
        EOS;    
    }
    
}

function botonEnviarMensaje($usuario) {
    return <<<EOS
    <form action="../mensajes/chat.php"method="get">
    <input type= "hidden" name="id" value = "{$usuario->getId()}">
    <input type= "submit" value="Enviar Mensaje">
    </form>
    EOS;
}

function botonExpulsar($evento, $usuario) {
    return <<<EOS
    <form action="../eventos/eliminarParticipantes.php"method="post">
    <input  type="hidden" name="idEvento" value = "{$evento->getId()}">
    <input  type="hidden" name="idUsuario" value = "{$usuario->getId()}">
    <input class = 'expulsar' type= "submit" value="Expulsar del evento {$evento->getNombre()}">
    </form>
    EOS;
}

function botonInsertarImagen() {
    return <<<EOS
        <div class = "imagenCentradaForm">
        <form action="../personal/subirImagen.php" method="post" enctype="multipart/form-data">   
        <input type="file" name="file" />
        <input class = "buttonupload" type="submit" name="submit" value="Upload">
        </form>
        </div>
        EOS;
}
function botonModificar(){
    return <<<EOS
    <div>
    <form action="./modificarPerfil.php">
    <div class = "centered"><input class = "buttonAp" type="submit" name="EditarPerfil" value="Editar Perfil" ></input></div>
    </form>
    </div>
    EOS;
}

function botonConf(){
    return <<<EOS
    <div>
    <form action="./configuracion.php">
    <input class = "buttonAp" type="submit" name="Configuracion" value="Configuracion" />
    </form>
    </div>
    EOS;
}

function botonCompras(){
    return <<<EOS
    <div>
    <form action="./../tienda/misCompras.php">
    <input  class = "buttonAp" type="submit" name="Mis Compras" value="Mis Compras" />
    </form>
    </div>
    EOS;
}

function botonMisEventos(){
    return <<<EOS
    <div>
    <form action="./../eventos/MisEventos.php">
    <input class = "buttonAp" type="submit" name="Mis Eventos" value="Mis Eventos" />
    </form>
    </div>
    EOS;
}
function botonNotificaciones(){
    return <<<EOS
    <div>
    <form action="../notificaciones/listarNotificaciones.php">
    <input class = "buttonAp" type="submit" name="Notificaciones" value="Notificaciones" />
    </form>
    </div>
    EOS;
}
function botonCerrarSesion(){
    return <<<EOS
    <div>
    <form action="../logout.php">
    <input  class = "buttonAp" type="submit" name="logout" value="Cerrar Sesión" />
    </form>
    </div>
    EOS;
}

function botonCalendario(){
    return <<<EOS
    <div>
    <form action="../fullcalendar/index.php">
    <input  class = "buttonAp" type="submit" name="calendar" value="Calendario" />
    </form>
    </div>
    EOS;
}