<?php
namespace es\ucm\fdi\aw\Notificacion;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;

class Notificacion
{
    private function __construct($idEmisor = null, $idRemitente = null, $fecha =  null , $texto = null, $idNotificacion , $idForo=null , $intro=null, $leida = null,$idPedido = null)
    {
        $this->idNotificacion = $idNotificacion; 
        $this->idPedido = $idPedido;
        $this->idForo = $idForo;
        $this->idEmisor = $idEmisor;
        $this->leida = $leida;
        $this->idRemitente = $idRemitente;
        $this->fecha = $fecha;
        $this->texto = $texto;
        $this->intro = $intro;
    }
    
    public static function crea($idEmisor = null, $idRemitente = null, $fecha = null, $texto = null, $idForo = null, $intro = null,$idPedido=null){
        $Notificacion = new Notificacion($idEmisor, $idRemitente, $fecha, $texto, $idForo,$idPedido);
        return $Notificacion->guarda();
    }

    private  function guarda(){
        return self::insertaNotificacion($this);
    }
    

    public static function borraNotificacion($idNotificacion){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Notificacion WHERE idNotificacion='%d'", $idNotificacion);
        $rs = $conn->query($query);
        if($rs){
            return true;
        }
        return false;
    }

    public static function numNotificaciones($idUsuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Notificacion WHERE idRemitente='%d' AND leida = 0", $idUsuario);
        $rs = $conn->query($query);
        if($rs){
            $numrows = mysqli_num_rows($rs);
            return $numrows;
        }
        return false;
    }
    public static function buscarPorId($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Notificacion WHERE idNotificacion='%d'", ($id));
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
                $notificacion = new Notificacion($search['idEmisor'],$search['idRemitente'],$search['fecha'],$search['texto'] ,$search['leida'],$row['idPedido']);
                $aux->free();
                return $notificacion;
            }
            $aux->free();
            
        }
        return false;
    }

    public static function getIntroNotificacion($idNotificacion){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Notificacion WHERE idNotificacion='%d'", $idNotificacion);
        $rs = $conn->query($query);
        if($rs){
            $fila = $rs->fetch_assoc();
            return $fila['intro'];
        }
        return false;
    }

    public static function buscarEventoPorId($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Evento WHERE idEvento='%d'", ($id));
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
                $notificacion = new Notificacion($search['idEvento'],$search['idUsuario'],$search['ubicacion'],$search['informacion'] ,$search['nombre'],$search['fecha']);
                $aux->free();
                return $notificacion;
            }
            $aux->free();
            
        }
        return false;
    }

    public static function buscarYEliminarNotificacionesChat($idEmisor){
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $sql = sprintf("SELECT * FROM Notificacion WHERE idEmisor='%d'", $idEmisor);
        $resultado = [];
        $rs =  $conn->query($sql);
        if($rs){
            while ($search = mysqli_fetch_assoc($rs)) {
               // $resultado = new Notificacion($search['idEmisor'] , $search['idRemitente'], $search['fecha'] , $search['texto'], $search['idNotificacion'] , $search['intro']);
                /**actualizaremos el campo leida la notificacion */
                Notificacion::eliminarNotificacion($search['idNotificacion']);
               // Notificacion::actualizarLeida($search['idNotificacion']);
               
            }
        
            $rs->free();
           
            return $resultado;
           
        }
        return false;
    }
    public static function EliminarNotificacionesPedido($idPedido){
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $sql = sprintf("SELECT * FROM Notificacion WHERE idPedido='%d'", $idPedido);

        $rs =  $conn->query($sql);
        if($rs){
            while ($search = mysqli_fetch_assoc($rs)) {
    
                Notificacion::eliminarNotificacion($search['idNotificacion']);
              return true;
            }
            $rs->free();
           
        }
        return false;
    }
    
    public static function buscarYEliminarNotificacionesForo($idForo){
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $sql = sprintf("SELECT * FROM Notificacion WHERE idForo='%d'", $idForo);
        $resultado = [];
        $rs =  $conn->query($sql);
        if($rs){
            while ($search = mysqli_fetch_assoc($rs)) {
               // $resultado = new Notificacion($search['idEmisor'] , $search['idRemitente'], $search['fecha'] , $search['texto'], $search['idNotificacion'] , $search['intro']);
                /**actualizaremos el campo leida la notificacion */
                Notificacion::eliminarNotificacion($search['idNotificacion']);
               // Notificacion::actualizarLeida($search['idNotificacion']);
               
            }
        
            $rs->free();
           
            return $resultado;
           
        }
        return false;
    }
    
    public static function actualizarLeida($idNotificacion){
        $conn = Aplicacion::getInstance()->getConexionBd();

        $sql = sprintf("UPDATE Notificacion SET leida = 1 WHERE idNotificacion='%d'", $idNotificacion);
        $rs =  $conn->query($sql);
        if($rs){
            return true;
        }

        return false;
    }

    

    public static function eliminarNotificacion($idN){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sqlEliminacion = sprintf("DELETE FROM Notificacion WHERE idNotificacion='%d'", $idN);
        $rs = $conn->query($sqlEliminacion);
        if($rs) return true;
        return false;
    }

    
    public static function insertaNotificacionForo($idEmisor=null,$idRemitente = null,$fecha = null, $texto, $leida, $tipo ,$idForo = null,  $intro){
        $result = false;
      
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            
            $sql = sprintf("INSERT INTO Notificacion (idEmisor, idRemitente, fecha, texto, leida, tipo, idForo, intro) VALUES ('%d', '%d', '%s', '%s', '%s', '%s', '%d', '%s')"        
            , $idEmisor
            , $idRemitente
            , $conn->real_escape_string($fecha)
            , $conn->real_escape_string($texto)
            , $conn->real_escape_string($leida)
            , $conn->real_escape_string($tipo)
            , $idForo
            , $conn->real_escape_string($intro)
            );

            $rs = $conn->query($sql);
            if($rs){
                return true;
            }
            return false;
        }
        
    }
    public static function insertaNotificacionPedido($idPedido,$idRemitente,$fecha , $texto, $leida, $tipo ,  $intro){
        $result = false;
      
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            
            $sql = sprintf("INSERT INTO Notificacion (idPedido, idRemitente, fecha, texto, leida, tipo,intro) VALUES ('%d', '%d', '%s', '%s', '%s', '%s','%s')"        
            , $idPedido
            , $idRemitente
            , $conn->real_escape_string($fecha)
            , $conn->real_escape_string($texto)
            , $conn->real_escape_string($leida)
            , $conn->real_escape_string($tipo)
            , $conn->real_escape_string($intro)
            );

            $rs = $conn->query($sql);
            if($rs){
                return true;
            }
            return false;
        }
        
    }

    public static function listarNotificacion($idRemitente) {
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Notificacion WHERE  idRemitente ='%d'",$idRemitente);
        $rs = $conn->query($sql) ;
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {         
                $resultado[] = new Notificacion($row['idEmisor'], $row['idRemitente'], $row['fecha'], $row['texto'], $row['idNotificacion'], $row['idForo'],$row['intro'],$row['leida'],$row['idPedido']);
            }
            $rs->free();
        }
       
        return $resultado;
    }
  

    
    public static function compruebaTipo($idNotificacion){
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Notificacion WHERE  idNotificacion ='%d'",$idNotificacion);
        $rs = $conn->query($sql);
        $fila = mysqli_fetch_assoc($rs);
        if ($rs) {
           
            if($fila['idForo'] == NULL){
                return $fila['idForo'];  /**si la notificacion el de un chat devolvera NULL */
            }else  {
                /**tipo de la notificacion : foro */
                return $fila['idForo'];
            }
            
        }

       
    }

    public static function actualizaNotificacion($idNotificacion){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("DELETE FROM Notificacion WHERE idNotificacion='%d'", $idNotificacion);
        $rs = $conn->query($sql);
        if($rs){
            return true;
        }
        return false;
    }
    
    public static function insertaNotificacion($idEmisor=null,$idRemitente = null,$fecha = null, $texto, $leida, $tipo ,$idForo = null, $intro ){
        $result = false;
      
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            
            $sql = sprintf("INSERT INTO Notificacion (idEmisor, idRemitente, fecha, texto, leida, tipo, intro) VALUES ('%d', '%d', '%s', '%s', '%s', '%s', '%s' )"        
            , $idEmisor
            , $idRemitente
            , $conn->real_escape_string($fecha)
            , $conn->real_escape_string($texto)
            , $conn->real_escape_string($leida)
            , $conn->real_escape_string($tipo)
            , $conn->real_escape_String($intro)

            );

            $rs = $conn->query($sql);
            if($rs){
                return true;
            }
            return false;
        }
        
    }

    
    public function getId(){
        return $this->idNotificacion;
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

    public function getIdForo(){
        return $this->idForo;
    }
    public function getIdPedido(){
        return $this->idPedido;
    }
    public function getIntro(){
        return $this->intro;
    }
}?>
