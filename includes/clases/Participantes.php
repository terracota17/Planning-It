<?php
namespace es\ucm\fdi\aw;

class Participantes
{
    private $idEvento;

    private $idForo;

    private $idUsuario;

    private function __construct($idEvento, $idUsuario = null, $idForo = null)
    {   
        $this->idEvento = $idEvento;
        $this->idUsuario = $idUsuario;
        $this->idForo = $idForo;
    }

    public static function crearParticipacion($idEvento,$idUsuario) {
        
        if(self::estaParticipandoEvento($idEvento,$idUsuario)){
            return false;
        }
        else{
            $participante = new Participantes($idEvento,$idUsuario, NULL);
            
            return self::insertaParticipante($participante);

        }
    }
    
    public static function buscaPorIdEvento($idEvento){
        $users = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Participantes WHERE idEvento='%d'", $idEvento);
        $result = mysqli_query($conn, $query);  
        if ($result) {
            while($fila = mysqli_fetch_assoc($result)) {
                $users[] = new Participantes($fila['idEvento'],$fila['idUsuario']);
            }
            $result->free();

            return $users;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
    
    public static function estaParticipandoEvento($idEvento,$idUsuario){
        
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Participantes WHERE (idUsuario ='%d') AND (idEvento='%d')", $idUsuario, $idEvento);
        $result = mysqli_query($conn, $query);  
        if (mysqli_num_rows($result) > 0) {
            $result->free();
            return true;
        }   
        return false;
    }

    private static function insertaParticipante($participante)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("INSERT INTO Participantes(idUsuario, idEvento, idForo) VALUES ('%d', '%d', NULL)"
            , $conn->real_escape_string($participante->idUsuario)
            , $conn->real_escape_string($participante->idEvento)
        ); 
        
        if (mysqli_query($conn, $query)) {
            return true;
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        
        } 
        
        return false;
    }

    public static function eliminarParticipante($idUsuario, $idEvento)
    {
        if (!$idEvento) {
            return false;
        }
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Participantes WHERE idUsuario = %d AND idEvento = %d"
        , $conn->real_escape_string($idUsuario)
        , $conn->real_escape_string($idEvento)
        );
   
        if (mysqli_query($conn, $query)) {
            return true;
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } 
        
        

        return false;
    }

    public static function eliminarParticipanteForo($idUsuario, $idForo)
    {
        if (!$idForo) {
            return false;
        }
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Participantes WHERE idUsuario = %d AND idForo = %d"
        , $conn->real_escape_string($idUsuario)
        , $conn->real_escape_string($idForo)
        );
   
        if (mysqli_query($conn, $query)) {
            return true;
        }else{
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        } 
        
        return false;
    }

    public function getId()
    {
         return $this->idUsuario;
    }

        //Participante de Foro

        public static function participar($idForo,$idUsuario) {
        
            if(self::estaParticipandoEnForo($idForo,$idUsuario)){
                return false;
            }
            else{
                $participante = new Participantes(NULL, $idUsuario, $idForo);
                return self::insertaParticipanteForo($participante);
            }
        }
        
        public static function estaParticipandoEnForo($idForo,$idUsuario)
        { 
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM Participantes WHERE (idUsuario ='%d') AND (idForo='%d')", $idUsuario, $idForo);
            $result = mysqli_query($conn, $query);  
            if (mysqli_num_rows($result) > 0) {
                $result->free();
                return true;
            }   
            return false;
        }
     
    
        private static function insertaParticipanteForo($participante)
        {
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("INSERT INTO Participantes(idUsuario, idEvento, idForo) VALUES ('%d', NULL, '%d')"
            , $conn->real_escape_string($participante->idUsuario)
            , $conn->real_escape_string($participante->idForo));
            
            if (mysqli_query($conn, $query)) {
                return true;
            }else{
                error_log("Error BD ({$conn->errno}): {$conn->error}");
            
            } 
            
            return false;
        }

        public static function buscaPorIdForo($idForo){
            $resultado = [];
            $conn = Aplicacion::getInstance()->getConexionBd();
            $query = sprintf("SELECT * FROM Participantes WHERE idForo='%d'", $idForo);
            $result = mysqli_query($conn, $query);  
            if ($result) {
                while($fila = mysqli_fetch_assoc($result)) {
                    $resultado[] = new Participantes($fila['idForo'],$fila['idUsuario']);
                }
                $result->free();
            }
           
            return $resultado;
        }
}

?>