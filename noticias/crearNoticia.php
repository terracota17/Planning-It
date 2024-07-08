<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/noticia.php';

    $form = new es\ucm\fdi\aw\Noticia\FormularioNoticia();
    $htmlFormNoticia = $form->gestiona();

    $tituloPagina = 'Noticia';
    $contenidoPrincipal = '';
    $contenidoPrincipal = <<<EOS
    <h2>Noticias</h2>
    EOS;
    $contenidoPrincipal .= listaNoticias();
    $contenidoNoticia = '';

    if(isset($_SESSION['id'])){
        if (($_SESSION['esAdmin'])){
            $contenidoNoticia .= <<<EOS
            <h1>Crear una noticia nueva</h1>
            $htmlFormNoticia
            EOS;
        }
        else{
            $contenidoNoticia .=<<<EOS
            <h1>Area Restringida a los Usuarios  (Salga de Aqui)  :)</h1>
            <img class = "NotAdmin" src = "../img/NotEvenAnAdmin.jpg">
            EOS;
        }
    }
    else{
        $contenidoPrincipal .=<<<EOS
        <h2>Inicie Sesion para acceder a esta seccion</h2>
        EOS;
    }

    require_once __DIR__.'/../includes/vistas/plantillas/plantillaNoticias.php';