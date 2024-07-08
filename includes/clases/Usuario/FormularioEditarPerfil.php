<?php
namespace es\ucm\fdi\aw\Usuario;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioEditarPerfil extends Formulario
{
    public function __construct() {
       parent::__construct('formEditarEvento', ['urlRedireccion' => '../../personal/modificarPerfil.php']);
    }
    protected function generaCamposFormulario(&$datos)
    {

        $user =  Usuario::buscaPorId($_SESSION['id']);

        $nombre = $datos['nombre'] ?? $user->getNombre();
        $nombreUsuario= $datos['nombreUsuario'] ?? $user->getNombreUsuario();
        $password = $datos['password'] ?? '';
        $apellido = $datos['apellido'] ?? $user->getApellido();
        $correo = $datos['correo'] ?? $user->getCorreo();
        $telefono = $datos['telefono'] ?? $user->getTelefono();
        

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'nombreUsuario', 'password', 'apellido', 'correo', 'telefono'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos usuario:</legend>
            <div>
                <label for="nombreUsuario">Nombre de usuario: <span id = "validUser"></span></label>                
                <input id="nombreUsuario" required type="text" name="nombreUsuario" value="$nombreUsuario" />
                {$erroresCampos['nombreUsuario']}
            </div>
            <div>
                <label for="nombre">Nombre: <span id = "validName"></span></label>
                <input id="nombre" required type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="apellido">Apellido: <span id = "validApellido"></span></label>
                <input id="apellido" required type="text" name="apellido" value="$apellido" />
                {$erroresCampos['apellido']}
            </div>
            <div>
                <label for="correo">Correo electrónico: <span id = "validEmail"></span></label>
                <input id="correo" required type="email" name="correo" value="$correo" />
                {$erroresCampos['correo']}
            </div>
            <div>
                <label for="telefono">Nº telefono: <span id = "validPhone"></span></label>
                <input id="telefono" required type="text" name="telefono" value="$telefono" />
                {$erroresCampos['telefono']}
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" required type="password" name="password" value="$password" />
                {$erroresCampos['password']}
            </div>
            <div>
                <button type="submit" name="actualizacion">Actualizar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        $nombreUsuario = trim($datos['nombreUsuario'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $apellido = trim($datos['apellido'] ?? '');
        $apellido = filter_var($apellido, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $password = trim($datos['password'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $correo = trim($datos['correo'] ?? '');
        $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $correo = filter_var($correo, FILTER_VALIDATE_EMAIL);

        $telefono = trim($datos['telefono'] ?? '');
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $usuario =  Usuario::buscaPorId($_SESSION['id']);
         
        $usuario->setCorreo($correo);
        $usuario->setApellido($apellido);
        $usuario->setNombreUsuario($nombreUsuario);
        $usuario->cambiaPassword($password);
        $usuario->setNombre($nombre);
        $usuario->setTelefono($telefono);
        $usuario->actualiza($usuario);  //finalmente actualizamos el usuario con el mismo id que antes

        header('Location: ../personal/areapersonal.php');
        
        exit();
    }
}