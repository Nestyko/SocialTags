-- -----------------------------------------------------
-- Table `usuario`
-- -----------------------------------------------------
CREATE TABLE `usuario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `correo` VARCHAR(250) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `fecha_nacimiento` DATE NOT NULL,
  `pass` VARCHAR(250) NOT NULL,
  `educacion` VARCHAR(250) NULL DEFAULT NULL,
  `destresas` VARCHAR(250) NULL DEFAULT NULL,
  `perfil` VARCHAR(250) NULL DEFAULT NULL,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Table `publicacion`
-- -----------------------------------------------------
CREATE TABLE IF `publicacion` (
  `idp` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `contenido` VARCHAR(256) NULL DEFAULT NULL,
  `usuario` INT(11) NOT NULL,
  PRIMARY KEY (`idp`),
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`id`)
    ON DELETE CASCADE);


-- -----------------------------------------------------
-- Table `comentario`
-- -----------------------------------------------------
CREATE TABLE `comentario` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `contenido` VARCHAR(256) NOT NULL,
  `publicacion` INT(11) NOT NULL,
  `usuario` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`publicacion`)
    REFERENCES `publicacion` (`idp`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
    FOREIGN KEY (`usuario`)
    REFERENCES `usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);

    -- -----------------------------------------------------
-- Table `imagen`
-- -----------------------------------------------------
CREATE TABLE `imagen` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `descripcion` VARCHAR(256) NULL DEFAULT NULL,
  `url` VARCHAR(256) NOT NULL,
  `publicacion` INT(11) NOT NULL,
  `usuario_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`publicacion`)
    REFERENCES `red`.`publicacion` (`idp`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
    FOREIGN KEY (`usuario_id`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

    
-- -----------------------------------------------------
-- Table `tag`
-- -----------------------------------------------------
CREATE TABLE `tag` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `tag` VARCHAR(256) NOT NULL,
  `usuario` INT(11) NOT NULL,
  `publicacion` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
    FOREIGN KEY (`publicacion`)
    REFERENCES `red`.`publicacion` (`idp`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
    FOREIGN KEY (`usuario`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);

-- -----------------------------------------------------
-- Table `usuario_has_usuario`
-- -----------------------------------------------------
CREATE TABLE `usuario_has_usuario` (
  `usuario` INT(11) NOT NULL,
  `usuario1` INT(11) NOT NULL,
  PRIMARY KEY (`usuario`, `usuario1`),
    FOREIGN KEY (`usuario`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
    FOREIGN KEY (`usuario1`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION);


-- -----------------------------------------------------
-- Table `usuario_has_tag`
-- -----------------------------------------------------
CREATE TABLE `usuario_has_tag` (
  `usuario_id` INT(11) NOT NULL,
  `tag_id` INT(11) NOT NULL,
  PRIMARY KEY (`usuario_id`, `tag_id`),
    FOREIGN KEY (`usuario_id`)
    REFERENCES `red`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`tag_id`)
    REFERENCES `red`.`tag` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
