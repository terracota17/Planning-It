<?php
namespace es\ucm\fdi\aw\Foro;

use es\ucm\fdi\aw\Formulario as Formulario;
use es\ucm\fdi\aw\Foro\MensajesForo as MensajesForo;

class FormularioEditarMensajeForo extends Formulario
{    
    private $idMensajeForo;
    public function __construct($id = null) {
       parent::__construct('formMensajeForo', ['urlRedireccion' => 'mensajesForo.php']);
       $this->idMensajeForo = $id;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $contenido = $datos['contenido'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['contenido'], $this->errores, 'span', array('class' => 'error'));
        
        $mensajeForo = MensajesForo::buscarMensajeForoPorId($this->idMensajeForo);

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <div>
            <input type="hidden" name="idMensajeForo" value="{$this->idMensajeForo}" />
            <input id="contenido"  placeholder="Escribe algo" required type="text" name="contenido" value="{$mensajeForo->getContenido()}" />
            {$erroresCampos['contenido']}
            <button type="submit" name="publicar">Publicar</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        if($_SESSION['login'] === true){

            $contenido = trim($datos['contenido'] ?? '');
            $contenido = filter_var($contenido, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $mensajeForo = MensajesForo::buscarMensajeForoPorId($datos['idMensajeForo']);
            $mensajeForo->setContenido($datos['idMensajeForo'],$contenido);

            header("Location: mensajesForo.php?idForo={$mensajeForo->getIdForo()}");
            exit();
        }
        else{
            $this->errores[] = "Inicia sesión para poder crear o participar en un foro";
        }
}
}
