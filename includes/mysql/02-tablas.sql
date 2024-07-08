
DROP TABLE IF EXISTS `RolesUsuario`;
DROP TABLE IF EXISTS `Roles`;
DROP TABLE IF EXISTS `Usuario`;
DROP TABLE IF EXISTS `Nota`;
DROP TABLE IF EXISTS `Evento`;
DROP TABLE IF EXISTS `images`;
DROP TABLE IF EXISTS `Participantes`;
DROP TABLE IF EXISTS `Producto`;
DROP TABLE IF EXISTS `Mensaje`;
DROP TABLE IF EXISTS `ContenidoPedidos`;
DROP TABLE IF EXISTS `Pedido`;
DROP TABLE IF EXISTS `Foro`;
DROP TABLE IF EXISTS `MensajeForo`;
DROP TABLE IF EXISTS `Notificacion`;
DROP TABLE IF EXISTS `Noticias`;
DROP TABLE IF EXISTS `tbl_events`;

CREATE TABLE IF NOT EXISTS `Roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `RolesUsuario` (
  `usuario` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  PRIMARY KEY (`usuario`,`rol`),
  KEY `rol` (`rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombreUsuario` varchar(30) COLLATE utf8mb4_general_ci NOT NULL UNIQUE,
  `password` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `apellido` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `correo` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `telefono` int(9) COLLATE utf8mb4_general_ci NOT NULL,
  `biografia` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `recibirNotificacionesEventos` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Nota` (
   `idNota` int(11) NOT NULL AUTO_INCREMENT,
   `idUsuario` int(11) NOT NULL,
   `informacion` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
   PRIMARY KEY (`idNota`),
   FOREIGN KEY (`idUsuario`) REFERENCES Usuario(`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Evento` (
   `idEvento` int(11) NOT NULL AUTO_INCREMENT,
   `idUsuario` int(11) NOT NULL,
   `ubicacion` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
   `informacion` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
   `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
   `fecha` DATETIME  COLLATE utf8mb4_general_ci NOT NULL,
   `estado` int(1) NOT NULL,
   `idForo` int(11) NOT NULL,
   PRIMARY KEY (`idEvento`),
   FOREIGN KEY (`idUsuario`) REFERENCES Usuario(`id`) ON DELETE CASCADE,   
   FOREIGN KEY (`idForo`) REFERENCES Foro(`idForo`) ON DELETE CASCADE

) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `images` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `idUsuario` int(11) NOT NULL,
 `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 `idEvento` int(11) COLLATE utf8_unicode_ci,
 `idProducto` int(11) COLLATE utf8_unicode_ci,
 `idNotificacion` int(11) COLLATE utf8_unicode_ci,
 `idNoticia` int(11) COLLATE utf8_unicode_ci,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`idUsuario`) REFERENCES Usuario(`id`) ON DELETE CASCADE,
   FOREIGN KEY (`idEvento`) REFERENCES Evento(`idEvento`) ON DELETE CASCADE,
   FOREIGN KEY (`idProducto`) REFERENCES Producto(`idProducto`) ON DELETE CASCADE,
   FOREIGN KEY (`idNotificacion`) REFERENCES Notificacion(`idNotificacion`) ON DELETE CASCADE,
   FOREIGN KEY (`idNoticia`) REFERENCES Noticias(`idNoticia`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `Participantes` (
 `idUsuario` int(11) NOT NULL,
 `idEvento`  int(11) ,
 `idForo`  int(11) ,
 FOREIGN KEY (`idUsuario`) REFERENCES Usuario(`id`) ON DELETE CASCADE,
 FOREIGN KEY (`idEvento`) REFERENCES Evento(`idEvento`) ON DELETE CASCADE,
 FOREIGN KEY (`idForo`) REFERENCES Foro(`idForo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `Producto` (
   `idProducto` int(11) NOT NULL AUTO_INCREMENT,
   `informacion` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
   `nombre` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
   `precio` int(11) NOT NULL,
   `estado` varchar(15) NOT NULL,
   PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Pedido` (
   `idPedido` int(11) NOT NULL AUTO_INCREMENT,
   `idUsuario` int(11) NOT NULL,
   `estado` varchar(15) NOT NULL,
   `precio` int(11) NOT NULL,
   FOREIGN KEY (`idUsuario`) REFERENCES Usuario(`id`) ON DELETE CASCADE ,
   PRIMARY KEY (`idPedido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `ContenidoPedidos` (
    `idPedido` int(11) NOT NULL AUTO_INCREMENT,
   `idProducto` int(11) NOT NULL,
   `idUsuario` int(11) NOT NULL,
   `cantidad` int(11) NOT NULL,
   FOREIGN KEY (`idProducto`) REFERENCES Producto(`idProducto`) ,
   FOREIGN KEY (`idPedido`) REFERENCES Pedido(`idPedido`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Mensaje` (
   `idMensaje` int(11) NOT NULL AUTO_INCREMENT,
   `idEmisor` int(11) NOT NULL,
   `idRemitente` int(11) NOT NULL,
   `fecha` DATETIME  COLLATE utf8mb4_general_ci NOT NULL,
   `texto` varchar(200) NOT NULL,
   `leido` int(11) NOT NULL DEFAULT 0,
   FOREIGN KEY (`idEmisor`) REFERENCES Usuario(`id`),
   PRIMARY KEY (`idMensaje`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `Notificacion` (
   `idNotificacion` int(11) NOT NULL AUTO_INCREMENT,
   `idEmisor` int(11),
   `idRemitente` int(11) NOT NULL,
   `fecha` DATE  COLLATE utf8mb4_general_ci NOT NULL,
   `texto` varchar(200) NOT NULL,
   `leida` boolean NOT NULL,
   `intro` varchar(200) NOT NULL,
   `tipo` varchar(200) NOT NULL,
   `idForo` int(11),
   `idPedido` int(11),
   FOREIGN KEY (`idEmisor`) REFERENCES Usuario(`id`) ON DELETE CASCADE,
   FOREIGN KEY (`idForo`) REFERENCES Foro(`idForo`) ON DELETE CASCADE,
   FOREIGN KEY (`idPedido`) REFERENCES Pedido(`idPedido`) ON DELETE CASCADE,
   PRIMARY KEY (`idNotificacion`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `Foro`(
   `idForo` int(11) NOT NULL AUTO_INCREMENT,
   `idUsuario` int(11) NOT NULL,
   `fecha` DATETIME  COLLATE utf8mb4_general_ci NOT NULL,
   `tema` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
   `contenido` varchar(1000) COLLATE utf8mb4_general_ci NOT NULL,
   FOREIGN KEY (`idUsuario`) REFERENCES Usuario(`id`) ON DELETE CASCADE,
   PRIMARY KEY (`idForo`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `MensajeForo`(
   `idMensajeForo` int(11) NOT NULL AUTO_INCREMENT,
   `idForo` int(11) NOT NULL,
   `idUsuario` int(11) NOT NULL,
   `fecha` DATETIME  COLLATE utf8mb4_general_ci NOT NULL,
   `contenido` varchar(700) COLLATE utf8mb4_general_ci NOT NULL,
   `leido` int(11) NOT NULL DEFAULT 0,
   FOREIGN KEY (`idForo`) REFERENCES Foro(`idForo`) ON DELETE CASCADE,
   FOREIGN KEY (`idUsuario`) REFERENCES Usuario(`id`) ON DELETE CASCADE,
   PRIMARY KEY (`idMensajeForo`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `Noticias`(
   `idNoticia` int(11) NOT NULL AUTO_INCREMENT,
   `titulo` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
   `cuerpo` varchar(2000) COLLATE utf8mb4_general_ci NOT NULL,
   `fecha` DATE  COLLATE utf8mb4_general_ci NOT NULL,
   `categoria` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
   PRIMARY KEY (`idNoticia`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Para probar*/
CREATE TABLE IF NOT EXISTS `tbl_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `idEvento` int (11) NOT NULL,
  `title` varchar(255) COLLATE utf8_bin NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
   FOREIGN KEY (`idUsuario`) REFERENCES Usuario(`id`) ON DELETE CASCADE,
   FOREIGN KEY (`idEvento`) REFERENCES Evento(`idEvento`) ON DELETE CASCADE,
   PRIMARY KEY (`id`)
)ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


