<?php
    require_once __DIR__.'/../includes/config.php';

	$tituloPagina = 'Configuración';
	$contenidoNota1 = '';
	$contenidoNota2 = '';
	$contenidoNota3 = '';
	$contenidoNota1 .= <<<EOS
	<div class = "box">
	<h1>¿Desea recibir notificaciones de los eventos participados?</h1>
	<form action = "configUsuarioNotificaciones.php" method="POST">
	<label class="switch">
	<input type="checkbox">
	<span class="slider"></span>
	</label>
	</div>
	<input class = "enviarFormNotificaciones" type = "submit" value = "Aplicar"></input>
	</form>
	<form action="eliminarUsuario.php">
	<input class = "eliminarUsuario" type="submit" name="eliminar" value="Eliminar cuenta" />
	</form>
	EOS;

    require_once __DIR__.'/../includes/vistas/plantillas/plantillaAreaPersonal.php';
?>