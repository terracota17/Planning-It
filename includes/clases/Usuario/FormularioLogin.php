<?php
namespace es\ucm\fdi\aw\Usuario;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioLogin extends Formulario
{
    public function __construct() {
        parent::__construct('formLogin', ['urlRedireccion' => 'index.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $nombreUsuario = $datos['nombreUsuario'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombreUsuario', 'password'], $this->errores, 'span', array('class' => 'error'));

        // Se genera el HTML asociado a los campos del formulario y los mensajes de error.
        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset id="login">
            <h3>Inicia sesión</h3>
            <div>
                <label for="user">Nombre de usuario: </label>
                <input id="user" required type="text" name="user" value="$nombreUsuario" />
                {$erroresCampos['nombreUsuario']}
            </div>
            <div>
                <label for="pass">Password: </label>
                <input id="pass" required type="password" name="pass" />
                {$erroresCampos['password']}
            </div>
            <div>
                <button id="acceso" type="submit" name="login">Entrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $nombreUsuario = trim($datos['user'] ?? '');
        $nombreUsuario = filter_var($nombreUsuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $password = trim($datos['pass'] ?? '');
        $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $usuario = Usuario::login($nombreUsuario, $password);
                
        $_SESSION['login'] = true;
        $_SESSION['id'] = $usuario->getId();
        $_SESSION['nombre'] = $usuario->getNombre();
        $_SESSION['nombreUsuario'] = $usuario->getNombreUsuario();
        $_SESSION['esAdmin'] = $usuario->tieneRol(Usuario::ADMIN_ROLE);
    }
}
