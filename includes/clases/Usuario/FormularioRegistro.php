<?php
namespace es\ucm\fdi\aw\Usuario;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioRegistro extends Formulario
{
    public function __construct() {
        parent::__construct('formRegister', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $nombreUsuario = $datos['nombreUsuario'] ?? '';
        $nombre = $datos['nombre'] ?? '';
        $apellido = $datos['apellido'] ?? '';
        $correo = $datos['correo'] ?? '';
        $telefono = $datos['telefono'] ?? '';
        $password  = $datos['password'] ?? '';
        $password2 = $datos['password2'] ?? '';

        // Se generan los mensajes de error si existen.
        $erroresGlobalesFormulario = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'nombre', 'apellido', 'correo', 'telefono', 'password', 'password2'], $this->errores);
        $html = <<<EOS
        $erroresGlobalesFormulario
        <fieldset id="registro">
            <h3>Datos para el registro</h3>
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
                <label for="password2">Reintroduce el password: <span id = "validPassword"></span></label>
                <input id="password2" required type="password" name="password2" value="$password2" />
                {$erroresCampos['password2']}
            </div>
            <div>
                <button id="acceso" type="submit" name="registro">Registrarse</button>
            </div>
        </fieldset>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $nombreUsuario = filter_input(INPUT_POST, 'nombreUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $apellido = filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $usuario = Usuario::crea($nombreUsuario, $password, $nombre, $apellido, $correo,$telefono, Usuario::USER_ROLE);

        $_SESSION['login'] = true;
        $_SESSION['id'] = $usuario->getId();
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['nombreUsuario'] = $usuario->getNombreUsuario();
    }
}
