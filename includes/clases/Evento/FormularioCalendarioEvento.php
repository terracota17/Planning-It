<?php
namespace es\ucm\fdi\aw\Evento;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioCalendarioEvento extends Formulario
{
    public function __construct() {
       parent::__construct('formEvento', ['urlRedireccion' => 'mostrarEventosFecha.php']);

    }
    protected function generaCamposFormulario(&$datos)
    {
        $fecha = $datos['fecha'] ?? '';
        $hoy = date("Y-m-d");
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'informacion','fecha'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro</legend>
            <div>
                <label for="fecha">Selccione la fecha del evento: <span id = "validDate"></label>
                <input required type="date" id="fecha" name="fecha" min="$hoy" value="$fecha" />
                {$erroresCampos['fecha']}
            </div>
            <div>
                <button type="submit" name="registro">Listar Eventos con fecha</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        $fecha = trim($datos['fecha'] ?? '');
        $fecha = filter_var($fecha, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        header("Location: listarEventosPorFecha.php?fecha={$fecha}");
        exit();
    }
}