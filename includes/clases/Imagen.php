<?php
namespace es\ucm\fdi\aw;

class Imagen
{
    private $id;

    private $idUsuario;

    private $nombre;

    private function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public static function creaImagenUsuario($idUsuario){
        $imagen = new Imagen($idUsuario);
        return $imagen->guardaImagenUsuario($idUsuario);
    }

    public static function buscarImagen($idUsuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT * FROM images WHERE idUsuario=".$idUsuario;
        $result = mysqli_query($conn, $query);
        $imageURL = '';
        if(mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()){
                if($row["idEvento"] === NULL && $row["idProducto"] === NULL && $row["idNoticia"] === NULL){ 
                     $imageURL = 'uploads/'.$row["nombre"];
                }
            }
            $result->free();

            return $imageURL;
        }
        else {
            return false;
        }
    }
    public static function insertarImagenEvento($idEvento, $fileName){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = 
                sprintf("INSERT INTO images (idUsuario, nombre, idEvento) VALUES ('%d','%s', '%d')", $_SESSION['id'], $fileName, $idEvento);
                $result = mysqli_query($conn, $query);  
                if($result) {
                   
                        return true;
                }

                return false;
    }

    public static function insertarImagenProducto($idProducto, $fileName){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = 
                sprintf("INSERT into images (idUsuario, nombre, idProducto) VALUES ('%d','%s', '%d')", $_SESSION['id'], $fileName, $idProducto);
                $result = mysqli_query($conn, $query);  
                if($result) {
                        return true;
                }

                return $result;
    }

    public static function insertarImagenUsuario($fileName){
        $conn = Aplicacion::getInstance()->getConexionBd();

        $qr = "SELECT * FROM images WHERE idUsuario=".$_SESSION['id'];
        $rs = mysqli_query($conn, $qr);
    
        $rs->free();
        $query = "INSERT into images (idUsuario, nombre) VALUES ('".$_SESSION['id']."','".$fileName."')";
        $result = mysqli_query($conn, $query);
        if($result) {
            return true;
        }

    }

    public static function buscarImagenEventoPorId($idEvento) {
        $conn = Aplicacion::getInstance()->getConexionBd();

      $query = sprintf("SELECT nombre FROM images WHERE idEvento='%d'", $idEvento);
      $result = mysqli_query($conn, $query);  
        
        if(mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()){
                $imageURL = '../uploads/'.$row["nombre"];
            }
            $result->free();

            return $imageURL;
        }
        else {
            return false;
        }
    }

    public static function buscarImagenNoticiaPorId($idNoticia) {
        $conn = Aplicacion::getInstance()->getConexionBd();

      $query = sprintf("SELECT nombre FROM images WHERE idNoticia='%d'", $idNoticia);
      $result = mysqli_query($conn, $query);  
        
        if(mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()){
                $imageURL = '../uploads/'.$row["nombre"];
            }
            $result->free();

            return $imageURL;
        }
        else {
            return false;
        }
    }

    public static function buscarImagenProductoPorId($idProducto) {
        $conn = Aplicacion::getInstance()->getConexionBd();

      $query = sprintf("SELECT * FROM images WHERE idProducto='%d'", $idProducto);
      $result = mysqli_query($conn, $query);  
        
        if(mysqli_num_rows($result) > 0) {
            while($row = $result->fetch_assoc()){
                
                    if($row["idEvento"] === NULL){
                        $imageURL = '../uploads/'.$row["nombre"];
                    }
            }
            $result->free();

            return $imageURL;
        }
        else {
            return false;
        }
    }

    public function guardaImagenUsuario($idUsuario)
    {
        return self::insertaImagenUsuario($idUsuario);
    }

    public static  function guardaImagenProducto($idProducto, $imagen)
    {
        return self::insertaImagenProducto($idProducto, $imagen);
    }
    

    private static function insertaImagenProducto($idProducto, $imagen)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = 
        sprintf("INSERT into images (idUsuario, nombre, idProducto) VALUES ('%d','%s', '%d')", $_SESSION['id'], $imagen, $idProducto);
        $result = mysqli_query($conn, $query);  

        return $result;
    }

    private static function insertaImagenUsuario($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $targetDir = "../uploads/";
        $fileName = basename($_FILES["file"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
        if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
            $allowTypes = array('JPG', 'jpg', 'png','jpeg','gif','pdf');
            if(in_array($fileType, $allowTypes)) {
                if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                    $qr = sprintf("SELECT * FROM images WHERE idUsuario=%d", $idUsuario);
                    $rs = mysqli_query($conn, $qr);
                    if ($rs) {
                        $rs1 = self::borraPorIdUsuario($idUsuario);
                        $rs->free();
                    }
                    $rs->free();
                    $query = "INSERT into images (idUsuario, nombre) VALUES ('".$idUsuario."','".$fileName."')";
                    $result = mysqli_query($conn, $query);
                    if($result) {
                        $result->free();
                    }
                }
            }
        }
        
        return $rs;
    }

    public static function instertarImagenNoticia($fileName, $idNoticia){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = 
                sprintf("INSERT INTO images (idUsuario, nombre, idNoticia) VALUES ('%d','%s', '%d')", $_SESSION['id'], $fileName, $idNoticia);
                $result = mysqli_query($conn, $query);  
                if($result) {
                   
                        return true;
                }

                return false;
    }

    private static function borraPorIdUsuario($idUsuario){
        if (!$idUsuario) {
            return false;
        }
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM images WHERE idUsuario = '".$idUsuario."'"
            , $idUsuario
        );
        $rs = mysqli_query($conn, $query);
        if (!$rs) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }  

        return true;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }
    
}
?>