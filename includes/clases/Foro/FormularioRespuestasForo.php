<?php
namespace es\ucm\fdi\aw\Foro;

use es\ucm\fdi\aw\Formulario as Formulario;

class FormularioRespuestasForo extends Formulario
{    
    public function __construct($id = null) {
       parent::__construct('formForo', ['urlRedireccion' => 'mensajesForo.php']);
       $this->id = $id;
    }

    protected function generaCamposFormulario(&$datos)
    {
        $contenido = $datos['contenido'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'tema', 'contenido','fecha'], $this->errores, 'span', array('class' => 'error'));
        
        $html = <<<EOF
        $htmlErroresGlobales
        <div>
        <input type="hidden" name="idForo" value="{$this->id}" />
        <input id="contenido"  placeholder="Escribe algo" required type="text" name="contenido" value="$contenido" />
        {$erroresCampos['contenido']}
        <button type="submit" name="publicar">Publicar</button>
        </div>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        if($_SESSION['login'] === true){
            $this->errores = [];

            $contenido = trim($datos['contenido'] ?? '');
            $contenido = filter_var($contenido, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $foro = MensajesForo::crea( $datos['idForo'], date('Y-m-d H:i:s'),$contenido, $_SESSION['id']);
            if($foro){
                $this->errores[] = "Mensaje creado correctamente";
            }
            else{
                $this->errores[] = "Error al introducir el foro en la base de datos";
            }

            header("Location: mensajesForo.php?idForo={$datos['idForo']}");
            exit();
        }
        else{
            $this->errores[] = "Inicia sesión para poder crear o participar en un foro";
        }
    }
}
