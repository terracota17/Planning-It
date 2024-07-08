<?php 

use es\ucm\fdi\aw\Foro\Foro as Foro;
use es\ucm\fdi\aw\Foro\MensajesForo as MensajesForo;
use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
use es\ucm\fdi\aw\Participantes as Participantes;
use es\ucm\fdi\aw\Imagen as Imagen;
use es\ucm\fdi\aw\Notificacion\Notificacion as Notificacion;

function listaForos($idUsuario = null){
	$id='';
	$html = '';
	if(isset($_SESSION['id'])){
		$id = $_SESSION['id'];
	

	$foro = Foro::foroUsuario($idUsuario);
	$html = '';
	if($foro){
	foreach($foro as $foro) {
		$html .= '<div class="listaForo">';
		$html .= visualizaForo($foro);     
		$html .= '<div class = "box">';

		if ($foro->getNombre() == $_SESSION['id']) {
			$html .= botonEditaForo($foro);
			$html .= botonEliminaForo($foro);
		}

		if (!Participantes::estaParticipandoEnForo($foro->getId(), $id)) {
			$html .= botonParticipar($foro);
		}
		else {
			$usuario = Usuario::buscaPorId($id);
			$html .= botonSalir($foro, $usuario);
			$html .= botonEntrarEnForo($foro); 
			$html .= botonParticipantes($foro);
		}
		$html .= '</div></div>';   
	} 
	$html .= botonBuscarPorFecha();
	$html .= botonBuscarPorTema();
	}
	else{
		$html .= sinForos();
	}
}
	return $html;
}

function listaForosPorFecha($fecha)
{
	$foro = Foro::buscarPorFecha($fecha);
	$html = '';
	if($foro){
		foreach($foro as $foro) {
			$html .= '<div class "listaForo">';
			$html .= visualizaForo($foro);     
			$html .= '<div class = "box">';
		
			if ($foro->getNombre() == $_SESSION['id']) {
				$html .= botonEditaForo($foro);
				$html .= botonEliminaForo($foro);
			}

			if (!Participantes::estaParticipandoEnForo($foro->getId(), $_SESSION['id'])) {
				$html .= botonParticipar($foro);
			}
			else {
				$usuario = Usuario::buscaPorId($_SESSION['id']);
				$html .= botonSalir($foro, $usuario);
				$html .= botonEntrarEnForo($foro); 
				$html .= botonParticipantes($foro);
			}
			$html .= '</div></div>';      
		} 
	}
	else{
		$html .= sinForos();
	}

	return $html;
}

function listaForosPorTema($tema)
{
	$foro = Foro::buscarPorTema($tema);
	$html = '';
	if($foro){
		foreach($foro as $foro) {
			$html .= '<div class = "listaForo">';
			$html .= visualizaForo($foro);     
			$html .= '<div class = "box">';
			if ($foro->getNombre() == $_SESSION['id']) {
				$html .= botonEditaForo($foro);
				$html .= botonEliminaForo($foro);
			}
			if (!Participantes::estaParticipandoEnForo($foro->getId(), $_SESSION['id'])) {
				$html .= botonParticipar($foro);
			}
			else {
				$usuario = Usuario::buscaPorId($_SESSION['id']);
				$html .= botonSalir($foro, $usuario);
				$html .= botonEntrarEnForo($foro); 
				$html .= botonParticipantes($foro);
			}
			$html .= '</div></div>';      
		} 
	}
	else{
		$html .= sinForos();
	}

	return $html;
}

function listaMensajesForo($idForo,$accesoNotificacion){
	$contenido = MensajesForo::listarMensajes($idForo);
	$foro = Foro::buscarForoPorId($idForo);

	if($accesoNotificacion){
		$notificaciones = Notificacion::buscarYEliminarNotificacionesForo($idForo);
	}

    $html = '';
	$html .= <<<EOS
	<h2>{$foro->getTema()}</h2>
	EOS;
    if($contenido){
        foreach($contenido as $contenido) {
            $html .= visualizaMensaje($contenido);
		
		} 
    }
    else{
        $html .= sinMensajes();
    }
    return $html;
}

function botonEliminaMensajeForo($contenido){
	return <<<EOS
	<form action="eliminarMensajeForo.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="idMensajeForo" value="{$contenido->getIdMensajeForo()}">
	<input class = "bevento" type= "image" src="../img/delete.png">
	</form>
	EOS;
}

function botonEditaMensajeForo($contenido){
	return<<<EOS
	<form action="modificarMensajeForo.php" method="post" enctype="multipart/form-data">
	<input  type="hidden" name="idMensajeForo" value = "{$contenido->getIdMensajeForo()}">
	<input class = "bevento" type= "image" src="../img/edit.png">
	</form>
	EOS;
}

