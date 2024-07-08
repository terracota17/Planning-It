<?php
namespace es\ucm\fdi\aw\Pedido;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;

use es\ucm\fdi\aw\Producto\Producto as Producto;

class Pedido
{
    private $idPedido;
    private $idUsuario;
    private $estado;
    private $precio;


   
    private function __construct ($idUsuario,$idPedido = null,$estado = "pendiente",$precio = null)
    {   $this->idPedido = $idPedido;
        $this->estado = $estado;
        $this->idUsuario = $idUsuario;
        $this->precio = $precio;
    }

    public static function crearPedido($idProducto,$cantidad,$idUsuario) {
        $pedido = self::pedidoPendiente($idUsuario);
        if($pedido){//comprueba si el usuario tiene un pedido pendiente, es decir, algo en el carrito
            
            $pedido->actualizaPedido($idProducto,$cantidad,$pedido,$idUsuario); // si teine algo en el carrito, lo añade
        }
        else{// si no, crea un pedido nuevo e itroduce el producto
            $pedido = new Pedido($idUsuario);
            $pedido->insertaPedido($pedido);
            $pedido->actualizaPedido($idProducto,$cantidad,$pedido,$idUsuario);
        }
        self::calculaPrecio($pedido);
    }

    public static function numProductosCarrito($idUsuario){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT idPedido FROM Pedido WHERE idUsuario='%d' AND estado = 'pendiente'", $idUsuario);
        $rs = $conn->query($query);
        if($rs){
            $search = $rs->fetch_assoc();
            if($search){
            $result = self::numProductosPedido($search['idPedido']);
            $rs->free();
            return $result;
            }
            $rs->free();
            
        }
        return false;
    }
    private static function numProductosPedido($idPedido){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM ContenidoPedidos WHERE idPedido='%d'", $idPedido);
        $rs = $conn->query($query);
        if($rs){
            $numrows = mysqli_num_rows($rs);
            return $numrows;
        }
        return false;
    }
    public static function calculaPrecio($Pedido){
        if($Pedido->getEstado() === "pendiente"){
         $coste = 0;
         $productos = self::ProductosPedido($Pedido);
          foreach($productos as $productos){
             $coste += $productos->getPrecio() * $Pedido->yaEnCarrito($productos->getId(),$Pedido->getId());
         }
          self::guardaPrecio($Pedido,$coste);
       }
        
    }
    private static function guardaPrecio($Pedido,$precio){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE Pedido SET precio = '%d' WHERE idPedido = '%d'"
            , $precio,$Pedido->getId()
            );

