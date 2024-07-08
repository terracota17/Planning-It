<?php

use es\ucm\fdi\aw\Nota\Nota as Nota;

function listaNotas($idUsuario = null)
{
    $nota = Nota::notasUsuario($idUsuario);

    $html = '';
    if($nota){
        $html .= '<h1>Mis Notas</h1>' ;
        foreach($nota as $nota) {
        
            if (isset($_SESSION['login']) && $_SESSION['login']===true && $idUsuario !== null) {
                    $html .= card($nota);
                }
        } 
    }
    else{
        $html .= sinNotas();
    }

    return $html;
}
function card($nota){
    $edita= botonEditaNota($nota);
    $elimina= botonEliminaNota($nota);
    return <<<EOS
    <div class="card">
    <div class = "infoCentered" ><i class="fa-solid fa-info"></i></i><h4>Informacion de la nota:</h4></div>
    <p>{$nota->getInfo()}</p>
    {$edita}
    {$elimina}
    </div>
    EOS;
}
function sinNotas(){
    return <<<EOS
    <p>No hay notas disponibles ahora mismo</p>
    EOS; 
}

function visualizaNota($nota){
    return <<<EOS
    <p>Información del la nota: {$nota->getInfo()}</p>
    EOS;
}

function botonEditaNota($nota){
    return <<<EOS
    <form class = "formularioNota" action="modificarNota.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idNota" value="{$nota->getId()}">
    <div class = "centered"><i class="fa-solid fa-pen-to-square extra"></i><input class = "boton" type="submit" name="submit" value="Editar"></div>
    </form>
    EOS;
}

function botonEliminaNota($nota){
    return <<<EOS
    <form  class = "formularioNota" action="eliminarNota.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="idNota" value="{$nota->getId()}">
    <div class = "centered"><i class="fa-solid fa-trash extra"></i><input class = "boton" type="submit" name="submit" value="Eliminar"></div>
    </form>
    EOS;
}
