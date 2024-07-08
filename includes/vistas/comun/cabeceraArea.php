<?php
    use es\ucm\fdi\aw\Pedido\Pedido as Pedido;
    use es\ucm\fdi\aw\Notificacion\Notificacion as Notificacion;
    use es\ucm\fdi\aw\Imagen as Imagen;
    require_once __DIR__.'/../../config.php';

    function mostrarSaludo() {
        $html = '';
        if (isset($_SESSION["login"])) {
            $img = Imagen::buscarImagen($_SESSION['id']);
            $html .= "Bienvenido, {$_SESSION['nombre']}. <a href = '../logout.php'>Cerrar Sesion</a>";
            if (!$img) {
                $html .= '<a class ="enlaceRapidoAP" href = "../personal/areapersonal.php"><img class = "imagen" src="../img/sinImagenPerfil.jpg"></a>';
            }
            else {
                $html .= "<a class ='enlaceRapidoAP' href = '../personal/areapersonal.php' ><img class = 'imagen' src='../{$img}'></a>";
            }
            
            return $html;
        }
        else {
            return "Usuario desconocido. <a href='../login.php'>Iniciar sesion </a> o <a href='../registro.php'> Registrarse</a>";
        }
        return $html;
    }

  

    
    function compruebaObjetosCarrito(){
        $id = '';
        if (isset($_SESSION["login"])) {
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
        }
        $productos = Pedido::numProductosCarrito($id);
        $pedido = Pedido::pedidoPendiente($id);
        
        if( $productos > 0){
            $idPedido = $pedido->getId();
            return "<a href = '../tienda/verPedido.php?Ver+Pedido=Ver+Pedido&idPedido={$idPedido}'><i class='fa-solid fa-cart-shopping'><span class ='dot'><sup>{$productos}</sup></span></i></a>";
        }
        else {
            return '<a href = "../tienda/misCompras.php?Mis+Compras=Mis+Compras"><i class="fa-solid fa-cart-shopping"></i></a>';
        }
    }
    }

    function compruebaNumNotificaciones(){
        $id = '';
        if (isset($_SESSION["login"])) {
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
        }
        $numNotificaciones =  Notificacion::numNotificaciones($id);
        if( $numNotificaciones > 0){
            return '<a href = "../notificaciones/listarNotificaciones.php"><i class="fa-solid fa-bell"><span class = "dot"><sup>'.$numNotificaciones.'</sup></span></i></a>';
        }
        else {
            return '<a href = "../notificaciones/listarNotificaciones.php"><i class="fa-solid fa-bell"></i></a>';
        } 
    }
    }
?>
<header>
    <button id ="logo" onclick="location.href='../index.php'" type="button"><img src= ../img/logo.jpeg></button>
    <ul class="menu">
        <li><a href="../eventos/listarEventos.php">Eventos</a></li>
        <li><a href="../personal/areapersonal.php">Area personal</a></li>
        <li><a href="../mensajes/listar.php">Mensajes</a></li>
        <li><a href="../tienda/listaProductos.php">Tienda</a></li>
		<li><a href="../noticias/listarNoticias.php">Noticias</a></li>
        <li><a href="../foros/listarForos.php">Foro</a></li> 
    </ul>
    <div class ="bienvenido">
        <div class = "noti">
            <?= compruebaNumNotificaciones()?> 
            <?= compruebaObjetosCarrito()?>
        </div>
        <div class = "cabecera">
            <?= mostrarSaludo() ?>
        </div>
    </div>
</header>