            if (mysqli_query($conn, $query)) {
                $Pedido->precio = $precio;
                return true;
            }else{
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            
            }
            return true;
    }
    public static function pagarPedido($idPedido){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE Pedido SET estado = '%s' WHERE idPedido = '%d'"
            , "Pagado",$idPedido
            );

            if (mysqli_query($conn, $query)) {
                
                return true;
            }else{
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            
            }
           
            return true;
    }
    public static function eliminaProducto($idPedido,$idProducto){
        $pedido = self::buscaPedidoId($idPedido);
        $pedido->eliminaContenido($pedido,$idProducto); //elimina el contenido de la tabla contenidopedidos
        if($pedido->pedidoVacio($pedido)){//comprueba si hay productos en el pedido 
            $pedido->borrarPedido($pedido->idPedido); // lo elimina en caso de no haber ningun producto
        }
        else{
            self::calculaPrecio($pedido);
        }
       
    }
    public static function borrarPedido($idPedido){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM ContenidoPedidos WHERE idPedido = '%d'", $idPedido);
        if (mysqli_query($conn, $query)) {
            
            $query = sprintf("DELETE FROM Pedido WHERE idPedido = '%d'", $idPedido);
            if (mysqli_query($conn, $query)) {
                return true;
            }
            else{
                error_log("Error BD ({$conn->errno}): {$conn->error}");
        
            }    
        }
        else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        } 
        
        
        return false;
    }
    public static function borrarPedidoVacio($idPedido){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Pedido WHERE idPedido = '%d'", $idPedido);
        if (mysqli_query($conn, $query)) {
            return true;
        }
        else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        } 
        
        return false;
    }
    public static function pedidoVacio($pedido){
       
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM ContenidoPedidos WHERE (idPedido ='%d')" , $pedido->idPedido);
        $result = mysqli_query($conn, $query);  
        if (mysqli_num_rows($result) > 0) {
            return false;
        }   
        return true;
    }
    public static function pedidoPendiente($idUsuario){
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Pedido WHERE (idUsuario ='%d') AND (estado = '%s')", $idUsuario, "pendiente");
        $result = mysqli_query($conn, $query);  
        if (mysqli_num_rows($result) > 0) {
            $fila = mysqli_fetch_assoc($result);
            $pedido = new Pedido($fila['idUsuario'],$fila['idPedido'],$fila['estado'],$fila['precio']);
            $result->free();
            return $pedido;
        }   
        return false;
    }
 

    private static function insertaPedido($pedido)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Pedido(idUsuario,estado,precio) VALUES ('%d','%s',0 )"
            , $pedido->idUsuario
            , $pedido->estado
        );
        if($conn->query($query)){
            $pedido->idPedido = $conn->insert_id;
            $pedido->precio = 0;
                }
        else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return true;
    }
    public static  function yaEnCarrito($idProducto,$idPedido){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT cantidad  FROM ContenidoPedidos WHERE idPedido = '%d' AND idProducto = '%d'"
            , $idPedido
            , $idProducto
         );
         $result = mysqli_query($conn, $query);        
         if (mysqli_num_rows($result) > 0) {
            $fila = mysqli_fetch_assoc($result);
            $aux = $fila['cantidad'];
          
            $result->free();
            return $aux;
        }   
        $result->free();
         return false;
    } 

    private static function añadircontenido($idProducto,$cantidad,$pedido,$idUsuario){
        $cantidadEnCarro = self::yaEnCarrito($idProducto,$pedido->idPedido);
        if(!$cantidadEnCarro){
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("INSERT INTO ContenidoPedidos(idPedido,idProducto,idUsuario,cantidad)  VALUES ('%d','%d','%d','%d')"
            , $pedido->idPedido
            , $idProducto
            , $idUsuario
            , $cantidad
        );
        }
        else{
            $cantidadEnCarro = $cantidadEnCarro + $cantidad;
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("UPDATE ContenidoPedidos SET cantidad = '%d' WHERE idProducto = '%d'"
            , $cantidadEnCarro,$idProducto
            );
        }
        if (mysqli_query($conn, $query)) {
            return true;
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        } 
        return true;
    }
    private static function actualizaPedido($idProducto,$cantidad,$pedido,$idUsuario)
    {
        $producto = Producto::buscaPorductoId($idProducto);
        if(!$producto){
            return false;
        }
        $pedido->añadircontenido($idProducto,$cantidad,$pedido,$idUsuario); 
        
        return false;
        
    }


    
    public static function PedidosUsuario($idUsuario){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Pedido WHERE idUsuario='%d'", $idUsuario);
        $aux = $conn->query($sql);
        if($aux){
            while ($row = mysqli_fetch_assoc($aux)) {
                $resultado[] =  new Pedido($row['idUsuario'],$row['idPedido'],$row['estado'] ,$row['precio']);
            }
            $aux->free();
        }
        return $resultado;
    }
    public static function ProductosPedido($Pedido){
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM ContenidoPedidos WHERE idPedido='%d'", $Pedido->getId());
        $aux = $conn->query($sql);
        if($aux){
            while ($row = mysqli_fetch_assoc($aux)) {
                $resultado[] = Producto::buscaPorductoId($row['idProducto']);
            }
            $aux->free();
        }
        return $resultado;
    }
    
  
    
    public static function buscaPedidoId($idPedido){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = sprintf("SELECT * FROM Pedido WHERE idPedido='%s'", $idPedido);
        $aux = $conn->query($sql);
        if($aux){
            $search = $aux->fetch_assoc();
            if($search){
            $Pedido = new Pedido($search['idUsuario'],$search['idPedido'],$search['estado'] ,$search['precio']);
            $aux->free();
            return $Pedido;
            }
            $aux->free();
            
        }
        return false;
    }
    public static function eliminaContenido($Pedido,$idProducto)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM ContenidoPedidos WHERE idPedido = %d AND idProducto = %d", $Pedido->idPedido,$idProducto);
        if (mysqli_query($conn, $query)) {

            return true;
        }
        else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        } 
        
        return false;
    }
    public function getId()
    {
         return $this->idPedido;
    }
    public function getEstado()
    {
         return $this->estado;
    }
    public function getPrecio()
    {
         return $this->precio;
    }
}

?>
