<?php
namespace es\ucm\fdi\aw\Producto;

use es\ucm\fdi\aw\Formulario as Formulario;
use es\ucm\fdi\aw\Imagen as Imagen;

class FormularioEditarProducto extends Formulario
{
    public function __construct($id = null) {
       parent::__construct('formProducto', ['urlRedireccion' => 'gestionarProductos.php']);
       $this->id = $id;
    }
    protected function generaCamposFormulario(&$datos)
    {
        $informacion = $datos['informacion'] ?? '';
        $precio = $datos['precio'] ?? '';
      
        $producto = Producto::buscaPorductoId($this->id);
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['informacion','precio'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro</legend>
            <div>
            <label for="nombre">Nombre del producto: {$producto->getNombre()}</label>
            </div>
            <div>
                <label for="infoProd">Informacion del producto: <span id = "validInfoProd"></span></label>
                <input type="hidden" name="idProducto" value="{$this->id}" />
                <input id="infoProd" required type="text" name="infoProd" value="{$producto->getInfo()}" />
                {$erroresCampos['informacion']}
            </div>
            <div>
                <label for="precio">Precio del producto: <span id = "validPrice"></span></label>
                <input id="precio" required type="number" name="precio" value="{$producto->getPrecio()}" />
                {$erroresCampos['precio']}
            </div>
            <div>
                <button type="submit" name="registro">Editar </button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $productoAux = Producto::buscaPorductoId($datos['idProducto']);
        if($_SESSION['login'] === true){
            $informacion = trim($datos['infoProd'] ?? '');
            $informacion = filter_var($informacion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            $precio = trim($datos['precio'] ?? '');
            $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $producto = Producto::crea($informacion,$productoAux->getNombre(),$precio,$productoAux->getId());
        }
        else{
               $this->errores[] = "Inicia sesión para poder añadir un producto";
        }
   }
}
