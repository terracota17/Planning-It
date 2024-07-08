<?php
namespace es\ucm\fdi\aw\Foro;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioForo extends Formulario{
    private $idForo;
    public function __construct($id = null) {
       parent::__construct('formForo', ['urlRedireccion' => 'CrearForo.php']);
       $this->idForo = $id;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $fecha = $datos['fecha'] ?? '';
        $tema = $datos['tema'] ?? ''; 
        $contenido = $datos['contenido'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['tema', 'contenido','fecha'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro</legend>
            <div>
             <input type="hidden" name="idForo" value="{$this->idForo}" />
            </div>
        EOF;
        if ($this->idForo == NULL) {
            $html .= <<<EOF
            $htmlErroresGlobales
                <div>
                    <label for="tema">Tema del foro: <span id = "validTheme"></span></label>
                    <input id="tema" required type="text" name="tema" value="$tema" />
                    {$erroresCampos['tema']}
                </div>
            EOF;
        }
        else {
            $html .= <<<EOF
            $htmlErroresGlobales
                <div>
                    <label for="temaedit">Tema del foro: <span id = "validTheme"></span></label>
                    <input id="temaedit" required type="text" name="temaedit" value="$tema" />
                    {$erroresCampos['tema']}
                </div>
            EOF;
        }
        $html .= <<<EOF
        $htmlErroresGlobales
            <div>
                <label for="contenido">Contenido del Foro: <span id = "validInfo"></span></label>
                <input  id="contenido"  required type="text"  name="contenido" value="$contenido" />
                {$erroresCampos['contenido']}
            </div>
            <div>
                <button type="submit" name="publicarr">Publicar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        if($_SESSION['login'] === true) {
            $this->errores = [];

            $fecha = date('Y-m-d h:i:s');

            if($this->idForo == NULL) {
                $tema = trim($datos['tema'] ?? '');
                $tema = filter_var($tema, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }
            else {
                $tema = trim($datos['temaedit'] ?? '');
                $tema = filter_var($tema, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            }

            $contenido = trim($datos['contenido'] ?? '');
            $contenido = filter_var($contenido, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($datos['idForo'] == null) {
                $foro = Foro::crearForo($_SESSION['id'], $fecha, $tema, $contenido ,$datos['idForo']);
                if($foro){
                    $this->errores[] = "Foro creado correctamente";
                    header("Location: listarForos.php");
                    exit(); 
                }
                else{
                    $this->errores[] = "Error al introducir el foro en la base de datos";
                }
            }        
            else{
                $foro = Foro::buscarForoPorId($datos['idForo']);

                if($foro){
                    $foro->setTema($datos['idForo'],$tema);
                    $foro->setContenido($datos['idForo'],$contenido);
                }

                if($foro){
                    $this->errores[] = "Foro modificado correctamente";
                    header("Location: listarForos.php");
                    exit(); 
                }
                else{
                    $this->errores[] = "Error en la modificación del foro en la base de datos";
                }
            }
        }
        else{
            $this->errores[] = "Inicia sesión para poder crear o participar en un foro";
        }
    }
}