-- -----------------------------------------------------
-- Inserts
-- -----------------------------------------------------

USE `cyc`;
-- Datos de ejemplo para `cyc`.`personas`
INSERT INTO `cyc`.`consultas` (`id_persona`,`nombre`,`apellidos`,`telefono`,`email`,`consulta`,`fecha_creacion`) VALUES (NULL,'Nombre1','Apellidos1','689999999','email@ejemplo.1','Texto de ejemplo',DEFAULT);

-- Por defecto, al insertar una persona tiene en la columna "contactos" valor 0, a continuación insertamos el total de consultas que cada usuario ha dejado
UPDATE personas UC set UC.contactos=(SELECT COUNT(id_persona) FROM contactos WHERE id_persona=UC.id_persona);