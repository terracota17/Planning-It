<?php
namespace es\ucm\fdi\aw\Foro;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;
use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
use es\ucm\fdi\aw\Notificacion\Notificacion as Notificacion;
use es\ucm\fdi\aw\Participantes as Participantes; 

class MensajesForo
{
    private function __construct($idForo,  $fecha, $contenido, $idUsuario = null,$idMensajeForo = null)
    {
        $this->idForo = $idForo;
        $this->idUsuario = $idUsuario;
        $this->contenido = $contenido;
        $this->fecha = $fecha;
        $this->idMensajeForo = $idMensajeForo;
    }
  
    public static function crea($idForo,$fecha,  $contenido, $idUsuario = null){
        
        $Mensaje = new MensajesForo($idForo, $fecha, $contenido, $idUsuario);
  
        $foro = Foro::buscarForoPorId($idForo);
        $nombreForo = $foro->getContenido();
        $nombreUsuario=Usuario::buscaPorId($_SESSION['id']);
      
        $nombreUsuarioResp = $nombreUsuario->getNombre();
        $nombre = '';
        $participantes = Participantes::buscaPorIdForo($idForo);
        $intro = 'Nuevo mensaje de @'.$nombreUsuarioResp.$nombre.' en el foro: ['.$nombreForo.']';
        foreach($participantes as $participantes){
            if( $participantes->getId() !== $_SESSION['id']){
                $recibirNotificaciones = Usuario::recibirNotificacionesPorId($participantes->getId());
                if($recibirNotificaciones){ 
                   
                    Notificacion::insertaNotificacionForo($_SESSION['id'],$participantes->getId(),$fecha, $contenido, 0, 'foro',$idForo, $intro);
                }
            }
            
        }
        
       
        return $Mensaje->guarda();
    }

    private  function guarda(){
        return self::insertaMensaje($this);
    }

    public static function listarMensajes($idForo) {
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
      
        $sql = sprintf("SELECT * FROM MensajeForo WHERE idForo ='%d'", $idForo);
        $rs = $conn->query($sql) ;
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new MensajesForo($row['idForo'],$row['fecha'], $row['contenido'], $row['idUsuario'],$row['idMensajeForo']);
            }
            $rs->free();
        }
       
        return $resultado;
    }

    private static function insertaMensaje($Mensaje){
        $result = false;
       
        $conn = Aplicacion::getInstance()->getConexionBd();
     
                
             $sql = sprintf("INSERT INTO MensajeForo(idForo, idUsuario, fecha, contenido) VALUES ('%d', '%d', '%s', '%s')"
                , $Mensaje->idForo
                , $Mensaje->idUsuario
                , $conn->real_escape_string($Mensaje->fecha)
                , $conn->real_escape_string($Mensaje->contenido)
            );
          
            if ($conn->query($sql) ) {
               
                $Mensaje->idMensajeForo = $conn->insert_id;
                $result = $Mensaje; 
            }
            else {
            
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
        
        return $result;
    }
    public static function borraMensaje($idMensajeForo){
        if (!$idMensajeForo) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM MensajeForo WHERE idMensajeForo = '%d'"
            , $idMensajeForo
        );
        $result = mysqli_query($conn, $query);
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    } 

    public static function buscarMensajeForoPorId($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM MensajeForo WHERE idMensajeForo = '%d'", $id);
        $aux = $conn->query($sql);

        $rs = mysqli_query($conn, $sql) ;
        if (mysqli_num_rows($rs )> 0) {
            $fila = mysqli_fetch_assoc($rs);
            $mensaje = new MensajesForo($fila['idForo'],$fila['fecha'], $fila['contenido'], $fila['idUsuario'],$fila['idMensajeForo']);
            $rs->free();
            return $mensaje;
        }

        return false; 
    }

    public static function actualizaContenido($idMensajeForo,$contenido){
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            $sql = sprintf("UPDATE MensajeForo SET contenido = '%s' WHERE idMensajeForo = '%d'"
            , $conn->real_escape_string($contenido)
            , $idMensajeForo
            );
           
            $rs = mysqli_query($conn, $sql);
    
            if ( !$rs ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            
            return $rs;
        }
    }


    public function getIdMensajeForo(){
        return $this->idMensajeForo;
    }
    public function getDate(){
        return $this->fecha;
    }
    public function getId(){
        return $this->idMensaje;
    }
    public function getIdForo(){
        return $this->idForo;
    }
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    public function getContenido(){
        return $this->contenido;
    }
    public function setContenido($idMensajeForo,$contenido){
        $this->contenido = $contenido;
        self::actualizaContenido($idMensajeForo,$contenido);
    }
}?>
