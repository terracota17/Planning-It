<?php
    require_once __DIR__.'/../includes/config.php';
    require_once __DIR__.'/../includes/vistas/helpers/notas.php';
    
    $tituloPagina = 'Notas';
    $contenidoNota2 = '';
    $contenidoNota1 = '';

    if( isset($_SESSION['login'])  &&  $_SESSION['login'] === true){
        $contenidoNota1 = ' <a class="boton" href="CrearNota.php"><img class = "botonMas" src = "../img/mas.png" ></img></a>';
        $contenidoNota2 .= listaNotas($_SESSION['id']);
    }
    else{
        $contenidoNota2 .=  "<p>Inicia sesion para ver tus notas</p>";     
    }

  // require_once __DIR__.'/../includes/vistas/plantillas/plantillaAreaPersonal.php';
?>