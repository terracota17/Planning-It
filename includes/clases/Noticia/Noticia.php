<?php
namespace es\ucm\fdi\aw\Noticia;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;

class Noticia
{

    private function __construct($titulo, $cuerpo, $fecha, $categoria, $idNoticia = null)
    {
        $this->idNoticia = $idNoticia;
        $this->titulo = $titulo;
        $this->cuerpo = $cuerpo;
        $this->fecha = $fecha;
        $this->categoria = $categoria;
    }
	
    public static function buscarNoticia($titulo){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Noticias WHERE titulo='%s'", $conn->real_escape_string($titulo));
        $aux = $conn->query($sql);
        
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
                $Noticia = new Noticia($search['titulo'], $search['cuerpo'], $search['fecha'], $search['categoria'], $search['idNoticia']);
                $aux->free();
                return $Noticia;
            }
            $aux->free();
        }

        return false;
    }
    
    public static function buscaNoticiaId($idNoticia){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Noticias WHERE idNoticia='%s'", $idNoticia);
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
            $Noticia = new Noticia($search['titulo'],$search['cuerpo'],$search['fecha'], $search['categoria'], $search['idNoticia']);
            $aux->free();
            return $Noticia;
            }
            $aux->free();
            
        }
        return false;
    }

    public static function eliminarNoticia($idNoticia){
        if (!$idNoticia) {
            return false;
        } 
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("DELETE FROM Noticias WHERE idNoticia = %d"
            , $idNoticia
        );
        $result = mysqli_query($conn, $query);
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    public static function crea($titulo,$cuerpo,$fecha,$categoria,$idNoticia = null){
        $Noticia = new Noticia( $titulo,$cuerpo,$fecha,$categoria,$idNoticia);
        return $Noticia->guarda();
        
    }

    public static function Noticias(){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Noticias ";
        $rs = mysqli_query($conn, $sql) ;
        if ($rs) {
            
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Noticia($row['titulo'],$row['cuerpo'],$row['fecha'],$row['categoria'],$row['idNoticia']);
            }
            $rs->free();
        }
       
        return $resultado;
    }

    private  function guarda(){
        if($this->idNoticia!=null){
            return self::actualiza($this);
        }
        return self::insertaNoticia($this);
    }
    
    private static function actualiza($Noticia){
        $result = false;
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            
            $sql = sprintf("UPDATE Noticias SET titulo = '%s', cuerpo = '%s', fecha = '%s', categoria = '%s'WHERE idNoticia=%d"
           
            , $conn->real_escape_string($Noticia->titulo)
            , $conn->real_escape_string($Noticia->cuerpo)
            , $conn->real_escape_string($Noticia->fecha)
            , $conn->real_escape_string($Noticia->categoria)
            , $Noticia->idNoticia
            );
           
            if ( $conn->query($sql) ) {
                $Noticia->idNoticia = $conn->insert_id;
                $result = $Noticia; 
            }
            else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return  $result;
            }
    }
    private static function insertaNoticia($Noticia){
        $result = false;
      
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            
        $sql = sprintf("INSERT INTO Noticias (titulo, cuerpo, fecha, categoria) VALUES ( '%s', '%s', '%s', '%s')"
        
        , $conn->real_escape_string($Noticia->titulo)
        , $conn->real_escape_string($Noticia->cuerpo)
        , $conn->real_escape_string($Noticia->fecha)
        , $conn->real_escape_string($Noticia->categoria)
        );
       
        if ( $conn->query($sql) ) {
            $Noticia->idNoticia = $conn->insert_id;
            $result = $Noticia; 
        }
        else {
          
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        }
        return  $result;
    }

    public static function borraNoticia($idNoticia){
        if(!$idNoticia) return false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("DELETE FROM Noticias WHERE idNoticia = '%d'",$idNoticia);
        $result = mysqli_query($conn, $sql);  
        
        if (!$result) {
            
            error_log($conn->error);
        }
        else{
            return true;
        }
    }

    public static function buscarPorFecha($fecha = null){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        if($fecha !== null){
            $sql = sprintf("SELECT * FROM Noticias WHERE DATE(fecha)='%s'", $fecha);
        }
        $rs = mysqli_query($conn, $sql) ;
        if ($rs) {
            
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Noticia($row['titulo'],$row['cuerpo'],$row['fecha'],$row['categoria'],$row['idNoticia']);
            }
            $rs->free();
        }
       
        return $resultado;
    }

    public static function buscarPorCategoria($categoria = null){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        if($categoria !== null){
            $sql = sprintf("SELECT * FROM Noticias WHERE categoria='%s'", $categoria);
        }
        $rs = mysqli_query($conn, $sql) ;
        if ($rs) {
            
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Noticia($row['titulo'],$row['cuerpo'],$row['fecha'],$row['categoria'],$row['idNoticia']);
            }
            $rs->free();
        }
       
        return $resultado;
    }

    public function getTitular(){
        return $this->titulo;
    }
    public function getId(){
        return $this->idNoticia;
    }
    public function getCuerpo(){
        return $this->cuerpo;
    }
    public function getFecha(){
        return $this->fecha;
    }
    public function getCategoria(){
        return $this->categoria;
    }
    
}?>
