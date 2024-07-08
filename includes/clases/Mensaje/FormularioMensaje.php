<?php
namespace es\ucm\fdi\aw\Mensaje;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioMensaje extends Formulario
{
    public function __construct($idrem, $id = null, $textoa = null) {
       parent::__construct('formMensaje', ['urlRedireccion' => "chat.php?id={$idrem}"]);
       $this->idrem = $idrem;
       $this->id = $id;
       $this->textoa = $textoa;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $texto = $datos['texto'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['texto'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class = "send">
            <div>
                <input type="hidden" name="idrem" value="{$this->idrem}" />
            </div>
            <div class = "formSend">
                <input  type="hidden" name="idMensaje" value = "{$this->id}">
        EOF;
        if ($this->id !== null) {
            $html .= <<<EOF
            <input id="texto"  placeholder="Editando el mensaje: {$this->textoa}." required type="text" name="texto" value="$texto" />
            {$erroresCampos['texto']}
            <button class = "msg" type="submit"> <img class = "msgImage" src="../img/plane.png" /></button>
            EOF;
        }
        else {
            $html .= <<<EOF
            <input id="texto"  placeholder="Escribe algo" required type="text" name="texto" value="$texto" />
            {$erroresCampos['texto']}
            <button class = "msg" type="submit"> <img class = "msgImage" src="../img/plane.png" /></button>
            EOF;
        }

        $html .= <<<EOF
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        if($_SESSION['login'] === true) {
            $this->errores = [];

            $texto = trim($datos['texto'] ?? '');
            //$fecha = date('d-m-y H:i:s');
	    $fecha = date('Y-m-d H:i:s');
            $texto = filter_var($texto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

           if($datos['idMensaje']){
                $mensaje = Mensaje::crea($datos['idMensaje'], $_SESSION['id'], $datos['idrem'], $fecha, $texto);
            }
            else {
                $mensaje = Mensaje::crea(null, $_SESSION['id'], $datos['idrem'], $fecha, $texto);
            }
            if($mensaje) {
                $this->errores[] = "Mensaje enviado correctamente";
            }
            else {
                $this->errores[] = "Error al introducir el mensaje en la base de datos";
            }
            
            header("Location: chat.php?id={$datos['idrem']}");
            exit();
        }
        else {
            $this->errores[] = "Inicia sesión para poder enviar un mensaje";
        }
    }
}