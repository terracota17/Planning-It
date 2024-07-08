<?php
 namespace es\ucm\fdi\aw\Nota;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;

class Nota
{
    private $idNota;

    private $idUsuario;

    private $informacion;

    private function __construct($idUsuario, $informacion,$idNota = null)
    {
        $this->idUsuario = $idUsuario;
        $this->informacion = $informacion;
        $this->idNota = $idNota;
    }


    public static function buscaPorId($idNota)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Nota WHERE idNota=%d", $idNota);
        $result = mysqli_query($conn, $query);  
        if (mysqli_num_rows($result) > 0) {
            $fila = mysqli_fetch_assoc($result);
            $nota = new Nota($fila['idUsuario'], $fila['informacion'],$fila['idNota']);
            $result->free();

            return $nota;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function actualiza($idNota, $informacion)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Nota SET informacion='%s' WHERE idNota='%d'",$conn->real_escape_string($informacion), $idNota);
        $rs = mysqli_query($conn, $query);
        if ( !$rs ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $rs;
    }

    public static function creaNota($idUsuario, $informacion){
        $nota = new Nota($idUsuario, $informacion);
        return $nota->guardaNota();
    }

    public function guardaNota()
    {
        return self::insertaNota($this);
    }

    private static function insertaNota($nota)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Nota(idUsuario, informacion) VALUES ('%d', '%s')"
            , $conn->real_escape_string($nota->idUsuario)
            , $conn->real_escape_string($nota->informacion)
        );
        
        if (mysqli_query($conn, $query)) {
            $nota->idNota = $conn->insert_id;
            return $nota;
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        } 
        
        return false;
    }

    public static function unaNota($idNota ){
    
        $conn = Aplicacion::getInstance()->getConexionBd();
        if($idNota !== null){
            $sql = sprintf("SELECT * FROM Nota WHERE idNota = %d",$idNota);
        }
    
        $rs = mysqli_query($conn, $sql) ;
        if (mysqli_num_rows($rs )> 0) {
            $fila = mysqli_fetch_assoc($rs);
            $nota = new Nota($_SESSION['id'], $fila['informacion']);
    
            $rs->free();
            return $nota;
        }
    }


    public static function notasUsuario($idUsuario = null){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Nota ";
        if($idUsuario !== null){
           
            $sql .= 'WHERE idUsuario = %d';
            $sql = sprintf($sql,$idUsuario);
        }
        $rs = mysqli_query($conn, $sql) ;
        if ($rs) {
            
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Nota($row['idUsuario'],$row['informacion'],$row['idNota']);
            }
            $rs->free();
        }
       
        return $resultado;
    }

    public static function borraNota($nota){
        return $nota->borraPorIdNota($nota->getId());
    }

    private static function borraPorIdNota($idNota){
        if (!$idNota) {
            return false;
        }
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Nota WHERE idNota = %d"
            , $idNota
        );
        $rs = mysqli_query($conn, $query);
        if (!$rs) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }  

        return true;
    }

    public function getId(){
        return $this->idNota;
    }
    public function getInfo(){
        return $this->informacion;
    }

    public function setInformacion($idNota,$informacion){
        $this->informacion = $informacion;
        self::actualiza($idNota,$informacion);
    }
}?>
