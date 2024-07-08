<?php
namespace es\ucm\fdi\aw\Pedido;

use es\ucm\fdi\aw\Formulario as Formulario;
use es\ucm\fdi\aw\Pedido\Pedido as Pedido;
use es\ucm\fdi\aw\Usuario\Usuario as Usuario;
use es\ucm\fdi\aw\Notificacion\Notificacion as Notificacion;

class FormularioPago extends Formulario
{
    public function __construct($id = null) {
       parent::__construct('formPago', ['urlRedireccion' => 'misCompras.php']);
       $this->id = $id;
    }
    protected function generaCamposFormulario(&$datos)
    {
        $Usuario = Usuario::buscaPorId($this->id);
        $idPedido= filter_input(INPUT_POST,'idPedido',FILTER_SANITIZE_NUMBER_INT);
        $nombre = $datos['nombre'] ??    '';
        $telefono = $datos['telefono'] ?? '';
        $numero  = $datos['numero'] ?? '';
        $contraseña = $datos['contraseña'] ?? '';
        $direccion = $datos['direccion'] ?? '';
        $erroresGlobalesFormulario = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos([ 'nombre', 'telefono', 'numero', 'contraseña', 'direccion'], $this->errores);
        $html = <<<EOS
        $erroresGlobalesFormulario

        <fieldset>
        <h3>Datos para el pago</h3>
        <div>
        <input type="hidden" name="idPedido" value="$idPedido" />
       
         </div>
        <div>
            <label for="nombre">Nombre de propietario: </label>
            <input id="nombre" required type="text" name="nombre" value="{$Usuario->getNombre()} {$Usuario->getApellido()}" />
            {$erroresCampos['nombre']}
        </div>
        <div>
            <label for="telefono">telefono: <span id = "validPhone"></span></label>
            <input id="telefono" required type="number" name="telefono" value="{$Usuario->getTelefono()}" />
            {$erroresCampos['telefono']}
        </div>
        <div>
            <label for="numero">Numero de tarjeta: <span id = "validCredit"></span></label>
            <input id="numero" required type="text" name="numero" value="$numero" />
            {$erroresCampos['numero']}
        </div>
        <div>
            <label for="contraseña">Clave: <span id = "validPass"></span></label>
            <input id="contraseña" required type="text" name="contraseña" value="$contraseña" />
            {$erroresCampos['contraseña']}
        </div>
        <div>
            <label for="direccion">Direccion de entrega:</label>
            <input id="direccion" required type="text" name="direccion" value="$direccion" />
            {$erroresCampos['direccion']}
        </div>
        <div>
            <button type="submit" name="pagar">Pagar</button>
        </div>
    </fieldset>
    EOS;
    return $html;
    }
    protected function procesaFormulario(&$datos)
    {
        $this->errores = [];
        $idPedido= filter_input(INPUT_POST,'idPedido',FILTER_SANITIZE_NUMBER_INT);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_NUMBER_INT);
        $contraseña = filter_input(INPUT_POST, 'contraseña', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $direccion = filter_input(INPUT_POST, 'direccion', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        Pedido::pagarPedido($idPedido);
	$texto = "Tu pedido se ha pagado correctamente,¡Gracias por tu compra!";
        $intro = "Nueva notificación de compras.";
	Notificacion::insertaNotificacionPedido($idPedido,$_SESSION['id'],date('d-m-y H:i:s'), $texto, 0,'pedido', $intro);
    }
}