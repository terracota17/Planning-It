<?php
namespace es\ucm\fdi\aw\Foro;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioOrdenarPorTema extends Formulario
{
    public function __construct() {
       parent::__construct('formForo', ['urlRedireccion' => 'mostrarForoTema.php']);

    }
    protected function generaCamposFormulario(&$datos)
    {
        $tema = $datos['tema'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['informacion', 'tema'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro</legend>
            <div>
                <label for="temas">Selccione el tema del Foro:</label>
                <input id="temas" required type="text" name="temas" value="$tema" />
                {$erroresCampos['tema']}
            </div>  
            <div>
                <button type="submit" name="registro">Listar Foros por tema</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $tema = trim($datos['temas'] ?? '');
        $tema = filter_var($tema, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        header("Location: listarForosPorTema.php?tema={$tema}");
        exit();
    }
}