<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/utils.php';

    $idNota=filter_input(INPUT_POST,'idNota',FILTER_SANITIZE_NUMBER_INT);
    if($idNota != null){
        if(isset($_SESSION['login']) && isset($_SESSION['id'])){
            $nota = es\ucm\fdi\aw\Nota\Nota::buscaPorId($idNota);
            if($nota){
                es\ucm\fdi\aw\Nota\Nota::borraNota($nota);
            }
        }
        else{
            echo "Error al borrar la nota";
        }   
    }
    header('Location: areapersonal.php');
    exit();
?>
