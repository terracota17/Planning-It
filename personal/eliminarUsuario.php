<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/utils.php';

    if(isset($_SESSION['login']) && isset($_SESSION['id'])){
       es\ucm\fdi\aw\Usuario\Usuario::borraUsuarioPorIdentificador($_SESSION['id']);
    }
    else{
        echo "Error al borrar";
    }   
    header('Location: ../logout.php');
    exit();
?>
