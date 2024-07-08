<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/vistas/helpers/noticia.php';

$idNoticia= filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);

$form = new es\ucm\fdi\aw\Noticia\FormularioNoticia($idNoticia);
$htmlFormNoticia = $form->gestiona();

$tituloPagina = 'Noticias';
$contenidoPrincipal = ''; 
$contenidoNoticia = '';

$contenidoPrincipal = <<<EOS
<h2>Noticias</h2>
EOS;
$contenidoPrincipal .= listaNoticias();

$contenidoNoticia = <<<EOS
<h2>Modifica aquí</h2>
$htmlFormNoticia
EOS;

require_once __DIR__.'/../includes/vistas/plantillas/plantillaNoticias.php';
