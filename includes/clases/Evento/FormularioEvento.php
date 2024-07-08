<?php
namespace es\ucm\fdi\aw\Evento;

use es\ucm\fdi\aw\Formulario as Formulario;
use es\ucm\fdi\aw\Foro\Foro as Foro;

class FormularioEvento extends Formulario
{
    public function __construct($id = null) {
       parent::__construct('formEvento', ['urlRedireccion' => 'CrearEvento.php']);
       $this->id = $id;
    }
    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $ubicacion = $datos['ubicacion'] ?? '';
        $informacion = $datos['informacion'] ?? '';
        $fecha = $datos['fecha'] ?? '';
        $hoy = date("Y-m-d");
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre','ubicacion','informacion','fecha'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset id = "registroEvento">
            <legend>Datos para el registro</legend>
            <input  type="hidden" name="idEvento" value = "{$this->id}">
            <div>
                <label for="nombre">Nombre del evento: <span id = "validName"></span></label>
                <input id="nombre" required type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="ubicacion">Ubicacion del evento: <span id = "validPlace"></span></label>
                <input id="ubicacion" required type="text" name="ubicacion" value="$ubicacion" />
                {$erroresCampos['ubicacion']}
            </div>
            <div>
                <label for="informacion">Informacion del evento: <span id = "validInfo"></span></label>
                <input id="informacion" required type="text" name="informacion" value="$informacion" />
                {$erroresCampos['informacion']}
            </div>
            <div>
                <label for="fecha">Fecha del evento: <span id = "validDate"></span></label>
                <input id="fecha" required type="date" name="fecha" min=$hoy value="$fecha" />
                {$erroresCampos['fecha']}
            </div>
            <div>
                <button type="submit" name="registro">Registrar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $ubicacion = trim($datos['ubicacion'] ?? '');
        $ubicacion = filter_var($ubicacion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $informacion = trim($datos['informacion'] ?? '');
        $informacion = filter_var($informacion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $fecha = trim($datos['fecha'] ?? '');
        $fecha = filter_var($fecha, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if($datos['idEvento']) {
            $foro = Foro::crearForo($_SESSION['id'], $fecha, $nombre, $informacion);
            $evento = Evento::crea($ubicacion,$informacion,$nombre,$fecha,$datos['idEvento'],1, $foro->getId());
        }
        else {
            $foro = Foro::crearForo($_SESSION['id'], $fecha, $nombre, $informacion);
            $evento = Evento::crea($ubicacion,$informacion,$nombre,$fecha,null,1, $foro->getId());
        }

        header('Location: MisEventos.php');
        exit();
    }
}