<?php
namespace es\ucm\fdi\aw\Noticia;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioOrdenarCategoria extends Formulario
{
    public function __construct() {
       parent::__construct('formNoticia', ['urlRedireccion' => 'mostrarNoticiasFecha.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $categoria = $datos['categoria'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['informacion', 'categoria'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <label for="categoria">Categoria:</label>
                <select name="categoria" id="categoria">
                <option value="deportes">Deportes</option>
                <option value="politica" selected>Política</option>
                <option value="comida">Gastronomía</option>
                <option value="educacion">Educación</option>
                </select>
            </div>
            <div>
                <button type="submit" name="registro">Buscar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $categoria = trim($datos['categoria'] ?? '');        
    
        header("Location: listarNoticiasCategoria.php?categoria={$categoria}");
        exit();
    }
}