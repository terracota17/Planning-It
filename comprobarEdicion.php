<?php
    use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
    require_once __DIR__.'/includes/config.php';

    $user = $_REQUEST["user"];

    $usuario = Usuario::buscaUsuario($user);

    if ($usuario && ($user != $_SESSION['nombreUsuario'])) {
        echo "existe";
    }
    else {
        echo "disponible";
    }
?>