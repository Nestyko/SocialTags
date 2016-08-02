SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `red` DEFAULT CHARACTER SET latin1 ;
USE `red` ;

-- -----------------------------------------------------
-- Table `red`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `red`.`usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `correo` VARCHAR(250) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `pass` VARCHAR(250) NOT NULL,
  `educacion` VARCHAR(250) NULL DEFAULT NULL,
  `destresas` VARCHAR(250) NULL DEFAULT NULL,
  `perfil` VARCHAR(250) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 25
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `red`.`publicacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `red`.`publicacion` (
  `idp` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `contenido` VARCHAR(256) NULL DEFAULT NULL,
  `usuario` INT(11) NOT NULL,
  PRIMARY KEY (`idp`),
  INDEX `fk_Publicacion_Usuario1_idx` (`usuario` ASC),
  CONSTRAINT `fk_Publicacion_Usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 5
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `red`.`comentario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `red`.`comentario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `contenido` VARCHAR(256) NOT NULL,
  `publicacion` INT(11) NOT NULL,
  `usuario` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Comentario_Publicacion1_idx` (`publicacion` ASC),
  INDEX `fk_Comentario_Usuario1_idx` (`usuario` ASC),
  CONSTRAINT `fk_Comentario_Publicacion1`
    FOREIGN KEY (`publicacion`)
    REFERENCES `red`.`publicacion` (`idp`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comentario_Usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `red`.`imagen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `red`.`imagen` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(256) NULL DEFAULT NULL,
  `url` VARCHAR(256) NOT NULL,
  `publicacion` INT(11) NOT NULL,
  `usuario_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Imagen_Publicacion1_idx` (`publicacion` ASC),
  INDEX `fk_imagen_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_Imagen_Publicacion1`
    FOREIGN KEY (`publicacion`)
    REFERENCES `red`.`publicacion` (`idp`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_imagen_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `red`.`tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `red`.`tag` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tag` VARCHAR(256) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `publicacion` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_Tag_Usuario1_idx` (`usuario` ASC),
  INDEX `fk_Tag_Publicacion1_idx` (`publicacion` ASC),
  CONSTRAINT `fk_Tag_Publicacion1`
    FOREIGN KEY (`publicacion`)
    REFERENCES `red`.`publicacion` (`idp`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Tag_Usuario1`
    FOREIGN KEY (`usuario`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `red`.`usuario_has_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `red`.`usuario_has_usuario` (
  `usuario` INT(11) NOT NULL,
  `usuario1` INT(11) NOT NULL,
  PRIMARY KEY (`usuario`, `usuario1`),
  INDEX `fk_Usuario_has_Usuario_Usuario1_idx` (`usuario1` ASC),
  INDEX `fk_Usuario_has_Usuario_Usuario_idx` (`usuario` ASC),
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario`
    FOREIGN KEY (`usuario`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_has_Usuario_Usuario1`
    FOREIGN KEY (`usuario1`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `red`.`usuario_has_tag`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `red`.`usuario_has_tag` (
  `usuario_id` INT(11) NOT NULL,
  `tag_id` INT(11) NOT NULL,
  PRIMARY KEY (`usuario_id`, `tag_id`),
  INDEX `fk_usuario_has_tag_tag1_idx` (`tag_id` ASC),
  INDEX `fk_usuario_has_tag_usuario1_idx` (`usuario_id` ASC),
  CONSTRAINT `fk_usuario_has_tag_usuario1`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_tag_tag1`
    FOREIGN KEY (`tag_id`)
    REFERENCES `red`.`tag` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;

USE `red` ;

-- -----------------------------------------------------
-- procedure agregarAmigo
-- -----------------------------------------------------

DELIMITER $$
USE `red`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `agregarAmigo`(IN correo_usuario varchar(100), IN correo_amigo varchar(100))
BEGIN  
    INSERT INTO Usuario_has_Usuario(usuario_correo, usuario_correo1)
        SELECT * FROM (SELECT correo_usuario, correo_amigo) AS tmp
            WHERE NOT EXISTS (
        SELECT usuario_correo, usuario_correo1 FROM Usuario_has_Usuario  
            WHERE usuario_correo=correo_usuario AND usuario_correo1=correo_amigo
    )LIMIT 1;
END$$

DELIMITER ;

-- -----------------------------------------------------
-- function buscarUsuario
-- -----------------------------------------------------

DELIMITER $$
USE `red`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `buscarUsuario`(x varchar(250)) RETURNS varchar(250) CHARSET utf8mb4
begin
  declare resultado varchar(250);
  if exists(select * from usuario where usuario.correo = x ) then
  select concat(nombre," ",apellido) into resultado from usuario where correo = x;
  else
  select "No existe ninguna persona con ese nombre" into resultado;
  end if;
  return resultado;
  end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure crearTag
-- -----------------------------------------------------

DELIMITER $$
USE `red`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `crearTag`(`t` VARCHAR(250), `correo` VARCHAR(250), `IDP` INT(11))
begin
if not exists(select * from tag where tag.tag = t) then
insert into tag (tag,usuario_correo,publicacion) values(t,correo,IDP);
else
select "Tag repetido";
end if;
end$$

DELIMITER ;

-- -----------------------------------------------------
-- procedure registrarse
-- -----------------------------------------------------

DELIMITER $$
USE `red`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `registrarse`(IN `c` VARCHAR(250), IN `n` VARCHAR(250), IN `a` VARCHAR(250), IN `fec` DATE, IN `pas` VARCHAR(250))
    DETERMINISTIC
begin
insert into usuario (correo,nombre,apellido,fecha_nacimiento,pass) values (c,n,a,fec,pas);

end$$

DELIMITER ;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
