-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2018 a las 13:06:26
-- Versión del servidor: 10.1.28-MariaDB
-- Versión de PHP: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `academia`
--
CREATE DATABASE IF NOT EXISTS `academia` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `academia`;
GRANT ALL privileges ON academia.* to academia@localhost identified by "academiapass";
-- --------------------------------------------------------

-- -----------------------------------------------------
-- Table `academia`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`users` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `surname` VARCHAR(255) NOT NULL,
  `dni` VARCHAR(9) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `telephone` INT(9) NOT NULL,
  `birthdate` DATE NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `is_active` INT NULL DEFAULT 1,
  `is_administrator` INT NULL DEFAULT NULL,
  `is_trainer` INT NULL DEFAULT NULL,
  `is_pupil` INT NULL DEFAULT NULL,
  `is_competitor` INT NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`spaces`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`spaces` (
  `id_space` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(25) NOT NULL,
  `capacity` INT NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_space`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`courses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`courses` (
  `id_course` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `type` ENUM('Children', 'Adults') NOT NULL,
  `description` VARCHAR(1000) NOT NULL,
  `capacity` INT NOT NULL,
  `days` SET('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday') NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `id_space` INT NULL,
  `id_trainer` INT NOT NULL,
  `price` INT NOT NULL,
  INDEX `fk_courses_users_idx` (`id_trainer` ASC),
  PRIMARY KEY (`id_course`),
  INDEX `fk_courses_spaces1_idx` (`id_space` ASC),
  CONSTRAINT `fk_courses_users`
    FOREIGN KEY (`id_trainer`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_courses_spaces1`
    FOREIGN KEY (`id_space`)
    REFERENCES `academia`.`spaces` (`id_space`)
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`courses_reservations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`courses_reservations` (
  `id_reservation` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `is_confirmed` INT NOT NULL,
  `id_pupil` INT NOT NULL,
  `id_course` INT NOT NULL,
  PRIMARY KEY (`id_reservation`),
  INDEX `fk_courses_reservations_users1_idx` (`id_pupil` ASC),
  INDEX `fk_courses_reservations_courses1_idx` (`id_course` ASC),
  CONSTRAINT `fk_courses_reservations_users1`
    FOREIGN KEY (`id_pupil`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_courses_reservations_courses1`
    FOREIGN KEY (`id_course`)
    REFERENCES `academia`.`courses` (`id_course`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`events`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`events` (
  `id_event` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `price` INT NOT NULL,
  `capacity` INT NOT NULL,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `id_space` INT NULL,
  PRIMARY KEY (`id_event`),
  INDEX `fk_events_spaces1_idx` (`id_space` ASC),
  CONSTRAINT `fk_events_spaces1`
    FOREIGN KEY (`id_space`)
    REFERENCES `academia`.`spaces` (`id_space`)
    ON DELETE SET NULL
    ON UPDATE SET NULL)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`events_reservations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`events_reservations` (
  `id_reservation` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `is_confirmed` VARCHAR(45) NOT NULL,
  `id_event` INT NOT NULL,
  `id_assistant` INT NOT NULL,
  PRIMARY KEY (`id_reservation`),
  INDEX `fk_events_reservations_events1_idx` (`id_event` ASC),
  INDEX `fk_events_reservations_users1_idx` (`id_assistant` ASC),
  CONSTRAINT `fk_events_reservations_events1`
    FOREIGN KEY (`id_event`)
    REFERENCES `academia`.`events` (`id_event`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_events_reservations_users1`
    FOREIGN KEY (`id_assistant`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`tournaments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`tournaments` (
  `id_tournament` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `price` INT NOT NULL,
  PRIMARY KEY (`id_tournament`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`tournaments_reservations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`tournaments_reservations` (
  `id_reservation` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `is_confirmed` INT NOT NULL,
  `id_tournament` INT NOT NULL,
  `id_player` INT NOT NULL,
  PRIMARY KEY (`id_reservation`),
  INDEX `fk_tournaments_reservations_tournaments1_idx` (`id_tournament` ASC),
  INDEX `fk_tournaments_reservations_users1_idx` (`id_player` ASC),
  CONSTRAINT `fk_tournaments_reservations_tournaments1`
    FOREIGN KEY (`id_tournament`)
    REFERENCES `academia`.`tournaments` (`id_tournament`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tournaments_reservations_users1`
    FOREIGN KEY (`id_player`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`draws`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`draws` (
  `id_draw` INT NOT NULL AUTO_INCREMENT,
  `modality` ENUM('individual', 'double') NOT NULL,
  `gender` ENUM('male', 'female') NOT NULL,
  `id_tournament` INT NOT NULL,
  `category` ENUM('children', 'adult', 'veteran') NULL,
  `type` ENUM('regular', 'consolation') NULL,
  PRIMARY KEY (`id_draw`),
  INDEX `fk_draws_tournaments1_idx` (`id_tournament` ASC),
  CONSTRAINT `fk_draws_tournaments1`
    FOREIGN KEY (`id_tournament`)
    REFERENCES `academia`.`tournaments` (`id_tournament`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`matches`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`matches` (
  `id_match` INT NOT NULL AUTO_INCREMENT,
  `rival1a` INT NOT NULL,
  `rival1b` INT NULL,
  `rival2a` INT NOT NULL,
  `rival2b` INT NULL,
  `date` DATE NOT NULL,
  `round` ENUM('champion', 'third place', 'final', 'consolation', 'semifinal', 'cuarterfinal', 'round of 16', 'round of 32') NOT NULL,
  `set1a` INT NULL,
  `set1b` INT NULL,
  `set2a` INT NULL,
  `set2b` INT NULL,
  `set3a` INT NULL,
  `set3b` INT NULL,
  `set4a` INT NULL,
  `set4b` INT NULL,
  `set5a` INT NULL,
  `set5b` INT NULL,
  `id_draw` INT NOT NULL,
  PRIMARY KEY (`id_match`),
  INDEX `fk_matches_draws1_idx` (`id_draw` ASC),
  CONSTRAINT `fk_matches_draws1`
    FOREIGN KEY (`id_draw`)
    REFERENCES `academia`.`draws` (`id_draw`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`notifications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`notifications` (
  `id_notification` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(30) NOT NULL,
  `body` TEXT NOT NULL,
  `sender` INT NOT NULL,
  `receiver` INT NOT NULL,
  PRIMARY KEY (`id_notification`),
  INDEX `fk_notifications_users1_idx` (`sender` ASC),
  INDEX `fk_notifications_users2_idx` (`receiver` ASC),
  CONSTRAINT `fk_notifications_users1`
    FOREIGN KEY (`sender`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_notifications_users2`
    FOREIGN KEY (`receiver`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name`, `surname`, `dni`, `email`, `password`, `telephone`, `birthdate`, `image`, `is_active`, `is_administrator`, `is_trainer`, `is_pupil`, `is_competitor`) VALUES
(1, 'Brais', 'Domínguez Álvarez', '34273074S', 'braisda@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 662485513, '1991-06-10', 'multimedia/images/users/Foto Perfil2.PNG', 1, 1, NULL, NULL, NULL),
(2, 'Francisco', 'Expósito Martínez', '34766251A', 'panocadas@gmail.com', 'a990ba8861d2b344810851e7e6b49104', 666555444, '1984-02-06', 'multimedia/images/users/francisco.jpg', 1, NULL, 1, NULL, NULL),
(3, 'Fátima', 'Rodríguez Souto', '40157844C', 'fatima@gmail.com', 'a990ba8861d2b344810851e7e6b49104', 698659991, '2000-12-13', 'multimedia/images/users/fatima.jpg', 1, NULL, 1, NULL, NULL),
(4, 'Laura', 'Méndez Ferreiro', '34695755P', 'laura@gmail.com', 'c6865cf98b133f1f3de596a4a2894630', 699422322, '1996-09-15', 'multimedia/images/users/laura.jpg', 1, NULL, NULL, 1, NULL),
(5, 'Jaime', 'Vila López', '34352201S', 'jaime@gmail.com', 'c6865cf98b133f1f3de596a4a2894630', 632521141, '1977-02-25', 'multimedia/images/users/jaime.jpg', 1, NULL, NULL, 1, NULL),
(6, 'Raúl', 'Gil Pérez', '35667134U', 'raul@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(7, 'Alba', 'Torres Quiroga', '53228407H', 'alba@gmail.com', '85e820b214862278ef667ae4bb1d8608', 600912231, '1988-07-17', 'multimedia/images/users/alba.png', 1, NULL, NULL, NULL, 1),
(8, 'Manuel', 'Alvarez Lopez', '34343434A', 'eliminado@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 659863111, '1970-01-30', 'multimedia/images/users/profile.png', 0, 1, NULL, NULL, NULL),
(9, 'Javier', 'Rodeiro Iglesias', '34343434A', 'jrodeiro@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 666666666, '1980-10-28', 'multimedia/images/users/profile.png', 1, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `spaces`
--

INSERT INTO `spaces` (`id_space`, `name`, `capacity`, `image`) VALUES
(1, 'Pista 1', 350, 'multimedia/images/pista1.jpg'),
(2, 'Pista 2', 120, 'multimedia/images/pista2.jpg'),
(3, 'Cafetería', 90, 'multimedia/images/cafeteria.jpg'),
(4, 'Vestuario 1', 20, 'multimedia/images/vestuario.jpg'),
(5, 'Vestuario 2', 15, 'multimedia/images/vestuario2.jpg'),
(6, 'Salón de Actos', 400, 'multimedia/images/salon.jpg'),
(7, 'Oficina 1', 30, 'multimedia/images/oficina.png');

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id_course`, `name`, `type`, `description`, `capacity`, `days`, `start_time`, `end_time`, `id_space`, `id_trainer`, `price`) VALUES
(1, 'Iniciación', 'Children', 'Curso iniciación infantil', 10, 'Monday,Tuesday', '08:00:00', '10:00:00', 1, 2, 30),
(2, 'Iniciación', 'Adults', 'Curso iniciación adultos', 10, 'Wednesday,Thursday', '08:00:00', '10:00:00', 1, 3, 40),
(3, 'Avanzado', 'Children', 'Curso avanzado infantil', 6, 'Friday,Saturday', '10:00:00', '12:00:00', 2, 3, 35);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `courses_reservations`
--

INSERT INTO `courses_reservations` (`id_reservation`, `date`, `time`, `is_confirmed`, `id_pupil`, `id_course`) VALUES
(1, '2018-05-14', '15:00:00', 1, 4, 2),
(2, '2018-05-15', '11:00:00', 1, 5, 2);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id_event`, `name`, `description`, `price`, `capacity`, `date`, `time`, `id_space`) VALUES
(1, 'Conferencia Psicología Deportiva', 'Conferencia \"Psicología Deportiva (Dirigida a Padres y Entrenadores)\" a cargo de D. Carlos Méndez Gil, psicólogo de la Real Federación Española de Tenis.', 10, 400, '2018-06-15', '11:00:00', 6),
(2, 'Cena Navidad', 'Cena navideña para miembros del club y familiares', 20, 89, '2018-06-30', '22:00:00', 3);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `events_reservations`
--

INSERT INTO `events_reservations` (`id_reservation`, `date`, `time`, `is_confirmed`, `id_assistant`, `id_event`) VALUES
(4, '2018-04-25', '11:00:00', 0, 6, 1),
(6, '2018-04-27', '12:00:00', 1, 7, 1);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `tournaments`
--

INSERT INTO `tournaments` (`id_tournament`, `name`, `description`, `start_date`, `end_date`, `price`) VALUES
(NULL, 'I Torneo La Academia', 'I Torneo de Tenis La Academia celebrado en las instalaciones del club.\r\n\r\nModalidades:\r\nMasculino/Femenino individual adultos (+16 años)\r\n\r\nPremios: \r\n1º - Trofeo + 800 euros\r\n2º - Trofeo + 300 euros\r\n\r\nObsequio para todos los participantes', '2016-06-04', '2016-06-15', 20),
(NULL, 'II Torneo La Academia', 'II Torneo de Tenis La Academia celebrado en las instalaciones del club.\r\n\r\nModalidades:\r\nMasculino/Femenino individual adultos (+16 años)\r\n\r\nPremios: \r\n1º - Trofeo + 900 euros\r\n2º - Trofeo + 300 euros\r\n\r\nObsequio para todos los participantes', '2017-06-04', '2017-06-15', 20),
(NULL, 'III Torneo La Academia', 'III Torneo de Tenis La Academia celebrado en las instalaciones del club.\r\n\r\nModalidades:\r\nMasculino/Femenino individual adultos (+16 años)\r\n\r\nPremios: \r\n1º - Trofeo + 1000 euros\r\n2º - Trofeo + 300 euros\r\n\r\nObsequio para todos los participantes', '2018-06-04', '2018-06-15', 20);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `draws`
--

INSERT INTO `draws` (`id_draw`, `modality`, `gender`, `id_tournament`, `category`, `type`) VALUES
(NULL, 'individual', 'male', '1', 'adult', 'regular'),
(NULL, 'individual', 'female', '1', 'adult', 'regular');

COMMIT;
