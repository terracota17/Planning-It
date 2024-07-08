<?php
namespace es\ucm\fdi\aw\Nota;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioNotas extends Formulario
{
    public function __construct() {
        parent::__construct('formRegister', ['urlRedireccion' => 'CrearNota.php']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        // Se reutiliza el nombre de usuario introducido previamente o se deja en blanco
        $informacion = $datos['informacion'] ?? '';

        // Se generan los mensajes de error si existen.
        $erroresGlobalesFormulario = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['informacion'], $this->errores);
        $html = <<<EOS
        $erroresGlobalesFormulario
        <fieldset>
            <legend>Datos para la nota</legend>
            <div>
                <label for="note">Informacion de la nota: <span id = "validNote"></span></label>
                <input id="note" required type="text" name="note" value="$informacion" />
                {$erroresCampos['informacion']}
            </div>
            <div>
                <button type="submit" name="nota">Crear nota</button>
            </div>
            
        </fieldset>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $informacion = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = $_SESSION['id'];
        $nota = Nota::creaNota($id, $informacion);

        header('Location: areapersonal.php');
        exit();
    }
}
