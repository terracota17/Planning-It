<?php
namespace es\ucm\fdi\aw;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;

class Calendario
{
    //Comprobar si asi se hace 
    public static function eliminarEvent($id){
        if (!$id) {
            return false; 
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        //$sqlDelete = sprintf("DELETE from tbl_events WHERE id='%d'",$id);
        $sqlDelete = sprintf("DELETE from tbl_events WHERE id='%d'",$id);


        $result = mysqli_query($conn, $sqlDelete);
       
        //echo mysqli_affected_rows($conn);

        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }
    public static function yaExiste($idEvento,$id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sqlQuery = sprintf("SELECT * FROM tbl_events  WHERE idUsuario='%d' AND idEvento = '%d'", $id,$idEvento);
        $result = mysqli_query($conn, $sqlQuery);
        if (  mysqli_num_rows($result) > 0) {
            return true;
        }
        return false;
    }
    public static function eliminarEventParticipacion($idEvento,$idUsuario){
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $sqlDelete = sprintf("DELETE from tbl_events WHERE idEvento='%d' AND idUsuario = '%d'  ",$idEvento,$idUsuario);


        $result = mysqli_query($conn, $sqlDelete);
       
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }


    public static function fetch(){


        $json = array();
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sqlQuery = sprintf("SELECT * FROM tbl_events  WHERE idUsuario='%d' ORDER BY id", $_SESSION['id']);

            
        $result = mysqli_query($conn, $sqlQuery);
        $eventArray = array();
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($eventArray, $row);
        }
        mysqli_free_result($result);


        return $eventArray;

    }
    public static function actualizarEvento($evento){

        $conn = Aplicacion::getInstance()->getConexionBd();

        $sqlAdd = sprintf("UPDATE tbl_events SET title='%s', start='%s', end='%s' WHERE id='%d'", $evento->getNombre(), $evento->getFecha(), $evento->getFecha() );

        $result = mysqli_query($conn, $sqlAdd);

        if (! $result) {
            $result = mysqli_error($conn);
            return false;
        }     
        
        return true;
    }
    
    public static function anhadirEvent($title, $start, $end, $idEvento)
    {
      $conn = Aplicacion::getInstance()->getConexionBd();

        $sqlAdd = sprintf("INSERT INTO tbl_events (title, start, end, idEvento, idUsuario) VALUES ( '%s', '%s', '%s', '%d' , '%d')",$title,$start,$end, $idEvento, $_SESSION['id']);

        $result = mysqli_query($conn, $sqlAdd);

        if (! $result) {
            $result = mysqli_error($conn);
            return false;
        }     
        
        return true;
    }

    public static function editEvent($idEvento, $start, $end,$title)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();

        $sqlUpdate = sprintf("UPDATE tbl_events SET start='%s', end='%s',title = '%s' WHERE idEvento='%d'" ,$start ,$end,$title, $idEvento );

        $result = mysqli_query($conn, $sqlUpdate);

        if (! $result) {
            $result = mysqli_error($conn);
            return false;
        }     
        
        return true;
    }
}
?>