<?php
    require_once __DIR__.'/includes/config.php';
    
    unset($_SESSION['login']);
    unset($_SESSION['esAdmin']);
    unset($_SESSION['nombre']);
    unset($_SESSION['nombreUsuario']);

    session_destroy();
    
    $tituloPagina = 'Logout';
    $contenidoPrincipal = '';
    $contenidoPrincipal .= <<<EOS
    <div class = 'adios'>
    <h2>Hasta pronto!</h2>
    <p><a href="index.php">Volver al inicio</a></p>
    </div>
    EOS;

    require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';
    ?>