<?php
use es\ucm\fdi\aw\Noticia\Noticia as Noticia;
use es\ucm\fdi\aw\Imagen as Imagen;

function verNoticia($idNoticia){
	$noticia = Noticia::buscaNoticiaId($idNoticia);
	$html = '';
	$html .= visualizaNoticia($noticia);
				
	if(!isset($_SESSION['esAdmin']) || !$_SESSION['esAdmin']){
		$html .= '';
	}
	else {
		/*Es administrador*/
		$html .= botonEditarNoticia($idNoticia);
		$html .= botonSubirImagenNoticia($idNoticia);
		$html .= botonEliminarNoticia($idNoticia);
	}

	return $html;
}

function listaNoticias()
{
	$Noticia = Noticia::Noticias();
	$html = '';

	$html .= '<div class = "noticias">';
	$html .= botonBuscarPorFecha();
	$html .= botonBuscarPorCategoria();

	if (!isset($_SESSION['esAdmin']) || !$_SESSION['esAdmin']) { 
		$html .= '';
	}
	else { 
		$html .= botonCreaNoticia();
	}
	$html .= '</div>';

	if($Noticia){
		$html .= '<div class = "news">';
		foreach($Noticia as $Noticia) {
			$html .= '<a class = "linkNoticia" href="verNoticia.php?id={';
			$html .= $Noticia->getId();
			$html .= '}">';
			$imagen = Imagen::buscarImagenNoticiaPorId($Noticia->getId());
			$html .= '<div class = "noticia" style="background-image: url(';
			$html .= $imagen;
			$html .= ');">';
			$html .= visualizaResumenNoticia($Noticia);
			$html .= <<<EOS
			</div>
			</a>
			EOS;
		}
		$html .= '</div>';
	}
	else{
		$html .= sinNoticias();
	}

	return $html;
}

function botonCreaNoticia(){
    return <<<EOS
    <div>
    <button id="buscar" onclick="location.href='crearNoticia.php'" type="button">Crear nueva noticia</button>
    </div>
    EOS;
}

function botonSubirImagenNoticia($idNoticia){
	return <<<EOS
	<div class = "formSubidaImagenNoticia">
	<form action="subirImagenNoticia.php" method="post" enctype="multipart/form-data">
	<input type="hidden" name="idNoticia" value = "{$idNoticia}">
	<input type="file" name="file"/>
	<input class = "buttonupload" type="submit" name="submit" value="Upload">
	</form>
	</div>
	EOS;
}

function botonEditarNoticia($idNoticia){
    return<<<EOS
    <form action="editarNoticia.php"method="post">
    <input  type="hidden" name="id" value = "{$idNoticia}">
    <input  type= "submit" value="Editar">
    </form>
    EOS;
}

function botonEliminarNoticia($idNoticia){
	return <<<EOS
	<form action="eliminarNoticia.php" method = "post">
	<input  type="hidden" name="idNoticia" value = "{$idNoticia}">
	<input  type= "submit" value="Eliminar">
	</form>
	EOS;
}

function sinNoticias(){
	return <<<EOS
	<p>No es posible mostrar noticias actualmente </p>
	EOS; 
}

function visualizaResumenNoticia($Noticia){
	$html = '';
	$html .= <<<EOS
	<p>{$Noticia->getFecha()}</p>
	<h2>{$Noticia->getTitular()}</h2>
	EOS;

	if ($Noticia->getCategoria() == "deportes") {
		$html .= '<p style="width:fit-content;border-width:1px;border-radius:5px;background-color:orange;border-color:orange;padding:3px;">Deportes</p>';
	}
	else if ($Noticia->getCategoria() == "politica") {
		$html .= '<p style="width:fit-content;border-width:1px;border-radius:5px;background-color:green;border-color:green;padding:3px;">Política</p>';
	}
	else if ($Noticia->getCategoria() == "comida") {
		$html .= '<p style="width:fit-content;border-width:1px;border-radius:5px;background-color:yellow;border-color:yellow;padding:3px;">Comida</p>';
	}
	else {
		$html .= '<p style="width:fit-content;border-width:1px;border-radius:5px;background-color:blue;border-color:blue;padding:3px;">Educación</p>';
	}

	return $html;
}

