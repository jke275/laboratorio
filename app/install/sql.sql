-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema laboratorio
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema laboratorio
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `laboratorio` DEFAULT CHARACTER SET utf8 ;
USE `laboratorio` ;

-- -----------------------------------------------------
-- Table `laboratorio`.`inventario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`inventario` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`inventario` (
  `codigo_inv` VARCHAR(50) NOT NULL,
  `nombre_inv` VARCHAR(200) NOT NULL,
  `cantidad_inv` INT NOT NULL,
  `tipo` VARCHAR(50) NOT NULL,
  `imagen` VARCHAR(200) NULL,
  PRIMARY KEY (`codigo_inv`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`mobiliario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`mobiliario` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`mobiliario` (
  `carac_mobiliario` VARCHAR(200) NOT NULL,
  `inventario_codigo_inv` VARCHAR(50) NOT NULL,
  INDEX `fk_mobiliario_inventario1_idx` (`inventario_codigo_inv` ASC),
  PRIMARY KEY (`inventario_codigo_inv`),
  CONSTRAINT `fk_mobiliario_inventario1`
    FOREIGN KEY (`inventario_codigo_inv`)
    REFERENCES `laboratorio`.`inventario` (`codigo_inv`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`equipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`equipo` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`equipo` (
  `marca_equipo` VARCHAR(100) NOT NULL,
  `modelo_equipo` VARCHAR(100) NOT NULL,
  `carac_equipo` VARCHAR(200) NOT NULL,
  `inventario_codigo_inv` VARCHAR(50) NOT NULL,
  INDEX `fk_equipo_inventario1_idx` (`inventario_codigo_inv` ASC),
  PRIMARY KEY (`inventario_codigo_inv`),
  CONSTRAINT `fk_equipo_inventario1`
    FOREIGN KEY (`inventario_codigo_inv`)
    REFERENCES `laboratorio`.`inventario` (`codigo_inv`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`consumibles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`consumibles` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`consumibles` (
  `compra_consumibles` DATE NOT NULL,
  `caducidad_consumibles` DATE NOT NULL,
  `carac_consumibles` VARCHAR(200) NOT NULL,
  `inventario_codigo_inv` VARCHAR(50) NOT NULL,
  INDEX `fk_consumibles_inventario1_idx` (`inventario_codigo_inv` ASC),
  PRIMARY KEY (`inventario_codigo_inv`),
  CONSTRAINT `fk_consumibles_inventario1`
    FOREIGN KEY (`inventario_codigo_inv`)
    REFERENCES `laboratorio`.`inventario` (`codigo_inv`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`material`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`material` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`material` (
  `carac_material` VARCHAR(200) NOT NULL,
  `inventario_codigo_inv` VARCHAR(50) NOT NULL,
  INDEX `fk_material_inventario1_idx` (`inventario_codigo_inv` ASC),
  PRIMARY KEY (`inventario_codigo_inv`),
  CONSTRAINT `fk_material_inventario1`
    FOREIGN KEY (`inventario_codigo_inv`)
    REFERENCES `laboratorio`.`inventario` (`codigo_inv`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`materia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`materia` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`materia` (
  `id_materia` VARCHAR(50) NOT NULL,
  `nombre_materia` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`id_materia`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`maestros`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`maestros` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`maestros` (
  `codigo_maestro` VARCHAR(45) NOT NULL,
  `nombre_maestro` VARCHAR(100) NOT NULL,
  `apellidos_maestro` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`codigo_maestro`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`practica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`practica` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`practica` (
  `id_practica` VARCHAR(200) NOT NULL,
  `nombre_practica` VARCHAR(200) NOT NULL,
  `numero_alumnos_practica` INT NOT NULL,
  `fecha_practica` DATE NOT NULL,
  `hora_practica` TIME NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `hora_solicitud_practica` TIMESTAMP NOT NULL,
  `duracion_practica` VARCHAR(10) NOT NULL,
  `usuario_solicitante` VARCHAR(200) NOT NULL,
  `materia_id_materia` VARCHAR(50) NOT NULL,
  `maestros_codigo_maestro` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_practica`, `materia_id_materia`, `maestros_codigo_maestro`),
  INDEX `fk_practica_materia1_idx` (`materia_id_materia` ASC),
  INDEX `fk_practica_maestros1_idx` (`maestros_codigo_maestro` ASC),
  CONSTRAINT `fk_practica_materia1`
    FOREIGN KEY (`materia_id_materia`)
    REFERENCES `laboratorio`.`materia` (`id_materia`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_practica_maestros1`
    FOREIGN KEY (`maestros_codigo_maestro`)
    REFERENCES `laboratorio`.`maestros` (`codigo_maestro`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`practica_inventario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`practica_inventario` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`practica_inventario` (
  `cantidad` INT UNSIGNED NOT NULL,
  `inventario_codigo_inv` VARCHAR(50) NOT NULL,
  `practica_id_practica` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`inventario_codigo_inv`, `practica_id_practica`),
  INDEX `fk_practica-inventario_inventario1_idx` (`inventario_codigo_inv` ASC),
  INDEX `fk_practica-inventario_practica1_idx` (`practica_id_practica` ASC),
  CONSTRAINT `fk_practica-inventario_inventario1`
    FOREIGN KEY (`inventario_codigo_inv`)
    REFERENCES `laboratorio`.`inventario` (`codigo_inv`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_practica-inventario_practica1`
    FOREIGN KEY (`practica_id_practica`)
    REFERENCES `laboratorio`.`practica` (`id_practica`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`alumnos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`alumnos` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`alumnos` (
  `codigo_alumno` VARCHAR(45) NOT NULL,
  `nombre_alumno` VARCHAR(100) NOT NULL,
  `apellidos_alumno` VARCHAR(200) NOT NULL,
  `carrera` VARCHAR(100) NOT NULL,
  `sancion` DATE NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`codigo_alumno`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`ingresos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`ingresos` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`ingresos` (
  `fecha_ingreso` DATE NOT NULL,
  `hora_ingreso` VARCHAR(45) NOT NULL,
  `hora_salida` VARCHAR(20) NULL,
  `alumnos_codigo_alumno` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`fecha_ingreso`, `hora_ingreso`, `alumnos_codigo_alumno`),
  INDEX `fk_ingresos_alumnos1_idx` (`alumnos_codigo_alumno` ASC),
  CONSTRAINT `fk_ingresos_alumnos1`
    FOREIGN KEY (`alumnos_codigo_alumno`)
    REFERENCES `laboratorio`.`alumnos` (`codigo_alumno`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`tb_codigo_inventario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`tb_codigo_inventario` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`tb_codigo_inventario` (
  `codigo_etiqueta` VARCHAR(50) NOT NULL,
  `estado` VARCHAR(20) NOT NULL,
  `numero_serie` VARCHAR(45) NULL,
  `inventario_codigo_inv` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`codigo_etiqueta`, `inventario_codigo_inv`),
  INDEX `fk_tb_codigo_inventario_inventario1_idx` (`inventario_codigo_inv` ASC),
  CONSTRAINT `fk_tb_codigo_inventario_inventario1`
    FOREIGN KEY (`inventario_codigo_inv`)
    REFERENCES `laboratorio`.`inventario` (`codigo_inv`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`prestamos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`prestamos` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`prestamos` (
  `id_prestamo` VARCHAR(50) NOT NULL,
  `responsable_prestamo` VARCHAR(100) NOT NULL,
  `fecha_prestamo` DATE NOT NULL,
  `fecha_entrega` DATE NULL,
  `objetivo_prestamo` VARCHAR(200) NOT NULL,
  `alumnos_codigo_alumno` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_prestamo`, `alumnos_codigo_alumno`),
  INDEX `fk_prestamos_alumnos1_idx` (`alumnos_codigo_alumno` ASC),
  CONSTRAINT `fk_prestamos_alumnos1`
    FOREIGN KEY (`alumnos_codigo_alumno`)
    REFERENCES `laboratorio`.`alumnos` (`codigo_alumno`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`prestamo_material`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`prestamo_material` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`prestamo_material` (
  `tb_codigo_inventario_codigo_etiqueta` VARCHAR(50) NOT NULL,
  `prestamos_id_prestamo` VARCHAR(50) NOT NULL,
  `recibido` TINYINT(1) NOT NULL,
  PRIMARY KEY (`tb_codigo_inventario_codigo_etiqueta`, `prestamos_id_prestamo`),
  INDEX `fk_prestamo-material_tb_codigo_inventario1_idx` (`tb_codigo_inventario_codigo_etiqueta` ASC),
  INDEX `fk_prestamo_material_prestamos1_idx` (`prestamos_id_prestamo` ASC),
  CONSTRAINT `fk_prestamo-material_tb_codigo_inventario1`
    FOREIGN KEY (`tb_codigo_inventario_codigo_etiqueta`)
    REFERENCES `laboratorio`.`tb_codigo_inventario` (`codigo_etiqueta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_prestamo_material_prestamos1`
    FOREIGN KEY (`prestamos_id_prestamo`)
    REFERENCES `laboratorio`.`prestamos` (`id_prestamo`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`ingreso_practica`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`ingreso_practica` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`ingreso_practica` (
  `no_ingreso_practica` INT NOT NULL AUTO_INCREMENT,
  `fecha_ingreso_practica` TIMESTAMP NOT NULL,
  `hora_ingreso_practica` VARCHAR(45) NOT NULL,
  `practica_id_practica` VARCHAR(200) NOT NULL,
  `alumnos_codigo_alumno` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`no_ingreso_practica`, `practica_id_practica`, `alumnos_codigo_alumno`),
  INDEX `fk_ingreso_practica_practica1_idx` (`practica_id_practica` ASC),
  INDEX `fk_ingreso_practica_alumnos1_idx` (`alumnos_codigo_alumno` ASC),
  CONSTRAINT `fk_ingreso_practica_practica1`
    FOREIGN KEY (`practica_id_practica`)
    REFERENCES `laboratorio`.`practica` (`id_practica`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingreso_practica_alumnos1`
    FOREIGN KEY (`alumnos_codigo_alumno`)
    REFERENCES `laboratorio`.`alumnos` (`codigo_alumno`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`usuarios`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`usuarios` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`usuarios` (
  `user` VARCHAR(50) NOT NULL,
  `nombre_usuario` VARCHAR(200) NOT NULL,
  `apellidos_usuario` VARCHAR(200) NOT NULL,
  `password` VARCHAR(200) NOT NULL,
  `privilegios` TINYINT(1) NOT NULL,
  PRIMARY KEY (`user`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`material_danado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`material_danado` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`material_danado` (
  `numero` INT NOT NULL AUTO_INCREMENT,
  `tb_codigo_inventario_codigo_etiqueta` VARCHAR(50) NOT NULL,
  `alumnos_codigo_alumno` VARCHAR(45) NOT NULL,
  `fecha_danado` DATE NOT NULL,
  PRIMARY KEY (`numero`, `tb_codigo_inventario_codigo_etiqueta`, `alumnos_codigo_alumno`),
  INDEX `fk_material_danado_alumnos1_idx` (`alumnos_codigo_alumno` ASC),
  CONSTRAINT `fk_material_danado_tb_codigo_inventario1`
    FOREIGN KEY (`tb_codigo_inventario_codigo_etiqueta`)
    REFERENCES `laboratorio`.`tb_codigo_inventario` (`codigo_etiqueta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_material_danado_alumnos1`
    FOREIGN KEY (`alumnos_codigo_alumno`)
    REFERENCES `laboratorio`.`alumnos` (`codigo_alumno`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`prestamos_maestro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`prestamos_maestro` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`prestamos_maestro` (
  `id_prestamos_maestro` VARCHAR(50) NOT NULL,
  `responsable_prestamo` VARCHAR(100) NOT NULL,
  `fecha_prestamo_maestro` DATE NOT NULL,
  `fecha_entrega_maestro` DATE NOT NULL,
  `objetivo_prestamo_maestro` VARCHAR(200) NOT NULL,
  `maestros_codigo_maestro` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_prestamos_maestro`, `maestros_codigo_maestro`),
  INDEX `fk_prestamos_maestro_maestros1_idx` (`maestros_codigo_maestro` ASC),
  CONSTRAINT `fk_prestamos_maestro_maestros1`
    FOREIGN KEY (`maestros_codigo_maestro`)
    REFERENCES `laboratorio`.`maestros` (`codigo_maestro`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `laboratorio`.`prestamo_material_maestro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `laboratorio`.`prestamo_material_maestro` ;

CREATE TABLE IF NOT EXISTS `laboratorio`.`prestamo_material_maestro` (
  `tb_codigo_inventario_codigo_etiqueta` VARCHAR(50) NOT NULL,
  `prestamos_maestro_id_prestamos_maestro` VARCHAR(50) NOT NULL,
  `recibido_maestro` TINYINT(1) NOT NULL,
  PRIMARY KEY (`tb_codigo_inventario_codigo_etiqueta`, `prestamos_maestro_id_prestamos_maestro`),
  INDEX `fk_prestamo_material_maestro_tb_codigo_inventario1_idx` (`tb_codigo_inventario_codigo_etiqueta` ASC),
  CONSTRAINT `fk_prestamo_material_maestro_prestamos_maestro1`
    FOREIGN KEY (`prestamos_maestro_id_prestamos_maestro`)
    REFERENCES `laboratorio`.`prestamos_maestro` (`id_prestamos_maestro`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_prestamo_material_maestro_tb_codigo_inventario1`
    FOREIGN KEY (`tb_codigo_inventario_codigo_etiqueta`)
    REFERENCES `laboratorio`.`tb_codigo_inventario` (`codigo_etiqueta`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
