<?php
namespace es\ucm\fdi\aw\Foro;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;

class Foro {

    private $idUsuario; 
    private $fecha;
    private $tema;
    private $contenido;
    private $idForo;

    public function __construct($idUsuario, $fecha, $tema, $contenido, $idForo = null) {
        $this->fecha = $fecha;
        $this->tema = $tema; 
        $this->contenido = $contenido;
        $this->idUsuario = $idUsuario;
        $this->idForo = $idForo;
    }

    public static function buscarForo($tema){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Foro WHERE tema='%s'", $conn->real_escape_string($tema));
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
            $evento = new Foro($search['idUsuario'],$search['fecha'],$search['tema'],$search['contenido'],$search['idForo']);
            $aux->free();
            return $evento;
            }
            $aux->free();
            
        }
        return false;
    }

    public static function buscarForoPorId($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Foro WHERE idForo='%s'", $conn->real_escape_string($id));
        $aux = $conn->query($sql);

        $rs = mysqli_query($conn, $sql) ;
        if (mysqli_num_rows($rs )> 0) {
            $fila = mysqli_fetch_assoc($rs);
            $foro = new Foro($fila['idUsuario'],$fila['fecha'],$fila['tema'],$fila['contenido'],$id);
            $rs->free();
            return $foro;
        }

        return false; 
    }

    public static function borraPorIdUsuario($idUsuario){
        if (!$idUsuario) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("DELETE FROM Foro WHERE idUsuario = '%d'"
            , $idUsuario
        );
        $result = mysqli_query($conn, $query);
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function eliminarForo($idForo){
        if (!$idForo) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("DELETE FROM Foro WHERE idForo = %d"
            , $idForo
        );
        $result = mysqli_query($conn, $query);
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }


    public static function crearForo($idUsuario, $fecha, $tema, $contenido) {
        $foro = new Foro($idUsuario, $fecha, $tema, $contenido);
        return $foro->guarda();
    }

    //Te muestra los foros donde ah participado el usuario
    public static function foroUsuario($idUsuario = null){
    $resultado = [];
    $conn = Aplicacion::getInstance()->getConexionBd();
    $sql = "SELECT * FROM Foro ";
    if($idUsuario!== null){
       
        $sql .= 'WHERE idUsuario = %d';
        $sql = sprintf($sql,$idUsuario);
    }
    $rs = mysqli_query($conn, $sql) ;
    if ($rs) {
        
        while ($row = mysqli_fetch_assoc($rs)) {
            $resultado[] = new Foro($row['idUsuario'],$row['fecha'],$row['tema'],$row['contenido'],$row['idForo']);
        }
        $rs->free();
    }
   
    return $resultado;
}

/////// lo de buscar por fecha y tema, osea buscar por tema es asi pero buscar por fecha tenemos que asociar la fecha a la fecha del dispositivo cuando se 
////// crea el foro sooo eso osea es igual solo que la fecha no la escribimos como en evento sino que la cogemso directamente q no se como hacerlo

public static function buscarPorFecha($fecha = null){
    $resultado = [];
    $conn = Aplicacion::getInstance()->getConexionBd();
    if($fecha !== null){
        $sql = sprintf("SELECT * FROM Foro WHERE DATE(fecha)='%s'", $fecha);
    }
    $rs = mysqli_query($conn, $sql) ;
    if ($rs) {
        
        while ($row = mysqli_fetch_assoc($rs)) {
            $resultado[] = new Foro($row['idUsuario'],$row['fecha'],$row['tema'],$row['contenido'],$row['idForo']);
        }
        $rs->free();
    }
   
    return $resultado;
}

public static function buscarPorTema($tema){
    $resultado = [];
    $conn = Aplicacion::getInstance()->getConexionBd();
    if($tema !== null){
        $sql = sprintf("SELECT * FROM Foro WHERE tema ='%s'", $tema);
    }
    $rs = mysqli_query($conn, $sql) ;
    if ($rs) {
        
        while ($row = mysqli_fetch_assoc($rs)) {
            $resultado[] = new Foro($row['idUsuario'],$row['fecha'],$row['tema'],$row['contenido'],$row['idForo']);
        }
        $rs->free();
    }
   
    return $resultado;
}

private  function guarda(){
    return self::insertaForo($this);
}
 
public static function actualizaTema($idForo,$tema){
    $conn = Aplicacion::getInstance()->getConexionBd();
    if ($conn) {
        $sql = sprintf("UPDATE Foro SET  tema = '%s' WHERE idForo=%d"
        , $conn->real_escape_string($tema)
        , $idForo
        );
       
        $rs = mysqli_query($conn, $sql);

        if ( !$rs ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return  $rs;
    }
}

public static function actualizaContenido($idForo,$contenido){
    $conn = Aplicacion::getInstance()->getConexionBd();
    if ($conn) {
        $sql = sprintf("UPDATE Foro SET  contenido = '%s' WHERE idForo=%d"
        , $conn->real_escape_string($contenido)
        , $idForo
        );
       
        $rs = mysqli_query($conn, $sql);

        if ( !$rs ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        
        return $rs;
    }
}


private static function insertaForo($foro){
    $result = false;
  
    $conn = Aplicacion::getInstance()->getConexionBd();
    if ($conn) {
    $sql = sprintf("INSERT INTO Foro (idUsuario, fecha, tema, contenido) VALUES ( '%d', '%s', '%s', '%s')"
    , $foro->idUsuario
    , $conn->real_escape_string($foro->fecha)
    , $conn->real_escape_string($foro->tema)
    , $conn->real_escape_string($foro->contenido)
    );
   
    if ( $conn->query($sql) ) {
        $foro->idForo = $conn->insert_id;
        $result = $foro; 
    }
    else {
      
        error_log("Error BD ({$conn->errno}): {$conn->error}");
    }
    }
    return  $result;
}

public static function borraForo($idForo){
    if(!$idForo) return false;
    $conn = Aplicacion::getInstance()->getConexionBd();
    $sql = sprintf("DELETE FROM Foro WHERE idForo = '%d'",$idForo);
    $result = mysqli_query($conn, $sql);  
    
    if (!$result) {
        
        error_log($conn->error);
    }
    else{
        return true;
    }
}

    public function getNombre(){
        return $this->idUsuario;
    }

    public function getTema(){
        return $this->tema;
    }
    public function getContenido(){
        return $this->contenido;
    }
    public function getId(){
        return $this->idForo;
    }
    public function getFecha(){
        $timestamp = strtotime($this->fecha);
        return date("d-m-Y h:i:s", $timestamp);
    }

    public function setTema($idForo,$tema){
        $this->tema = $tema;
        self::actualizaTema($idForo,$tema);
    }
    public function setContenido($idForo,$contenido){
        $this->contenido = $contenido;
        self::actualizaContenido($idForo,$contenido);
    }

}