function visualizaNoticia($Noticia){
	$html = '';

	$imagen = Imagen::buscarImagenNoticiaPorId($Noticia->getId());
	$html  = '';
	if($imagen){
		$html .= <<<EOS
		<div><img id = "imagenNoticia" src = {$imagen}></div>
		EOS;
	}else{
		$html .= <<<EOS
		<div><img id = "imagenNoticia" src = "../img/sinImagenNoticia.png"></div>
		EOS;
	}

	$html .= <<<EOS
	<h2>{$Noticia->getTitular()}</h2>
	<p>{$Noticia->getFecha()}</p>
	EOS;

	if ($Noticia->getCategoria() == "deportes") {
		$html .= '<p style="width:fit-content;border-width:1px;border-radius:5px;background-color:orange;border-color:orange;padding:3px;">Deportes</p>';
	}
	else if ($Noticia->getCategoria() == "politica") {
		$html .= '<p style="width:fit-content;border-width:1px;border-radius:5px;background-color:green;border-color:green;padding:3px;">Política</p>';
	}
	else if ($Noticia->getCategoria() == "comida") {
		$html .= '<p style="width:fit-content;border-width:1px;border-radius:5px;background-color:yellow;border-color:yellow;padding:3px;">Comida</p>';
	}
	else {
		$html .= '<p style="width:fit-content;border-width:1px;border-radius:5px;background-color:blue;border-color:blue;padding:3px;">Educación</p>';
	}

	$html .= <<<EOS
	<p>{$Noticia->getCuerpo()}</p>
	EOS;
	return $html;
}

function botonBuscarPorFecha()
{
    return <<<EOS
    <div>
    <button id="buscar" onclick="location.href='mostrarNoticiasFecha.php'" type="button">Buscar Noticia por Fecha</button>
    </div>
    EOS;
}

function botonBuscarPorCategoria()
{
    return <<<EOS
    <div>
    <button id="buscar" onclick="location.href='mostrarNoticiasCategoria.php'" type="button">Buscar Noticia por Categoria</button>
    </div>
    EOS;
}

function listaNoticiasPorFecha($fecha)
{
    $Noticia = Noticia::buscarPorFecha($fecha);
    $html = '';

	$html .= '<div class = "noticias">';
	$html .= botonBuscarPorFecha();
	$html .= botonBuscarPorCategoria();

	if (!isset($_SESSION['esAdmin']) || !$_SESSION['esAdmin']) { 
		$html .= '';
	}
	else { 
		$html .= botonCreaNoticia();
	}
	$html .= '</div>';

    if($Noticia){
		$html .= '<div class = "news">';
        foreach($Noticia as $Noticia) {
			$html .= '<a class = "linkNoticia" href="verNoticia.php?id={';
			$html .= $Noticia->getId();
			$html .= '}">';
			$imagen = Imagen::buscarImagenNoticiaPorId($Noticia->getId());
			$html .= '<div class = "noticia" style="background-image: url(';
			$html .= $imagen;
			$html .= ');">';
			$html .= visualizaResumenNoticia($Noticia);
			$html .= <<<EOS
			</div>
			</a>
			EOS;        
        } 
		$html .= '</div>';
    }
    else{
        $html .= sinNoticias();
    }

    return $html;
}

function listaNoticiasPorCategoria($categoria)
{
    $Noticia = Noticia::buscarPorCategoria($categoria);
    $html = '';

	$html .= '<div class = "noticias">';
	$html .= botonBuscarPorFecha();
	$html .= botonBuscarPorCategoria();

	if (!isset($_SESSION['esAdmin']) || !$_SESSION['esAdmin']) { 
		$html .= '';
	}
	else { 
		$html .= botonCreaNoticia();
	}
	$html .= '</div>';

    if($Noticia){
		$html .= '<div class = "news">';
        foreach($Noticia as $Noticia) {
			$html .= '<a class = "linkNoticia" href="verNoticia.php?id={';
			$html .= $Noticia->getId();
			$html .= '}">';
			$imagen = Imagen::buscarImagenNoticiaPorId($Noticia->getId());
			$html .= '<div class = "noticia" style="background-image: url(';
			$html .= $imagen;
			$html .= ');">';
			$html .= visualizaResumenNoticia($Noticia);
			$html .= <<<EOS
			</div>
			</a>
			EOS;        
        } 
		$html .= '</div>';
    }
    else{
        $html .= sinNoticias();
    }

    return $html;
}