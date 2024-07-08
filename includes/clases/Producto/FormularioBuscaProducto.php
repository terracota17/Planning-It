<?php
namespace es\ucm\fdi\aw\Producto;

use es\ucm\fdi\aw\Formulario as Formulario;
use es\ucm\fdi\aw\Imagen as Imagen;

class FormularioBuscaProducto extends Formulario
{
    public function __construct($id = null) {
       parent::__construct('formProducto', ['urlRedireccion' => 'añadirProducto.php']);
       $this->id = $id;
    }
    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
    
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset class = "search">
            <div>
                <input id="nombre" placeholder="Buscar producto" required type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
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
        if($_SESSION['login'] === true){
            $this->errores = [];

            $nombre = trim($datos['nombre'] ?? '');
            $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            header("Location: gestionarProductos.php?nombre={$nombre}");
            exit();            
        }
        else{
            $this->errores[] = "Inicia sesión para poder gestionar productos";
        }
}
}