-- -----------------------------------------------------
-- Script SQL para charcuteriacyc.com ------------------
-- Autor: Arturo Casas ---------------------------------
-- E-mail: arzzz@hotmail.es ----------------------------
-- Descripción: Creación de tablas e inserts de ejemplo-
-- -----------------------------------------------------

-- Borramos la base de datos si ya existe, para reiniciar todo..
DROP SCHEMA IF EXISTS `cyc`;

-- Creamos la base de datos si ésta no existe
CREATE SCHEMA IF NOT EXISTS `cyc` DEFAULT CHARACTER SET latin1;
USE `cyc`;

-- -----------------------------------------------------
-- Creación de tablas
-- -----------------------------------------------------

-- Tabla `cyc`.`personas`
DROP TABLE IF EXISTS `cyc`.`personas`;
CREATE TABLE IF NOT EXISTS `cyc`.`personas` (
	`id_persona` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID auto-incremental, empezando en 0, único, modificable y no nulo',
	`nombre` VARCHAR(100) NOT NULL COMMENT 'Nombre propio que deberán tener todos los contactos',
	`apellidos` VARCHAR(500) NULL COMMENT 'Apellidos no obligatorios',
	`telefono` INT(13) NULL COMMENT 'Teléfono no obligatorio',
	`email` VARCHAR(50) NOT NULL COMMENT 'E-mail obligatorio del usuario',
	`contactos` INT(5) NOT NULL COMMENT 'Número de veces que nos ha contactado',
	`fecha_creacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación que se autoinsertará y gracias a TRIGGER no podrá ser modificada',
	CONSTRAINT `PK_personas`
		PRIMARY KEY (`id_persona`),
	CONSTRAINT `personas_email`
		UNIQUE(`email`)
	-- INDEX `IX_PK_personas` (`id_persona` ASC), el indice se crea sólo al definir la PK
	-- INDEX `IX_personas_email` (`email` ASC) el índice se crea sólo al definir UNIQUE
)

ENGINE = InnoDB;

-- Tabla `cyc`.`contactos` 
-- En la gestión del formulario, vinculamos las consultas al e-mail y para asingar el valor de id_persona comprobaremos el e-mail
DROP TABLE IF EXISTS `cyc`.`contactos`;
CREATE TABLE IF NOT EXISTS `cyc`.`contactos` (
	`id_contacto` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID auto-incremental, empezando en 0, único, modificable y no nulo',
	`id_persona` INT(11) NOT NULL COMMENT 'FK de la tabla personas',
	`consulta` TEXT NOT NULL COMMENT 'Mensaje de consulta requerido',
	`fecha_contacto` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de contacto que se autoinsertará y gracias a TRIGGER no podrá ser modificada',
	CONSTRAINT `PK_contactos`
		PRIMARY KEY (`id_contacto`,`id_persona`),
	CONSTRAINT `FK_contactos_personas`
		FOREIGN KEY (`id_persona`)
		REFERENCES `cyc`.`personas`(`id_persona`)
		ON DELETE NO ACTION
		ON UPDATE CASCADE
--	INDEX `IX_PK_contactos` (`id_contacto` ASC), el índice se crea sólo al definir la PK
)

ENGINE = InnoDB;

-- ----------------------------------------------------- 
-- Triggers y Procedures
-- -----------------------------------------------------

-- Creamos trigger que no aplicará actualización a la fecha de creación/contacto ya que ésta será siempre la misma y TIMESTAMP nos la actualiza al aplicar UPDATE
-- No podemos aplicarlo a todas las tablas que tienen fecha_creacion pero sí con un procedimiento
-- https://www.codejobs.biz/es/blog/2014/07/09/como-hacer-un-procedimiento-almacenado-en-mysql-sin-morir-en-el-intento
-- FALTA PODER APLICAR EL MISMO TRIGGER A VARIAS TABLAS Y NO DUPLICAR CÓDIGO
DELIMITER //
DROP TRIGGER IF EXISTS `CON_fecha_contacto`//
CREATE TRIGGER CON_fecha_contacto BEFORE UPDATE  
ON `cyc`.`contactos`
FOR EACH ROW
BEGIN
	IF NEW.`fecha_contacto` <> OLD.`fecha_contacto` THEN
		SET NEW.`fecha_contacto`=OLD.`fecha_contacto`;
	END IF;
END//

DROP TRIGGER IF EXISTS `PER_fecha_creacion`//
CREATE TRIGGER PER_fecha_creacion BEFORE UPDATE  
ON `cyc`.`personas`
FOR EACH ROW
BEGIN
	IF NEW.`fecha_creacion` <> OLD.`fecha_creacion` THEN
		SET NEW.`fecha_creacion`=OLD.`fecha_creacion`;
	END IF;
END//
DELIMITER ;