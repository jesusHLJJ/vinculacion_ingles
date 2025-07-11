CREATE TABLE `administradores` (
  `id_admin` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` char(50) DEFAULT null,
  `ap_paterno` char(50) DEFAULT null,
  `ap_materno` char(50) DEFAULT null,
  `id_usuario` int NOT NULL
);

CREATE TABLE `notas` (
  `id_nota` int PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nota_parcial1` char(5),
  `nota_parcial2` char(5),
  `nota_parcial3` char(5)
);

CREATE TABLE `alumnos` (
  `matricula` int(11) PRIMARY KEY NOT NULL,
  `nombre` char(50) DEFAULT null,
  `ap_paterno` char(50) DEFAULT null,
  `ap_materno` char(50) DEFAULT null,
  `edad` char(50) DEFAULT null,
  `id_carrera` int(11) DEFAULT null,
  `telefono` char(15) DEFAULT null,
  `sexo` char(10) DEFAULT null,
  `id_nivel` int(11) DEFAULT null,
  `id_estatus` int(11) DEFAULT null,
  `id_usuarios` int(11) DEFAULT null,
  `id_expediente` int(11) DEFAULT null,
  `id_nota` int(11) DEFAULT null
);

CREATE TABLE `carreras` (
  `id_carrera` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre_carrera` char(50) DEFAULT null
);

CREATE TABLE `expediente` (
  `id_expediente` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nivel` int(11) DEFAULT null,
  `lin_captura` text DEFAULT null,
  `soli_aspirante` text DEFAULT null,
  `act_nac` text DEFAULT null,
  `comp_estu` text DEFAULT null,
  `ine` text DEFAULT null,
  `comp_pago` text DEFAULT null,
  `lin_captura_t` text DEFAULT null,
  `fecha_pago` date DEFAULT null,
  `fecha_entrega` date DEFAULT null
);

CREATE TABLE `documentos_nivel` (
  `id_documento` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_nivel` int(11) NOT NULL,
  `acta_calificacion` text DEFAULT null,
  `acta_calificacion_2` text DEFAULT null,
  `acta_calificacion_3` text DEFAULT null,
  `acta_libreacion` text DEFAULT null,
  `lista_1` text DEFAULT null,
  `lista_2` text DEFAULT null,
  `lista_3` text DEFAULT null
);

CREATE TABLE `documentos_profesor` (
  `id_documento` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_nivel` int(11) DEFAULT null,
  `planeacion_estrategica` text DEFAULT null,
  `avance_programatico_1` text DEFAULT null,
  `avance_programatico_2` text DEFAULT null,
  `avance_programatico_3` text DEFAULT null,
  `plan_profesor` text DEFAULT null,
  `avance_profesor_1` text DEFAULT null,
  `avance_profesor_2` text DEFAULT null,
  `avance_profesor_3` text DEFAULT null
);

CREATE TABLE `documento_expediente` (
  `id_registro` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `id_expediente` int(11) DEFAULT null,
  `nivel` int(11) DEFAULT null,
  `const_na` text DEFAULT null,
  `comp_pago` text DEFAULT null,
  `lin_captura` text DEFAULT null
);

CREATE TABLE `estado_civil` (
  `id_estado_civil` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `estado_civil` char(50) DEFAULT null
);

CREATE TABLE `estatus_alumnos` (
  `id_estatus_alumno` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `estatus_alumno` char(50) DEFAULT null
);

CREATE TABLE `municipios` (
  `id_municipio` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre_municipio` char(100) DEFAULT null
);

CREATE TABLE `niveles` (
  `id_nivel` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nivel` char(3) DEFAULT null,
  `grupo` char(3) DEFAULT null,
  `aula` char(10) DEFAULT null,
  `id_profesor` int(11) DEFAULT null,
  `cupo_max` char(3) DEFAULT null,
  `id_periodo` int(11) DEFAULT null,
  `modalidad` char(50) DEFAULT null,
  `horario` char(50) DEFAULT null
);

CREATE TABLE `periodos` (
  `id_periodo` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `periodo` char(50) DEFAULT null
);

CREATE TABLE `profesores` (
  `id_profesor` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nombre` char(50) DEFAULT null,
  `ap_paterno` char(50) DEFAULT null,
  `ap_materno` char(50) DEFAULT null,
  `edad` int(11) DEFAULT null,
  `id_estado_civil` int(11) DEFAULT null,
  `sexo` char(9) DEFAULT null,
  `calle` text DEFAULT null,
  `numero` char(50) DEFAULT null,
  `colonia` text DEFAULT null,
  `codigo_postal` char(6) DEFAULT null,
  `id_municipio` int(11) DEFAULT null,
  `estado` char(50) DEFAULT null,
  `rfc` char(10) DEFAULT null,
  `estatus` char(10) DEFAULT null,
  `id_usuario` int(11) DEFAULT null
);

CREATE TABLE `tipos_usuarios` (
  `id_tipo` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `tipo_usuario` char(50) DEFAULT null
);

CREATE TABLE `usuarios` (
  `id_usuario` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `correo` char(255) DEFAULT null,
  `contrasena` text DEFAULT null,
  `id_tipo` int(11) DEFAULT null
);

ALTER TABLE `alumnos` ADD CONSTRAINT `ID_CARRERAS1` FOREIGN KEY (`id_carrera`) REFERENCES `carreras` (`id_carrera`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `alumnos` ADD CONSTRAINT `ID_ESTATUS1` FOREIGN KEY (`id_estatus`) REFERENCES `estatus_alumnos` (`id_estatus_alumno`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `alumnos` ADD CONSTRAINT `ID_NIVELES1` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `alumnos` ADD CONSTRAINT `ID_USUARIOS2` FOREIGN KEY (`id_usuarios`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `documentos_nivel` ADD CONSTRAINT `ID_NIVELES` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `documentos_profesor` ADD CONSTRAINT `ID_NIVELES3` FOREIGN KEY (`id_nivel`) REFERENCES `niveles` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `niveles` ADD CONSTRAINT `ID_PERIODOS` FOREIGN KEY (`id_periodo`) REFERENCES `periodos` (`id_periodo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `niveles` ADD CONSTRAINT `ID_PROFESORES1` FOREIGN KEY (`id_profesor`) REFERENCES `profesores` (`id_profesor`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `profesores` ADD CONSTRAINT `ID_ESTADO_CIVIL` FOREIGN KEY (`id_estado_civil`) REFERENCES `estado_civil` (`id_estado_civil`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `profesores` ADD CONSTRAINT `ID_MUNIPIOS` FOREIGN KEY (`id_municipio`) REFERENCES `municipios` (`id_municipio`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `profesores` ADD CONSTRAINT `ID_USUARIOS` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `usuarios` ADD CONSTRAINT `ID_TIPO_USUARIO` FOREIGN KEY (`id_tipo`) REFERENCES `tipos_usuarios` (`id_tipo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `alumnos` ADD FOREIGN KEY (`id_expediente`) REFERENCES `expediente` (`id_expediente`);

ALTER TABLE `documento_expediente` ADD FOREIGN KEY (`id_expediente`) REFERENCES `expediente` (`id_expediente`);

ALTER TABLE `alumnos` ADD FOREIGN KEY (`id_nota`) REFERENCES `notas` (`id_nota`);

ALTER TABLE `administradores` ADD FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
