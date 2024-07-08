<?php
namespace es\ucm\fdi\aw\Mensaje;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;

use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
use es\ucm\fdi\aw\Notificacion\Notificacion as Notificacion;


class Mensaje
{
    private function __construct($idMensaje = null, $idEmisor = null, $idRemitente = null, $fecha, $texto)
    {
        $this->idMensaje = $idMensaje;
        $this->idEmisor = $idEmisor;
        $this->idRemitente = $idRemitente;
        $this->fecha = $fecha;
        $this->texto = $texto;
    }
    
    public static function crea($idMensaje = null, $idEmisor = null, $idRemitente = null, $fecha, $texto ){
        
        $Mensaje = new Mensaje($idMensaje, $idEmisor, $idRemitente, $fecha, $texto);
        /**cada vez que creamos un mensaje en un chat crearemos una nueva notificacion en el remitente del mensaje */
        $usuario = Usuario::buscaPorId($idEmisor);
    
        $intro = 'Nuevo Mensaje de '. $usuario->getNombre();
        $m = $Mensaje->guarda();
        $textoNotificacion = '';
        Notificacion::insertaNotificacion($idEmisor,$idRemitente,$fecha, $texto, 0,'chat', null, $intro);
       
        return $m;
    }


    private  function guarda(){
        if ($this->idMensaje!==null) {
            return self::actualiza($this);
        }
        return self::insertaMensaje($this);
    }

    private static function actualiza($mensaje){
        $result = false;
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            $sql = sprintf("UPDATE Mensaje SET texto = '%s'WHERE idMensaje=%d"
            , $conn->real_escape_string($mensaje->texto)
            , $mensaje->idMensaje
            );
           
            if ( $conn->query($sql) ) {
                $mensaje->idMensaje = $conn->insert_id;
                $result = $mensaje; 
            }
            else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return  $result;
        }
    }

    public static function listarMensajes($idEmisor, $idRemitente) {
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Mensaje WHERE ((idEmisor ='%d') AND (idRemitente ='%d')) OR ((idRemitente ='%d') AND (idEmisor ='%d'))"
        , $conn->real_escape_string($idEmisor), $conn->real_escape_string($idRemitente), $conn->real_escape_string($idEmisor), $conn->real_escape_string($idRemitente));
        $rs = $conn->query($sql) ;
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Mensaje($row['idMensaje'], $row['idEmisor'], $row['idRemitente'], $row['fecha'], $row['texto']);
            }
            $rs->free();
        }
       
        return $resultado;
    }

    private static function insertaMensaje($Mensaje){
        $result = false;
      
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            
            $sql = sprintf("INSERT INTO Mensaje (idEmisor, idRemitente, fecha, texto) VALUES ('%s', '%s', '%s', '%s')"
            
            , $conn->real_escape_string($Mensaje->idEmisor)
            , $conn->real_escape_string($Mensaje->idRemitente)
            , $conn->real_escape_string($Mensaje->fecha)
            , $conn->real_escape_string($Mensaje->texto)
            );
            
            if ( $conn->query($sql) ) {
                $Mensaje->idMensaje = $conn->insert_id;
                $result = $Mensaje; 
            }
            else {
                
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        }
        return $result;
    }

    public static function eliminarMensaje($idMensaje){
        if (!$idMensaje) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("DELETE FROM Mensaje WHERE idMensaje = %d"  , $idMensaje);
   
        $result = mysqli_query($conn, $query);
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public function getId(){
        return $this->idMensaje;
    }
    public function getIdEmisor(){
        return $this->idEmisor;
    }
    public function getIdRemitente(){
        return $this->idRemitente;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getTexto(){
        return $this->texto;
    }

}?>
