-- -----------------------------------------------------
-- Script SQL para charcuteriacyc.com ------------------
-- Autor: Arturo Casas ---------------------------------
-- E-mail: arzzz@hotmail.es ----------------------------
-- Descripción: Creación de base de datos y tablas -----
-- -----------------------------------------------------

-- Borramos la base de datos si ya existe, para reiniciar todo..
-- DROP SCHEMA IF EXISTS `jxlcvuub_cyc`; 

-- Creamos la base de datos si ésta no existe
-- CREATE SCHEMA IF NOT EXISTS `jxlcvuub_cyc` DEFAULT CHARACTER SET latin1;
USE `jxlcvuub_cyc`;

-- -----------------------------------------------------
-- Creación de tablas
-- -----------------------------------------------------

-- Tabla `jxlcvuub_cyc`.`consultas`
-- Autoincrementar el id_persona provoca que errores al insertar haga pasar números y por lo tanto no sean correlativos, para evitar se modifica parámetro innodb_autoinc_lock_mode=0 en C:\wamp64\bin\mysql\mysql5.7.14
DROP TABLE IF EXISTS `jxlcvuub_cyc`.`consultas`;
CREATE TABLE IF NOT EXISTS `jxlcvuub_cyc`.`consultas` (
	`id_consulta` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID auto-incremental, empezando en 0, único, modificable y no nulo',
	`nombre` VARCHAR(100) NOT NULL COMMENT 'Nombre propio que deberán tener todos los contactos',
	`apellidos` VARCHAR(500) NULL COMMENT 'Apellidos no obligatorios',
	`telefono` VARCHAR(20) NULL COMMENT 'Teléfono no obligatorio',
	`email` VARCHAR(50) NOT NULL COMMENT 'E-mail obligatorio del usuario',
	`consulta` TEXT NOT NULL COMMENT 'Mensaje de consulta requerido',
	`fecha_creacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro, que se autoinsertará y gracias a TRIGGER no podrá ser modificada',
	`publicidad` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'Acepta publicidad TRUE(1) o FALSE(0)',
	CONSTRAINT `PK_consultas`
		PRIMARY KEY (`id_consulta`,`email`)
	-- INDEX `IX_PK_consultas` (`id_persona` ASC), el indice se crea sólo al definir la PK
	-- INDEX `IX_consultas_email` (`email` ASC) el índice se crea sólo al definir UNIQUE
)

ENGINE = InnoDB;

-- Tabla `jxlcvuub_cyc`.`registro`
-- Autoincrementar el id_registro provoca que errores al insertar haga pasar números y por lo tanto no sean correlativos, para evitar se modifica parámetro innodb_autoinc_lock_mode=0 en C:\wamp64\bin\mysql\mysql5.7.14
DROP TABLE IF EXISTS `jxlcvuub_cyc`.`registro`;
CREATE TABLE IF NOT EXISTS `jxlcvuub_cyc`.`registro` (
	`id_registro` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'ID auto-incremental, empezando en 0, único, modificable y no nulo',
	`id_consulta` INT(11) NULL COMMENT 'FK de la consulta registrada en la tabla consultas si la hubiera',
	`fecha_creacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro, que se autoinsertará y gracias a TRIGGER no podrá ser modificada',
	`IP` VARCHAR(50) NOT NULL COMMENT 'IP que realiza la operación',
	`codigoerror` INT(10) NULL COMMENT 'Código de error si lo hubiera',
	`descripcionerror` VARCHAR(500) NULL COMMENT 'Descripción de error si lo hubiera',
	`resultado` VARCHAR(500) NOT NULL COMMENT 'Resultado que siempre se le muestra al usuario por pantalla',
	`nombre` VARCHAR(100) NULL COMMENT 'Nombre propio que deberán tener todos los contactos',
	`telefono` VARCHAR(20) NULL COMMENT 'Teléfono no obligatorio',
	`email` VARCHAR(50) NULL COMMENT 'E-mail obligatorio del usuario',
	`consulta` TEXT NULL COMMENT 'Mensaje de consulta requerido',
	CONSTRAINT `PK_registro`
		PRIMARY KEY (`id_registro`),
	CONSTRAINT `FK_registro_consultas`
		FOREIGN KEY (`id_consulta`)
    	REFERENCES `jxlcvuub_cyc`.`consultas` (`id_consulta`)
    	ON DELETE SET NULL
    	ON UPDATE CASCADE
	-- INDEX `IX_PK_consultas` (`id_persona` ASC), el indice se crea sólo al definir la PK
	-- INDEX `IX_consultas_email` (`email` ASC) el índice se crea sólo al definir UNIQUE
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
DROP TRIGGER IF EXISTS `CON_fecha_creacion`//
CREATE TRIGGER CON_fecha_creacion BEFORE UPDATE  
ON `jxlcvuub_cyc`.`consultas`
FOR EACH ROW
BEGIN
	IF NEW.`fecha_creacion` <> OLD.`fecha_creacion` THEN
		SET NEW.`fecha_creacion`=OLD.`fecha_creacion`;
	END IF;
END//
DROP TRIGGER IF EXISTS `REG_fecha_creacion`//
CREATE TRIGGER REG_fecha_creacion BEFORE UPDATE  
ON `jxlcvuub_cyc`.`registro`
FOR EACH ROW
BEGIN
	IF NEW.`fecha_creacion` <> OLD.`fecha_creacion` THEN
		SET NEW.`fecha_creacion`=OLD.`fecha_creacion`;
	END IF;
END//
DELIMITER ;