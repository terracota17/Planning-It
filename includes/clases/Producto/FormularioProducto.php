<?php
namespace es\ucm\fdi\aw\Producto;

use es\ucm\fdi\aw\Formulario as Formulario;
use es\ucm\fdi\aw\Imagen as Imagen;

class FormularioProducto extends Formulario
{
    public function __construct($id = null) {
       parent::__construct('formProducto', ['urlRedireccion' => 'gestionarProductos.php']);
       $this->id = $id;
    }
    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $informacion = $datos['informacion'] ?? '';
        $precio = $datos['precio'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'informacion','precio'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para el registro</legend>
            <div>
                <label for="nombre">Nombre del producto:</label>
                <input id="nombre" type="text" name="nombre" value="$nombre" />
                {$erroresCampos['nombre']}
            </div>
            <div>
                <label for="informacion">Informacion del producto:</label>
                <input id="informacion" type="text" name="informacion" value="$informacion" />
                {$erroresCampos['informacion']}
            </div>
            <div>
                <label for="precio">Precio del producto:</label>
                <input id="producto" type="number" name="precio" value="$precio" />
                {$erroresCampos['precio']}
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
        $this->errores = [];
        if($_SESSION['login'] === true){
       
          $nombre = trim($datos['nombre'] ?? '');
          $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          if ( ! $nombre || mb_strlen($nombre) < 5) {
             $this->errores['nombre'] = 'El nombre de producto tiene que tener una longitud de al menos 5 caracteres.';
          }

         $informacion = trim($datos['informacion'] ?? '');
         $informacion = filter_var($informacion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
         if ( ! $informacion || mb_strlen($informacion) < 5) {
             $this->errores['informacion'] = 'La información tiene que tener una longitud de al menos 5 caracteres.';
          }

          $precio = trim($datos['precio'] ?? '');
          $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          if ( ! $precio ) {
              $this->errores['precio'] = 'Introduce un precio valido';
          }
           

          if (count($this->errores) === 0) {
              $producto = Producto::buscarProductoGestion($nombre);

              if ($producto) {//si el nombre esta en uso y no es su producto da error
                  
                 $this->errores[] = "Nombre de producto en uso";
              } 
              else {
                 $producto = Producto::crea($informacion,$nombre,$precio,$this->id);
                
             }
            }
        }
        else{
            $this->errores[] = "Inicia sesión para poder añadir un producto";
        }
}
}