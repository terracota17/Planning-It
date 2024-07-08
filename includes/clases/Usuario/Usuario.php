<?php
namespace es\ucm\fdi\aw\Usuario;

use es\ucm\fdi\aw\Aplicacion as Aplicacion;

class Usuario
{
    public const ADMIN_ROLE = 1;

    public const USER_ROLE = 2;

    public static function login($nombreUsuario, $password)
    {
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return self::cargaRoles($usuario);
        }
        return false;
    }

    public static function checkLogin($nombreUsuario, $password)
    {
        $usuario = self::buscaUsuario($nombreUsuario);
        if ($usuario && $usuario->compruebaPassword($password)) {
            return true;
        }
        return false;
    }

    public static function crea($nombreUsuario, $password, $nombre, $apellido, $correo, $telefono, $rol)
    {
        $user = new Usuario($nombreUsuario, self::hashPassword($password), $nombre, $apellido, $correo, $telefono);
        $user->añadeRol($rol);
        return $user->guarda();
    }

    public static function buscaUsuario($nombreUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario U WHERE U.nombreUsuario='%s'", $conn->real_escape_string($nombreUsuario));
        $result = mysqli_query($conn, $query);        
	    if(!$result){
	        return false;
	    }else if (mysqli_num_rows($result )> 0) {
            $fila = mysqli_fetch_assoc($result);
            $user = new Usuario($fila['nombreUsuario'], $fila['password'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['telefono'], $fila['id']);
            $result->free();

            return $user;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return false;
    }

   public static function buscaPorId($idUsuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario WHERE id=%d", $idUsuario);
        $result = mysqli_query($conn, $query);
        if(!$result){
            return false;
        }  
        else if (mysqli_num_rows($result) > 0) {
            $fila = mysqli_fetch_assoc($result);
            $user = new Usuario($fila['nombreUsuario'], $fila['password'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['telefono'], $fila['id']);
            $result->free();

            return $user;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }

    public static function listarUsuarios() {
        $resultado = [];
        $conn = Aplicacion::getInstance()->getConexionBd();
        $sql = "SELECT * FROM Usuario";
        $rs = mysqli_query($conn, $sql) ;
        if ($rs) {
            while ($row = mysqli_fetch_assoc($rs)) {
                $resultado[] = new Usuario($row['nombreUsuario'], $row['password'], $row['nombre'], $row['apellido'], $row['correo'], $row['telefono'], $row['id']);
            }
            $rs->free();
        }
       
        return $resultado;
    }
   
    private static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    private static function cargaRoles($usuario)
    {
        $roles=[];
           
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT RU.rol FROM RolesUsuario RU WHERE RU.usuario=%d"
            , $usuario->id
        );
        $result = mysqli_query($conn, $query);        
        if ($result) {
            $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $result->free();

            $usuario->roles = [];
            foreach($roles as $rol) {
                $usuario->roles[] = $rol['rol'];
            }
            return $usuario;

        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return false;
    }
   
    private static function inserta($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("INSERT INTO Usuario(nombreUsuario, nombre, password, apellido, correo, telefono, biografia) VALUES ('%s', '%s', '%s','%s','%s','%d','%s')"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->apellido)
            , $conn->real_escape_string($usuario->correo)
            , $conn->real_escape_string($usuario->telefono)
	    , $conn->real_escape_string($usuario->biografia)
        );
        $rs = mysqli_query($conn, $query);
        if ($rs) {
            $usuario->id = $conn->insert_id;
            $result = self::insertaRoles($usuario);
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
        return $result;
    }
   
    private static function insertaRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        foreach($usuario->roles as $rol) {
            $query = sprintf("INSERT INTO RolesUsuario(usuario, rol) VALUES (%d, %d)"    
            , $usuario->id
            , $rol
            );
            $result = mysqli_query($conn, $query);
            if ( ! $result ) {
                error_log("Error BD ({$conn->errno}): {$conn->error}");
                return false;
            }
        }
        return $usuario;
    }
   
    public static function actualiza($usuario)
    {
        $result = false;
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query=sprintf("UPDATE Usuario SET nombreUsuario = '%s', nombre='%s', password='%s', apellido='%s', correo='%s', telefono='%d' WHERE id='%d'"
            , $conn->real_escape_string($usuario->nombreUsuario)
            , $conn->real_escape_string($usuario->nombre)
            , $conn->real_escape_string($usuario->password)
            , $conn->real_escape_string($usuario->apellido)
            , $conn->real_escape_string($usuario->correo)
            , $conn->real_escape_string($usuario->telefono)
            , $usuario->id
        );
        $rs = mysqli_query($conn, $query);
        if ( $rs ) {
            /*
            $result = self::borraRoles($usuario);
            if ($result) {
                $result = self::insertaRoles($usuario);
            }*/
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }
       
        return $result;
    }
   
    private static function borraRoles($usuario)
    {
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM RolesUsuario WHERE usuario = '%d'"
            , $usuario->id
        );
        $result = mysqli_query($conn, $query);
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return $usuario;
    }
    public static function recibirNotificacionesPorId($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("SELECT * FROM Usuario WHERE id = '%d'", $id);
        $rs = mysqli_query($conn, $query);
        if($rs){
            $fila = mysqli_fetch_assoc($rs);

            if($fila['recibirNotificacionesEventos'] == 1){
                $rs->free();
                return true;
            }
        }
        
        return false;
    }
    public static function actualizarRecibirNotificaciones($id, $recibirNotificaciones){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("UPDATE Usuario SET recibirNotificacionesEventos = '%d' WHERE id = '%d'",$recibirNotificaciones,$id);
        $rs = mysqli_query($conn, $query);
        if($rs){
           return true; 
        }

        return false;
    }
   
    private static function borra($usuario)
    {
        return self::borraPorId($usuario->id);
    }
    public static function borraUsuarioPorIdentificador($id){
        $conn = Aplicacion::getInstance()->getConexionBd();
        $query = sprintf("DELETE FROM Usuario WHERE id='%d'",$id);
        $rs = mysqli_query($conn, $query);
        if($rs){
           return true; 
        }

        return false;
    }

    private static function borraPorId($idUsuario)
    {
        if (!$idUsuario) {
            return false;
        }
        /* Los roles se borran en cascada por la FK
         * $result = self::borraRoles($usuario) !== false;
         */
        $conn = Aplicacion::getInstance()->getConexionBd();
        
        $query = sprintf("DELETE FROM Usuario WHERE id = '%d'"
            , $idUsuario
        );
        $result = mysqli_query($conn, $query);
        if ( ! $result ) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
        return true;
    }

    private $id;

    private $nombreUsuario;

    private $password;

    private $nombre;

    private $apellido;

    private $correo;

    private $telefono;

    private $roles;

    private $biografia;

    private function __construct($nombreUsuario, $password, $nombre, $apellido, $correo, $telefono, $id = null, $roles = [])
    {
        $this->id = $id;
        $this->nombreUsuario = $nombreUsuario;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->telefono = $telefono;
        $this->roles = $roles;
	    $this->biografia = "Mi biografia";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNombreUsuario()
    {
        return $this->nombreUsuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getPasswordNotHashed()
    {
        return $this->password;
    }

    public function getApellido()
    {
        return $this->apellido;
    }

    public function getCorreo()
    {
        return $this->correo;
    }


    public function setId($id)
    {
         $this->id = $id;
    }

    public function setNombreUsuario($nombreUsuario)
    {
         $this->nombreUsuario= $nombreUsuario;
    }

    public function setNombre($nombre)
    {
         $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
         $this->apellido = $apellido;
    }

    public function setCorreo($correo)
    {
         $this->correo = $correo;
    }
    
     public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono){
        $this->telefono = $telefono;
    }

    public function añadeRol($role)
    {
        $this->roles[] = $role;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return self::hashPassword($this->password);
    }

    public function tieneRol($role)
    {
        if ($this->roles == null) {
            self::cargaRoles($this);
        }
        return array_search($role, $this->roles) !== false;
    }

    public function compruebaPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function cambiaPassword($nuevoPassword)
    {
        $this->password = self::hashPassword($nuevoPassword);
    }
   
    public function guarda()
    {
        if ($this->id !== null) {
            return self::actualiza($this);
        }
        return self::inserta($this);
    }
   
    public function borrate()
    {
        if ($this->id !== null) {
            return self::borra($this);
        }
        return false;
    }
}
