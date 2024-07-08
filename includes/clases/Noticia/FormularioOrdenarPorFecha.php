<?php
namespace es\ucm\fdi\aw\Noticia;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioOrdenarPorFecha extends Formulario
{
    public function __construct() {
       parent::__construct('formNoticia', ['urlRedireccion' => 'mostrarNoticiasFecha.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $fecha = $datos['fecha'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['informacion', 'fecha'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
                <label for="fecha">Selccione la fecha de la Noticia:</label>
                <input id="fecha" required type="date" name="fecha" value="$fecha" />
                {$erroresCampos['fecha']}
            </div>
            <div>
                <button type="submit" name="registro">Listar Noticias con fecha</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $fecha = trim($datos['fecha'] ?? '');
        $fecha = filter_var($fecha, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        header("Location: listarNoticiasPorFecha.php?fecha={$fecha}");
        exit();
    }
}