<?php
    require_once "../includes/config.php";
    require_once __DIR__.'/../includes/utils.php';

    use es\ucm\fdi\aw\Calendario as Calendario;
    
  

   
    $eventArray = Calendario::fetch();
   


    echo json_encode($eventArray);
  
?>