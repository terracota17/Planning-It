<?php
namespace es\ucm\fdi\aw\Pedido;

use es\ucm\fdi\aw\Formulario as Formulario;
use es\ucm\fdi\aw\Pedido\Pedido as Pedido;
class FormularioPedido extends Formulario
{
    public function __construct($id = null) {
       parent::__construct('formPedido', ['urlRedireccion' => 'verProducto.php']);
       $this->id = $id;
    }
    protected function generaCamposFormulario(&$datos)
    {
        $cantidad = $datos['unidades'] ?? '';

        // Se generan los mensajes de error si existen.
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['unidades'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
        $htmlErroresGlobales
            <div >
                <label for="unidades">Unidades:</label>
                <input class = unidadesTienda id="unidades" required type="number" name="unidades" value="1" />
                {$erroresCampos['unidades']}
            </div>
                <p></p>
            <div >
                <button class=botontienda type="submit" name="compra" value = "carrito">Comprar</button>
            </div>
        EOF;
        return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        $idProducto= filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
        $this->errores = [];
        if(isset($_SESSION['login']) && $_SESSION['login'] === true){
            $this->errores = [];

            $cantidad = trim($datos['unidades'] ?? '');
            $cantidad = filter_var($cantidad, FILTER_SANITIZE_NUMBER_INT);
            
            Pedido::crearPedido($idProducto,$cantidad,$_SESSION['id']);
                
            header('Location: listaProductos.php');
            exit();
        }
        else{
            $this->errores[] = "Inicia sesión para comprar";
        }
    }
}