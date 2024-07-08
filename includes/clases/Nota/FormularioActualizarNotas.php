<?php
namespace es\ucm\fdi\aw\Nota;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioActualizarNotas extends Formulario
{
    private $idNota;
    public function __construct($idNota) {
        parent::__construct('formRegister', ['urlRedireccion' => '../../personal/CrearNota.php']);
        $this->idNota = $idNota;
    }
    
    protected function generaCamposFormulario(&$datos)
    {
        $informacion = $datos['informacion'] ?? '';

        // Se generan los mensajes de error si existen.
        $erroresGlobalesFormulario = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['informacion'], $this->errores);
        $html = <<<EOS
        $erroresGlobalesFormulario
        <fieldset>
            <legend>Datos para la nota</legend>
            <div>
             <input type="hidden" name="idNota" value="{$this->idNota}" />
       
         </div>
            <div>
                <label for="note">Informacion de la nota: <span id = "validNote"></label>
                <input id="note" type="text" name="note" value="$informacion" />
                {$erroresCampos['informacion']}
            </div>
            <div>
                <button type="submit" name="nota">Actualizar Nota</button>
            </div>
            
        </fieldset>
        EOS;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $informacion = filter_input(INPUT_POST, 'note', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nota=Nota::unaNota($datos['idNota']);
        $nota->setInformacion($this->idNota,$informacion);

        header('Location: areapersonal.php');
        exit();
    }
}