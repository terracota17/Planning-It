<?php
namespace es\ucm\fdi\aw\Evento;

use DateTime;
use es\ucm\fdi\aw\Aplicacion as Aplicacion;
use es\ucm\fdi\aw\Calendario as Calendario;

class Evento
{
    private function __construct($ubicacion, $informacion, $nombre, $fecha,$idEvento = null, $idUsuario = null, $estado = 1, $idForo = null)
    {
        $this->idEvento = $idEvento;
        $this->idForo = $idForo;
        $this->idUsuario = $idUsuario;
        $this->ubicacion = $ubicacion;
        $this->informacion = $informacion;
        $this->nombre = $nombre;
        $this->fecha = $fecha;
        $this->estado = $estado;
    }
    
    public static function buscarEvento($nombre){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Evento WHERE nombre='%s'", $conn->real_escape_string($nombre));
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
            $evento = new Evento($search['ubicacion'],$search['informacion'],$search['nombre'],$search['fecha'] ,$search['idEvento'],$search['idUsuario'],$search['estado'],$search['idForo']);
            $aux->free();
            return $evento;
            }
            $aux->free();
            
        }
        return false;
    }

    public static function buscarEventoPorId($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Evento WHERE idEvento='%s'", $conn->real_escape_string($id));
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
            $evento = new Evento($search['ubicacion'],$search['informacion'],$search['nombre'],$search['fecha'] ,$search['idEvento'],$search['idUsuario'],$search['estado'],$search['idForo']);
            $aux->free();
            return $evento;
            }
            $aux->free();
            
        }
        return false;
    }

    public static function borraPorIdUsuario($idUsuario){
        if (!$idUsuario) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("DELETE FROM Evento WHERE idUsuario = '%d'"
            , $idUsuario
        );
        $result = mysqli_query($conn, $query);
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function eliminarEvento($idEvento){
        if (!$idEvento) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("DELETE FROM Evento WHERE idEvento = %d"
            , $idEvento
        );
        $result = mysqli_query($conn, $query);
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }


    public static function buscarTBLEventPorId($id){
        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = sprintf("SELECT * FROM tbl_events WHERE id='%d'", $id);
        $rs = mysqli_query($conn, $sql) ;
        if($rs){
            $fila = mysqli_fetch_assoc($rs);
           
            return $fila['idEvento'];
        }
        return false;
    }

    public static function crea($ubicacion,$informacion,$nombre,$fecha,$idEvento = null,$estado = 1,$idForo = null){
        $evento = new Evento($ubicacion,$informacion,$nombre,$fecha,$idEvento,$_SESSION['id'],$estado,$idForo);
        $eventoo =  $evento->guarda();    

        

        return $eventoo;
    }

    public static function eventosUsuario($idUsuario = null){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Evento ";
        if($idUsuario!== null){
            $sql .= 'WHERE idUsuario = %d';
            $sql = sprintf($sql,$idUsuario);
        }
        $rs = mysqli_query($conn, $sql) ;
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Evento($row['ubicacion'],$row['informacion'],$row['nombre'],$row['fecha'],$row['idEvento'],$row['idUsuario'],$row['estado'],$row['idForo']);
            }
            $rs->free();
        }
       
        return $resultado;
    }

    public static function buscarPorFecha($fecha = null){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        if($fecha !== null){
            $sql = sprintf("SELECT * FROM Evento WHERE DATE(fecha)='%s'", $fecha);
        }
        $rs = mysqli_query($conn, $sql) ;
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Evento($row['ubicacion'],$row['informacion'],$row['nombre'],$row['fecha'],$row['idEvento'],$row['idUsuario'],$row['estado'],$row['idForo']);
            }
            $rs->free();
        }
       
        return $resultado;
    }

    private  function guarda(){
        if ($this->idEvento!==null) {
            
            Calendario::editEvent($this->getId(), $this->getFecha(), $this->getFecha(),$this->getNombre());
            return self::actualiza($this);
        }
        $value = self::insertaEvento($this);
        Calendario::anhadirEvent($this->getNombre(), $this->getFecha(), $this->getFecha(),  $this->getId());
        return $value;
    }
    public static function modificarFechaEventoPorId($start, $idEvento){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("UPDATE evento SET fecha = '%s' WHERE idEvento='%d'",$start ,$idEvento);
        $rs = mysqli_query($conn, $sql); 
        if($rs){
            return true;
        }

        return false;
    }
    private static function actualiza($evento){
        $result = false;
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            $sql = sprintf("UPDATE Evento SET  idUsuario = '%s',ubicacion = '%s', informacion = '%s', nombre = '%s', fecha = '%s'WHERE idEvento=%d"
            , $conn->real_escape_string($evento->idUsuario)
            , $conn->real_escape_string($evento->ubicacion)
            , $conn->real_escape_string($evento->informacion)
            , $conn->real_escape_string($evento->nombre)
            , $conn->real_escape_string($evento->fecha)
            , $evento->idEvento
            );
           
            if ( $conn->query($sql) ) {
                $evento->idEvento = $conn->insert_id;
                $result = $evento; 
            }
            else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return  $result;
        }
    }

    private static function insertaEvento($evento){
        $result = false;
      
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) { 
            $sql = sprintf("INSERT INTO Evento (idUsuario, idForo, ubicacion, informacion, nombre, fecha, estado) VALUES ( '%s', '%s', '%s', '%s', '%s', '%s', '%s')"
            , $conn->real_escape_string($evento->idUsuario)
            , $conn->real_escape_string($evento->idForo)
            , $conn->real_escape_string($evento->ubicacion)
            , $conn->real_escape_string($evento->informacion)
            , $conn->real_escape_string($evento->nombre)
            , $conn->real_escape_string($evento->fecha)
            , $conn->real_escape_string($evento->estado)
            );
        
            if ( $conn->query($sql) ) {
                $evento->idEvento = $conn->insert_id;
                $result = $evento; 
            }
            else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        }
        return  $result;
    }

    public static function borraEvento($idEvento){
        if(!$idEvento) return false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("DELETE FROM Evento WHERE idEvento = '%d'",$idEvento);
        $result = mysqli_query($conn, $sql);  
        
        if (!$result) {
            error_log($conn->error);
        }
        else{
            return true;
        }
    }

    public static function haFinalizado($evento) {
        $hoy = new DateTime();
        $fecha = new DateTime($evento->fecha);

        if ($fecha < $hoy) {
            $conn = Aplicacion::getInstance()->getConexionBd();
            if ($conn) {
                $sql = sprintf("UPDATE Evento SET estado = '%d' WHERE idEvento = '%d'", 0, $evento->idEvento);
                $result = mysqli_query($conn, $sql); 

                if (!$result) {
                    error_log("Error BD ({$conn->errno}): {$conn->error}");
                }
                else {
                    return true;
                }
            }
        }
        else {
            return false;
        }
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function getId(){
        return $this->idEvento;
    }
    public function getForoId(){
        return $this->idForo;
    }  
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    public function getUbi(){
        return $this->ubicacion;
    }
    public function getInfo(){
        return $this->informacion;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getEstado(){
        return $this->estado;
    }
    
}?>
