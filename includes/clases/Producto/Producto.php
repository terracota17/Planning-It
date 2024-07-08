<?php
namespace es\ucm\fdi\aw\Producto;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;

class Producto
{

    private function __construct($informacion, $nombre, $precio,$idProducto = null,$estado = "disponible")
    {
        $this->idProducto = $idProducto;
        $this->informacion = $informacion;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->estado = $estado;
    }
	
   
    public static   function anhadirProducto() {
        $html = '';
        if (isset($_SESSION['login'])){
            if (!isset($_SESSION['esAdmin']) || !$_SESSION['esAdmin']) { 
                return '';
            }
            else { 
               
                return " <a class='boton' href='../tienda/gestionarProductos.php'><img class = 'botonMas'src = '../img/mas.png' ></img></a>";
            }
        }

        return $html;
    }
    
    public static function buscaPorductoId($idProducto){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Producto WHERE idProducto='%s'", $idProducto);
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
            $Producto = new Producto($search['informacion'],$search['nombre'],$search['precio'] ,$search['idProducto'],$search['estado']);
            $aux->free();
            return $Producto;
            }
            $aux->free();
            
        }
        return false;
    }



    public static function crea($informacion,$nombre,$precio,$idProducto = null){
        $Producto = new Producto( $informacion,$nombre,$precio,$idProducto);
        return $Producto->guarda();
        
    }
    public static function buscarProductoGestion($nombre){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Producto WHERE nombre='%s' ", $conn->real_escape_string($nombre));
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
              $resultado[] = new Producto($search['informacion'], $search['nombre'], $search['precio'], $search['idProducto'],$search['estado']);
              $aux->free();
              return $resultado;
            }
            $aux->free();
        }
        return false;
    }
    public static function buscarProductoTienda($nombre){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Producto WHERE nombre='%s' AND estado = '%s' ", $conn->real_escape_string($nombre), "disponible");
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
              $resultado[] = new Producto($search['informacion'], $search['nombre'], $search['precio'], $search['idProducto'],$search['estado']);
              $aux->free();
              return $resultado;
            }
            $aux->free();
        }
        return false;
    }
    public static function Productos(){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql =  sprintf("SELECT * FROM Producto WHERE estado = '%s' ", "disponible");
        $rs = mysqli_query($conn, $sql) ;
        if ($rs) {
            
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Producto($row['informacion'],$row['nombre'],$row['precio'],$row['idProducto'],$row['estado']);
            }
            $rs->free();
        }
       
        return $resultado;
    }
    public static function todosProductos(){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Producto ";
        $rs = mysqli_query($conn, $sql) ;
        if ($rs) {
            
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Producto($row['informacion'],$row['nombre'],$row['precio'],$row['idProducto'],$row['estado']);
            }
            $rs->free();
        }
       
        return $resultado;
    }

    private  function guarda(){
        if($this->idProducto!==null){
            return self::actualiza($this);
        }
        return self::insertaProducto($this);
    }
    
    private static function actualiza($Producto){
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            
            $sql = sprintf("UPDATE Producto SET   informacion = '%s', nombre = '%s', precio = '%s'WHERE idProducto='%d'"
            , $conn->real_escape_string($Producto->informacion)
            , $conn->real_escape_string($Producto->nombre)
            , $conn->real_escape_string($Producto->precio)
            , $Producto->idProducto
            );
           
            if ( $conn->query($sql) ) {
                
                $Producto->idProducto = $conn->insert_id;
                $result = $Producto; 
            }
            else {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            }
            return  $result;
            }
    }
    private static function insertaProducto($Producto){
        $result = false;
      
        $conn = Aplicacion::getInstance()->getConexionBd();
        if ($conn) {
            
        $sql = sprintf("INSERT INTO Producto (  informacion, nombre, precio,estado) VALUES ( '%s', '%s', '%d','%s')"
        
        , $conn->real_escape_string($Producto->informacion)
        , $conn->real_escape_string($Producto->nombre)
        , $conn->real_escape_string($Producto->precio)
        , $Producto->estado
        );
       
        if ( $conn->query($sql) ) {
            $Producto->idProducto = $conn->insert_id;
            $result = $Producto; 
        }
        else {
          
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        }
        return  $result;
        

       
    }
    public static function descatalogaProducto($idProducto){
        if(!$idProducto) return false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("UPDATE Producto SET estado = '%s'WHERE idProducto=%d" , "descatalogado", $idProducto);
        $result = mysqli_query($conn, $sql);  
        
        if (!$result) {
            
            error_log($conn->error);
        }
        else{
            return true;
        }
    }
    public static function agregarProducto($idProducto){
        if(!$idProducto) return false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("UPDATE Producto SET estado = '%s'WHERE idProducto=%d" , "disponible", $idProducto);
        $result = mysqli_query($conn, $sql);  
        
        if (!$result) {
            
            error_log($conn->error);
        }
        else{
            return true;
        }
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function getId(){
        return $this->idProducto;
    }
    public function getInfo(){
        return $this->informacion;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function getEstado(){
        return $this->estado;
    }
    
}?>
