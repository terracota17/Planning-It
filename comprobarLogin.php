<?php
    use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
    require_once __DIR__.'/includes/config.php';

    $user = $_REQUEST["user"];
    $pass = $_REQUEST["pass"];

    $usuario = Usuario::checkLogin($user, $pass);

    if (!$usuario) {
        echo "error";
    } 
    else {
        echo "disponible";
    }
?>