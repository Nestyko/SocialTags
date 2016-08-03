-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 03-08-2016 a las 05:16:25
-- Versión del servidor: 10.1.13-MariaDB
-- Versión de PHP: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `red`
--
CREATE DATABASE IF NOT EXISTS `red` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `red`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `agregarAmigo`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarAmigo` (IN `correo_usuario` VARCHAR(100), IN `correo_amigo` VARCHAR(100))  BEGIN  
    INSERT INTO Usuario_has_Usuario VALUES(correo_usuario, correo_usuario1);
     
END$$

DROP PROCEDURE IF EXISTS `crearTag`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `crearTag` (IN `t` VARCHAR(250))  begin
if not exists(select * from tag where tag.tag = t) then
insert into tag (tag) values(t);
else
select "Tag repetido";
end if;
end$$

DROP PROCEDURE IF EXISTS `registrarse`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `registrarse` (IN `c` VARCHAR(250), IN `n` VARCHAR(250), IN `a` VARCHAR(250), IN `fec` DATE, IN `pas` VARCHAR(250))  begin

insert into usuario (correo,nombre,apellido,fecha_nacimiento,pass) values (c,n,a,fec,pas);



end$$

--
-- Funciones
--
DROP FUNCTION IF EXISTS `buscarUsuario`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `buscarUsuario` (`x` VARCHAR(250)) RETURNS VARCHAR(250) CHARSET utf8mb4 begin
  declare resultado varchar(250);
  if exists(select * from usuario where usuario.correo = x ) then
  select concat(nombre," ",apellido) into resultado from usuario where correo = x;
  else
  select "No existe ninguna persona con ese nombre" into resultado;
  end if;
  return resultado;
  end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentario`
--

DROP TABLE IF EXISTS `comentario`;
CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `contenido` varchar(256) NOT NULL,
  `publicacion` int(11) NOT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comentario`
--

INSERT INTO `comentario` (`id`, `fecha`, `contenido`, `publicacion`, `usuario`) VALUES
(1, '2016-08-02', 'Fine -.-', 1, 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

DROP TABLE IF EXISTS `imagen`;
CREATE TABLE `imagen` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `url` varchar(256) NOT NULL,
  `publicacion` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicacion`
--

DROP TABLE IF EXISTS `publicacion`;
CREATE TABLE `publicacion` (
  `idp` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `contenido` varchar(256) DEFAULT NULL,
  `usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `publicacion`
--

INSERT INTO `publicacion` (`idp`, `fecha`, `contenido`, `usuario`) VALUES
(1, '2016-08-01', 'Let''s get to work', 26),
(2, '2016-08-02', 'On it', 26),
(3, '2016-08-02', 'On it', 26);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `tag` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tag`
--

INSERT INTO `tag` (`id`, `tag`) VALUES
(1, '#primertag'),
(2, '#musica'),
(3, ''),
(4, '#'),
(5, '#Alexander'),
(6, '#libros');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tag_has_publicacion`
--

DROP TABLE IF EXISTS `tag_has_publicacion`;
CREATE TABLE `tag_has_publicacion` (
  `tag_id` int(11) NOT NULL,
  `publicacion_idp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `correo` varchar(250) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `pass` varchar(250) NOT NULL,
  `educacion` varchar(250) DEFAULT NULL,
  `destresas` varchar(250) DEFAULT NULL,
  `perfil` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `correo`, `nombre`, `apellido`, `fecha_nacimiento`, `pass`, `educacion`, `destresas`, `perfil`) VALUES
(25, 'aebadell@urbe.edu.ve', 'Alexander', 'Badell', '0000-00-00', '1', NULL, NULL, NULL),
(26, 'nltobon@gmail.com', 'Nestor', 'Tobon', '1994-08-31', '31081994', 'URBE', NULL, '20140427_231109.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_has_tag`
--

DROP TABLE IF EXISTS `usuario_has_tag`;
CREATE TABLE `usuario_has_tag` (
  `usuario_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `usuario_has_tag`
--

INSERT INTO `usuario_has_tag` (`usuario_id`, `tag_id`) VALUES
(25, 1),
(25, 2),
(25, 5),
(26, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_has_usuario`
--

DROP TABLE IF EXISTS `usuario_has_usuario`;
CREATE TABLE `usuario_has_usuario` (
  `usuario` int(11) NOT NULL,
  `usuario1` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Comentario_Publicacion1_idx` (`publicacion`),
  ADD KEY `fk_Comentario_Usuario1_idx` (`usuario`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Imagen_Publicacion1_idx` (`publicacion`),
  ADD KEY `fk_imagen_usuario1_idx` (`usuario_id`);

--
-- Indices de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD PRIMARY KEY (`idp`),
  ADD KEY `fk_Publicacion_Usuario1_idx` (`usuario`);

--
-- Indices de la tabla `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tag_has_publicacion`
--
ALTER TABLE `tag_has_publicacion`
  ADD PRIMARY KEY (`tag_id`,`publicacion_idp`),
  ADD KEY `fk_tag_has_publicacion_publicacion1_idx` (`publicacion_idp`),
  ADD KEY `fk_tag_has_publicacion_tag1_idx` (`tag_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario_has_tag`
--
ALTER TABLE `usuario_has_tag`
  ADD PRIMARY KEY (`usuario_id`,`tag_id`),
  ADD KEY `fk_usuario_has_tag_tag1_idx` (`tag_id`),
  ADD KEY `fk_usuario_has_tag_usuario1_idx` (`usuario_id`);

--
-- Indices de la tabla `usuario_has_usuario`
--
ALTER TABLE `usuario_has_usuario`
  ADD PRIMARY KEY (`usuario`,`usuario1`),
  ADD KEY `fk_Usuario_has_Usuario_Usuario1_idx` (`usuario1`),
  ADD KEY `fk_Usuario_has_Usuario_Usuario_idx` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentario`
--
ALTER TABLE `comentario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `publicacion`
--
ALTER TABLE `publicacion`
  MODIFY `idp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `fk_Comentario_Publicacion1` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`idp`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Comentario_Usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `fk_Imagen_Publicacion1` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`idp`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_imagen_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `publicacion`
--
ALTER TABLE `publicacion`
  ADD CONSTRAINT `fk_Publicacion_Usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `tag_has_publicacion`
--
ALTER TABLE `tag_has_publicacion`
  ADD CONSTRAINT `fk_tag_has_publicacion_publicacion1` FOREIGN KEY (`publicacion_idp`) REFERENCES `publicacion` (`idp`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tag_has_publicacion_tag1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_has_tag`
--
ALTER TABLE `usuario_has_tag`
  ADD CONSTRAINT `fk_usuario_has_tag_tag1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_usuario_has_tag_usuario1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `usuario_has_usuario`
--
ALTER TABLE `usuario_has_usuario`
  ADD CONSTRAINT `fk_Usuario_has_Usuario_Usuario` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Usuario_has_Usuario_Usuario1` FOREIGN KEY (`usuario1`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
