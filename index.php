<?php
    require_once __DIR__.'/includes/config.php';

    $tituloPagina = 'Inicio';
    $contenidoPrincipal = '
    <div class = "welcome1">    
        <h1> Bienvenido a Planning It </h1>
        <p> Tu página web de confianza de gestión de eventos y mas!</p>
    </div>
    <div class = "welcome2">    
        <div class = "contenido">
            <h1> Eventos </h1>
            <img class = "inicio" src="img/evento.jpg" />
            <p class = "desc"> Miles de eventos en los que participar! </p>
        </div>
        <div class = "contenido">
            <h1> Organización </h1>
            <img class = "inicio" src="img/calendario.png" />
            <p class = "desc"> Google Calendar? Que es eso. </p>
        </div>
        <div class = "contenido">
            <h1> Chats </h1>
            <img class = "inicio" src="img/chat.png" />
            <p class = "desc"> Habla con todo el mundo. </p>
        </div>
        <div class = "contenido">
            <h1> Tienda </h1>
            <img class = "inicio" src="img/tienda.jpg" />
            <p class = "desc"> Todo el merchandising aquí.</p>
        </div>
    </div>';
    
    require_once __DIR__.'/includes/vistas/plantillas/plantilla.php';
?>
