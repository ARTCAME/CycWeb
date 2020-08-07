-- -----------------------------------------------------
-- Inserts
-- -----------------------------------------------------

USE `cyc`;
-- Datos de ejemplo para `cyc`.`personas`
INSERT INTO `cyc`.`personas` (`id_persona`,`nombre`,`apellidos`,`telefono`,`email`,`contactos`,`fecha_creacion`) VALUES (NULL,'Nombre1','Apellidos1','689999999','email@ejemplo.1',0,DEFAULT);
INSERT INTO `cyc`.`personas` (`id_persona`,`nombre`,`apellidos`,`telefono`,`email`,`contactos`,`fecha_creacion`) VALUES (NULL,'Nombre2','Apellidos2','689999999','email@ejemplo.2',0,DEFAULT);
INSERT INTO `cyc`.`personas` (`id_persona`,`nombre`,`apellidos`,`telefono`,`email`,`contactos`,`fecha_creacion`) VALUES (NULL,'Nombre3','Apellidos3','689999999','email@ejemplo.3',0,DEFAULT);
INSERT INTO `cyc`.`personas` (`id_persona`,`nombre`,`apellidos`,`telefono`,`email`,`contactos`,`fecha_creacion`) VALUES (NULL,'Nombre4','Apellidos4','689999999','email@ejemplo.4',0,DEFAULT);
INSERT INTO `cyc`.`personas` (`id_persona`,`nombre`,`apellidos`,`telefono`,`email`,`contactos`,`fecha_creacion`) VALUES (NULL,'Nombre5','Apellidos5','689999999','email@ejemplo.5',0,DEFAULT);

-- Datos de ejemplo para `cyc`.`contactos`
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=1),'1 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=2),'2 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=3),'3 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=4),'4 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=5),'5 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=1),'1 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=1),'2 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=1),'3 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=1),'4 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=5),'5 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=5),'1 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=5),'2 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=3),'3 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=3),'4 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);
INSERT INTO `cyc`.`contactos` (`id_contacto`,`id_persona`,`consulta`,`fecha_contacto`) VALUES (NULL,(SELECT p.id_persona FROM personas p WHERE p.id_persona=5),'5 Texto de consulta de ejemplo, aquí irían las consultas de los clientes.',DEFAULT);

-- Por defecto, al insertar una persona tiene en la columna "contactos" valor 0, a continuación insertamos el total de consultas que cada usuario ha dejado
UPDATE personas UC set UC.contactos=(SELECT COUNT(id_persona) FROM contactos WHERE id_persona=UC.id_persona);