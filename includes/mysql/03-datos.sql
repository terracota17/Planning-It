INSERT INTO `Usuario` (`id`, `nombreUsuario`, `password`, `nombre`, `apellido`, `correo`, `telefono`, `biografia`, `recibirNotificacionesEventos`) VALUES
(1, 'usuario1', '$2y$10$kvJMwzqK.WChva7CVXHrhuEPuJkdR3anhvzx7qaW5K33bq8kG6uNy', 'Juan Israel', 'Baroffi Gonz&aacute;lez', 'baroffijuan@gmail.com', 672015682, 'Mi biografia', 1),
(2, 'admin1', '$2y$10$Y9rsrSk6pz2arqH9j8ny4uIsqrLxDzMktB0m02opv89E/e5Sk1Cw2', 'Javier', 'Paarra', 'japarra@ucm.es', 123123123, 'Mi biografia', 1),
(3, 'usuario2', '$2y$10$SL4OQ1lu6xxRPPNGkRwRIO4XS2vXYMXGGgwyFlQPUJ23UHtuxlpzS', '&Aacute;ngel', 'Ruiz Hernandez', 'ruiz1@ucm.es', 123123123, 'Mi biografia', 0);

INSERT INTO `tbl_events` (`id`, `idUsuario`, `idEvento`, `title`, `start`, `end`) VALUES
(3, 1, 2, 'Recogida de Basura', '2022-05-19 00:00:00', '2022-05-19 00:00:00');

INSERT INTO `RolesUsuario` (`usuario`, `rol`) VALUES
(1, 2),
(2, 1),
(3, 2),
(4, 2);

INSERT INTO `Producto` (`idProducto`, `informacion`, `nombre`, `precio`, `estado`) VALUES
(1, 'Vuela como los aviones.', 'Tarjeta Gr&aacute;fica RTX.', 900, 'descatalogado'),
(2, 'Bolsa de basura negra.', 'Bolsa de Basura.', 1, 'disponible'),
(3, 'Recogedor de basura para la recogida de basura', 'Recogedor', 5, 'disponible');

INSERT INTO `Pedido` (`idPedido`, `idUsuario`, `estado`, `precio`) VALUES
(2, 2, 'Pagado', 10),
(3, 2, 'pendiente', 1),
(6, 1, 'pendiente', 1);

INSERT INTO `Participantes` (`idUsuario`, `idEvento`, `idForo`) VALUES
(2, NULL, 1),
(1, NULL, 1),
(2, NULL, 3),
(1, NULL, 3),
(3, NULL, 3);

INSERT INTO `Notificacion` (`idNotificacion`, `idEmisor`, `idRemitente`, `fecha`, `texto`, `leida`, `intro`, `tipo`, `idForo`, `idPedido`) VALUES
(2, 2, 1, '2022-05-12', 'Hola!', 0, 'Nuevo Mensaje de Javier', 'chat', NULL, NULL),
(3, 1, 2, '2022-05-12', 'S&iacute;, es en Avenida Federico 11', 0, 'Nuevo mensaje de @Juan Israel en el foro: [Evento organizado por la federaci&oacute;n de tenis de Madrid, Espa&ntilde;a]', 'foro', 3, NULL),
(4, 2, 1, '2022-05-12', 'Vale gracias!!', 0, 'Nuevo mensaje de @Javier en el foro: [Evento organizado por la federaci&oacute;n de tenis de Madrid, Espa&ntilde;a]', 'foro', 3, NULL);

INSERT INTO `Noticias` (`idNoticia`, `titulo`, `cuerpo`, `fecha`, `categoria`) VALUES
(1, 'Kylian Mbappe ficha por el Real Madrid por 10 euros.', 'Noticia de &uacute;ltima hora: Se viene Mbappe. TIC TAC...', '2022-05-12', 'deportes');

INSERT INTO `Nota` (`idNota`, `idUsuario`, `informacion`) VALUES
(1, 2, 'Acordarse de comprar el pan');

INSERT INTO `MensajeForo` (`idMensajeForo`, `idForo`, `idUsuario`, `fecha`, `contenido`, `leido`) VALUES
(2, 1, 2, '2022-05-12 20:40:04', '&iquest;Alguien lo sabe?.', 0),
(3, 1, 1, '2022-05-12 21:12:11', 'Yo creo que es el de mi madre', 0),
(5, 3, 2, '2022-05-12 21:29:38', 'Hola buenas, alguien sabe a d&oacute;nde es exactamente?', 0),
(6, 3, 1, '2022-05-12 21:31:14', 'S&iacute;, es en Avenida Federico 11', 0),
(7, 3, 2, '2022-05-12 21:34:57', 'Vale gracias!!', 0);

INSERT INTO `Mensaje` (`idMensaje`, `idEmisor`, `idRemitente`, `fecha`, `texto`, `leido`) VALUES
(3, 2, 1, '2022-05-12 21:05:33', 'Hola!', 0);

INSERT INTO `images` (`id`, `idUsuario`, `nombre`, `idEvento`, `idProducto`, `idNotificacion`, `idNoticia`) VALUES
(1, 2, 'kylian.jpg', NULL, NULL, NULL, 1),
(2, 2, 'tarjetaGrafica.jpg', NULL, 1, NULL, NULL),
(3, 2, 'BB010-30-26-13.jpg', NULL, 2, NULL, NULL),
(4, 2, '138722772463067G.jpg', NULL, 3, NULL, NULL),
(6, 1, 'contenedores-rsu-copyright-RESIDUOS-PROFESIONAL.jpg', 2, NULL, NULL, NULL),
(7, 1, 'gato.JPG', NULL, NULL, NULL, NULL),
(8, 3, 'giorgina-cristiano-sueldo.jpg', NULL, NULL, NULL, NULL);

INSERT INTO `Foro` (`idForo`, `idUsuario`, `fecha`, `tema`, `contenido`) VALUES
(1, 2, '2022-05-12 08:34:00', '&iquest;Cu&aacute;l es el peor coche del mundo?.', 'Me gustar&iacute;a saberlo.'),
(3, 2, '2022-05-21 00:00:00', 'Concurso de tenis profesional', 'Evento organizado por la federaci&oacute;n de tenis de Madrid, Espa&ntilde;a'),
(4, 1, '2022-05-19 00:00:00', 'Recogida de Basura', 'No olvides traer tu bolsa!');

INSERT INTO `Evento` (`idEvento`, `idUsuario`, `ubicacion`, `informacion`, `nombre`, `fecha`, `estado`, `idForo`) VALUES
(2, 1, 'Parque del Retiro', 'No olvides traer tu bolsa!', 'Recogida de Basura', '2022-05-19 00:00:00', 1, 4);

INSERT INTO `ContenidoPedidos` (`idPedido`, `idProducto`, `idUsuario`, `cantidad`) VALUES
(2, 3, 2, 2),
(3, 2, 2, 1),
(6, 2, 1, 1);