function visualizaMensaje($contenido){
	$eliminar = '';
	$editar = '';

	if ($_SESSION['esAdmin']) {
		if($contenido->getIdUsuario() == $_SESSION['id']){
		$editar = botonEditaMensajeForo($contenido);
	}
		$eliminar = botonEliminaMensajeForo($contenido);
	}
	else if($contenido->getIdUsuario() == $_SESSION['id']){
		$editar = botonEditaMensajeForo($contenido);
		$eliminar = botonEliminaMensajeForo($contenido);		
	}

	$time = time_elapsed_string($contenido->getDate());
	$usuario = Usuario::buscaPorId($contenido->getIdUsuario());
    $html = '';
	
	$html .= <<<EOS
	<div class = 'mimensaje'>
	<div class = 'mensajeforo'>
	<p id = 'md'>{$usuario->getNombre()} @{$usuario->getNombreUsuario()} {$time}</p>
	<p>{$contenido->getContenido()}</p>
	</div>
	<div class = 'opciones'>
	{$editar}
	{$eliminar}
	</div>
	</div>
	EOS;
    return $html;   

}

function sinMensajes(){
    return <<<EOS
    <p>No hay mensajes para este foro</p>
    EOS; 
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






function sinForos(){
	return <<<EOS
	<p>No hay foros disponibles ahora mismo</p>
	EOS; 
}

function visualizaParticipantes($foro) {
	$html = '';
	$participantes = Participantes::buscaPorIdForo($foro);

	foreach($participantes as $participante) {
		$usuario = Usuario::buscaPorId($participante->getId());
		$html .= "<div class = 'box'>";
		$html .= visualizaImagenPerfil($usuario->getId());
		$html .= <<<EOS
		<a href='../personal/mostrarPerfil.php?id={$usuario->getId()}'>{$usuario->getNombreUsuario()} </a>
		</div>
		EOS;
	}

	return $html;
}

function visualizaForo($foro){
	$html = '';
	$html .= <<<EOS
	<p>Tema: {$foro->getTema()}</p>
	<p>Contenido del foro: {$foro->getContenido()}</p>
	<p>Fecha de creación: {$foro->getFecha()}</p>
	EOS;
	return $html;
}
 
function visualizaForoPorFecha($foro){
	return <<<EOS
	<p><Tema: {$foro->getTema()}</p>
	<p>Contenido: {$foro->getContenido()}</p>
	<p>Fecha: {$foro->getFecha()}</p>
	EOS;
}

function visualizaForoPorTema($foro){
	return <<<EOS
	<p><Tema: {$foro->getTema()}</p>
	<p>Contenido: {$foro->getContenido()}</p>
	<p>Fecha: {$foro->getFecha()}</p>
	EOS;
}

function sinParticipantesForo(){
    return <<<EOS
    <p>Actualmente no hay participantes en el foro</p>
    EOS; 
}

function botonParticipantes($foro){
    return <<<EOS
    <form action="participantesForo.php"method="post">
    <input  type="hidden" name="idForo" value = "{$foro->getId()}">
    <input class = "bevento" type= "image" src="../img/participantes.png">
    </form>
    EOS;
}

function botonSalir($foro, $usuario){
    return<<<EOS
    <form action="eliminarParticipanteForo.php"method="post">
    <input  type="hidden" name="idForo" value = "{$foro->getId()}">
    <input  type="hidden" name="idUsuario" value = "{$usuario->getId()}">
    <input class = "bevento" type= "image" src="../img/exit.png">
    </form>
    EOS;
}

function botonEliminaForo($foro){
	return <<<EOS
	<form action="eliminarForo.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="idForo" value="{$foro->getId()}">
	<input class = "bevento" type= "image" src="../img/delete.png">
	</form>
	EOS;
}
function botonParticipar($foro){
    return <<<EOS
	<form action="participarForo.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="idForo" value="{$foro->getId()}">
	<input class = "bevento" type= "image" src="../img/join.png">
	</form>
	EOS;
}
function botonEntrarEnForo($foro){
	
	return <<<EOS
	<form action="mensajesForo.php" method="get" enctype="multipart/form-data">
	<input type="hidden" name="idForo" value="{$foro->getId()}">
	<input class = "bevento" type= "image" src="../img/foro.png">
	</form>
	EOS;
}

function botonBuscarPorFecha()
{
	return <<<EOS
	<div><button><a class="boton" href="mostrarForoFecha.php">Buscar Foro por Fecha </a></button></div>
	EOS;
}

function botonBuscarPorTema()
{
	return <<<EOS
	<div><button><a class="boton" href="mostrarForoTema.php">Buscar Foro por Tema </a></button></div>
	EOS;
}

function botonEditaForo($foro){
	return<<<EOS
    <form action="modificarForo.php"method="post">
    <input  type="hidden" name="idForo" value = "{$foro->getId()}">
    <input class = "bevento" type= "image" src="../img/edit.png">
    </form>
    EOS;
}


