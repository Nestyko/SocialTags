-- MySQL dump 10.15  Distrib 10.0.25-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: red_social
-- ------------------------------------------------------
-- Server version	10.0.25-MariaDB-0ubuntu0.16.04.1
--
-- Table structure for table `comentario`
--

DROP TABLE IF EXISTS `comentario`;

CREATE TABLE `comentario` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `contenido` varchar(256) NOT NULL,
  `publicacion` int(11) NOT NULL,
  `usuario_correo` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Comentario_Publicacion1_idx` (`publicacion`),
  KEY `fk_Comentario_Usuario1_idx` (`usuario_correo`),
  CONSTRAINT `fk_Comentario_Publicacion1` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comentario_Usuario1` FOREIGN KEY (`usuario_correo`) REFERENCES `usuario` (`correo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `imagen`;

CREATE TABLE `imagen` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `url` varchar(256) NOT NULL,
  `publicacion` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Imagen_Publicacion1_idx` (`publicacion`),
  CONSTRAINT `fk_Imagen_Publicacion1` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `publicacion`;
CREATE TABLE `publicacion` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `contenido` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `tag`;

CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(256) NOT NULL,
  `usuario_correo` varchar(250) NOT NULL,
  `publicacion` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Tag_Usuario1_idx` (`usuario_correo`),
  KEY `fk_Tag_Publicacion1_idx` (`publicacion`),
  CONSTRAINT `fk_Tag_Publicacion1` FOREIGN KEY (`publicacion`) REFERENCES `publicacion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tag_Usuario1` FOREIGN KEY (`usuario_correo`) REFERENCES `usuario` (`correo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;



CREATE TABLE `usuario` (
  `correo` varchar(250) NOT NULL,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  PRIMARY KEY (`correo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



CREATE TABLE `usuario_has_imagen` (
  `usuario_correo` varchar(250) NOT NULL,
  `imagen` int(11) NOT NULL,
  PRIMARY KEY (`usuario_correo`,`imagen`),
  KEY `fk_Usuario_has_Imagen_Imagen1_idx` (`imagen`),
  KEY `fk_Usuario_has_Imagen_Usuario1_idx` (`usuario_correo`),
  CONSTRAINT `fk_Usuario_has_Imagen_Imagen1` FOREIGN KEY (`imagen`) REFERENCES `imagen` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Imagen_Usuario1` FOREIGN KEY (`usuario_correo`) REFERENCES `usuario` (`correo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





CREATE TABLE `usuario_has_usuario` (
  `usuario_correo` varchar(250) NOT NULL,
  `usuario_correo1` varchar(250) NOT NULL,
  PRIMARY KEY (`usuario_correo`,`usuario_correo1`),
  KEY `fk_Usuario_has_Usuario_Usuario1_idx` (`usuario_correo1`),
  KEY `fk_Usuario_has_Usuario_Usuario_idx` (`usuario_correo`),
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario` FOREIGN KEY (`usuario_correo`) REFERENCES `usuario` (`correo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario1` FOREIGN KEY (`usuario_correo1`) REFERENCES `usuario` (`correo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `buscarUsuario`(x varchar(250)) RETURNS varchar(250) CHARSET utf8mb4
begin
  declare resultado varchar(250);
  if exists(select * from usuario where usuario.correo = x ) then
  select concat(nombre," ",apellido) into resultado from usuario where correo = x;
  else
  select "No existe ninguna persona con ese nombre" into resultado;
  end if;
  return resultado;
  end ;;
DELIMITER ;


DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarAmigo`(IN correo_usuario varchar(100), IN correo_amigo varchar(100))
BEGIN  
    INSERT INTO Usuario_has_Usuario(usuario_correo, usuario_correo1)
        SELECT * FROM (SELECT correo_usuario, correo_amigo) AS tmp
            WHERE NOT EXISTS (
        SELECT usuario_correo, usuario_correo1 FROM Usuario_has_Usuario  
            WHERE usuario_correo=correo_usuario AND usuario_correo1=correo_amigo
    )LIMIT 1;
END ;;
DELIMITER ;



DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `crearTag`(`t` VARCHAR(250), `correo` VARCHAR(250), `IDP` INT(11))
begin
if not exists(select * from tag where tag.tag = t) then
insert into tag (tag,usuario_correo,publicacion) values(t,correo,IDP);
else
select "Tag repetido";
end if;
end ;;
DELIMITER ;


DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `registrarse`(`c` VARCHAR(250), `n` VARCHAR(250), `a` VARCHAR(250), `fec` DATE)
begin
if not exists(select usuario.correo from usuario where usuario.correo = c) then
insert into usuario values(c,n,a,fec);
else
select "Este Usuario ya esta registrar";
end if;
end ;;
DELIMITER ;

