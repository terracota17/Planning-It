<?php
namespace es\ucm\fdi\aw\Producto;

use es\ucm\fdi\aw\Formulario as Formulario;
use es\ucm\fdi\aw\Imagen as Imagen;

class FormularioSubidaImagenProducto extends Formulario
{
    public function __construct($id = null) {
       parent::__construct('formProducto', ['urlRedireccion' => 'añadirProducto.php']);
       $this->id = $id;
    }
    protected function generaCamposFormulario(&$datos)
    {
  

        $producto = 
        $imagen = $datos['imagen'] ?? '';
        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'informacion','precio'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
        <fieldset>
            <legend>Datos para la subida de la imagen</legend>
            <div>
                <form action="../producto/subirImagenProducto.php" method="post" enctype="multipart/form-data">
                Imagen de el evento: <input type="file" name="file" />
                <input type="submit" name="submit" value="Upload">
                </form>
            </div>

            <div>
                <button type="submit" name="registro">Subir</button>
            </div>
        </fieldset>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        if($_SESSION['login'] === true){
         $this->errores = [];

         
           $imagen = trim($datos['imagen'] ?? '');
           $imagen = filter_var($informacion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
           if(!$imagen){
            $this->errores['imagen'] = 'Introduce una imagen';
           }

          if (count($this->errores) === 0) {
              $producto = Producto::buscarProducto($nombre);

              if ($producto) {//si el nombre esta en uso y no es su producto da error
                  
                 $this->errores[] = "Nombre de producto en uso";
              } 
              else {
                 $producto = Producto::crea($informacion,$nombre,$precio,$this->id);
                
                if($producto){
                        $this->errores[] = "Producto añadido correctamente";
                 }
                else{
                     $this->errores[] = "Error al introducir el producto en la base de datos";
                }
             }
            }

            
            header('Location: /imagenProducto.php');
            exit();
        }
        else{
            $this->errores[] = "Inicia sesión para poder añadir un producto";
        }
}
}