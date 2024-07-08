<?php

use es\ucm\fdi\aw\Evento\Evento as Evento;
use es\ucm\fdi\aw\Participantes as Participantes;
use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
use es\ucm\fdi\aw\Imagen as Imagen;

function listaEventos($idUsuario = null)
{
    $evento = Evento::eventosUsuario($idUsuario);
    $html = '';
    if($evento){
    foreach($evento as $evento) {
        $html .= '<div class ="evento">'; 
        $html .= visualizaMiniatura($evento);
        $html .= visualizaEvento($evento);
        $html .= botonMasInfo($evento);
        $html .= <<<EOS
        </div>
        EOS;
    } 
    $html .= botonBuscarPorFecha();
    }
    else{
        $html .= sinEventos();
    }
    return $html;
}

function visualizaMiniatura($evento){
    $imagen = Imagen::buscarImagenEventoPorId($evento->getId());
    if(!$imagen){
        return <<<EOS
        <img class = "miniatura" src="../img/sinImagenEvento.png">
        EOS;
    }else{
        return <<<EOS
        <img class = "miniatura" src={$imagen}>
        EOS;
    }
}
function visualizaImagenEvento($evento){
    $imagen = Imagen::buscarImagenEventoPorId($evento->getId());
    if(!$imagen){
        return <<<EOS
        <img class = "imagenEvento" src="../img/sinImagenEvento.png">
        EOS;
    }else{
        return <<<EOS
        <img class = "imagenEvento" src={$imagen}>
        EOS;
    }
}

function botonInsertarImagen($evento) {
    return <<<EOS
    <form action = "../eventos/subirImagenEvento.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idEv" value = "{$evento->getId()}">
    Imagen del evento: <input type="file" name="file"/>
    <input class = "buttonupload" type="submit" name="submit" value="Upload">
    </form>
    EOS;
}

function botonBuscarPorFecha()
{
    return <<<EOS
    <div>
    <button id="buscar" onclick="location.href='mostrarEventosFecha.php'" type="button">Buscar Evento por Fecha</button>
    </div>
    EOS;
}

function listaEventosPorFecha($fecha)
{
    $evento = Evento::buscarPorFecha($fecha);
    $html = '';
    if($evento){
        foreach($evento as $evento) {
            $html .= visualizaMiniatura($evento);
            $html .= visualizaEvento($evento);            
        } 
    }
    else{
        $html .= sinEventos();
    }

    return $html;
}

function sinEventos(){
    return <<<EOS
    <p>No hay eventos disponibles ahora mismo</p>
    EOS; 
}

function visualizaEvento($evento){
    $html = '';
    $html .= <<<EOS
    <div class="list">
    <p style="font-weight:bold;">{$evento->getNombre()}
    EOS;
    if (Evento::haFinalizado($evento)) {
        $html .= '<span style="background-color:red;border:red;border-radius:3px;border-width:1px;margin-left:5px;padding-left:5px;padding-right:5px;color:white;font-size:15px;font-weight:normal;"
        >Finalizado</span>';
    }
    $html .= <<<EOS
    </p>
    <p>{$evento->getUbi()}</p>
    <p>{$evento->getFecha()}</p>
    </div>
    EOS;
    return $html;
}

function visualizaEventoCompleto($idEvento){
    $html = '';
    $participantes = Participantes::buscaPorIdEvento($idEvento);
    $evento = Evento::buscarEventoPorId($idEvento);
    $html .= <<<EOS
    <div>
    <p>{$evento->getFecha()}</p>
    <h2>{$evento->getNombre()}</h2>
    EOS;
    $html .= visualizaImagenEvento($evento);
    $html .= <<<EOS
    </div>
    <h2> Detalles </h2>
    <p><img class="evmini" src="../img/location.png">{$evento->getUbi()}</p>
    <p><img class="evmini" src="../img/info.png">{$evento->getInfo()}</p>
    <p><img class="evmini" src="../img/users.png">Participantes: </p>
    EOS;

    foreach($participantes as $participante) {
        $usuario = Usuario::buscaPorId($participante->getId());
        $html .= <<<EOS
        <a href='../personal/mostrarPerfil.php?id={$usuario->getId()}'>{$usuario->getNombreUsuario()} </a>
        EOS;
    } 

    if (isset($_SESSION['login'])) {
        if($evento->getIdUsuario() == $_SESSION['id']) {
            $html .= botonInsertarImagen($evento);
            $html .= botonEditaEvento($evento);
            $html .= botonForo($evento);
            $html .= botonEliminaEvento($evento);
        }

        if (!Participantes::estaParticipandoEvento($evento->getId(), $_SESSION['id']) && !Evento::haFinalizado($evento)) {
            $html .= botonParticipar($evento);
        }
        else if (Participantes::estaParticipandoEvento($evento->getId(), $_SESSION['id'])){
            $usuario = Usuario::buscaPorId($_SESSION['id']);
            $html .= botonSalir($evento, $usuario);
        }
    }

    $html .= '</div>';

    return $html;
}

function visualizaEventoPorFecha($evento){
    return <<<EOS
    <p>Nombre del evento: {$evento->getNombre()}</p>
    <p>Información del evento: {$evento->getInfo()}</p>
    <p>Fecha del evento: {$evento->getFecha()}</p>
    EOS;
}
function botonSalir($evento, $usuario){
    return<<<EOS
    <form action="eliminarParticipantes.php"method="post">
    <input  type="hidden" name="idEvento" value = "{$evento->getId()}">
    <input  type="hidden" name="idUsuario" value = "{$usuario->getId()}">
    <input class = "bevento" type= "image" src="../img/exit.png">
    </form>
    EOS;
}
function botonForo($evento){
    return<<<EOS
    <form action="../foros/mensajesForo.php" method="get" enctype="multipart/form-data">
    <input type="hidden" name="idForo" value="{$evento->getForoId()}">
    <input class = "bevento" type= "image" src="../img/foro.png">
    </form>
    EOS;
}
function botonEditaEvento($evento){
    return<<<EOS
    <form action="modificarEvento.php"method="post">
    <input  type="hidden" name="idEvento" value = "{$evento->getId()}">
    <input class = "bevento" type= "image" src="../img/edit.png">
    </form>
    EOS;
}
function botonEliminaEvento($evento){
    return <<<EOS
    <form action="eliminarEvento.php" method = "post">
    <input  type="hidden" name="idEvento" value = "{$evento->getId()}">
    <input class = "bevento" type= "image" src="../img/delete.png">
    </form>
    EOS;
}
function botonParticipar($evento){
    return <<<EOS
    <form action="participarEvento.php" method = "post">
    <input  type="hidden" name="idEvento" value = "{$evento->getId()}">
    <input class = "bevento" type= "image" src="../img/join.png">
    </form>
    EOS;
}
function botonMasInfo($evento){
    return <<<EOS
    <button id="mas" onclick="location.href='mostrarEvento.php?id={$evento->getId()}'" type="button">+</button>
    EOS;
}
