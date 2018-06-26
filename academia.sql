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
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `start_time` TIME NOT NULL,
  `end_time` TIME NOT NULL,
  `id_space` INT NULL,
  `id_trainer` INT NULL,
  `price` INT NOT NULL,
  INDEX `fk_courses_users_idx` (`id_trainer` ASC),
  PRIMARY KEY (`id_course`),
  INDEX `fk_courses_spaces1_idx` (`id_space` ASC),
  CONSTRAINT `fk_courses_users`
    FOREIGN KEY (`id_trainer`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_courses_spaces1`
    FOREIGN KEY (`id_space`)
    REFERENCES `academia`.`spaces` (`id_space`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`courses_reservations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`courses_reservations` (
  `id_reservation` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `is_confirmed` INT NOT NULL,
  `id_pupil` INT NULL,
  `id_course` INT NULL,
  PRIMARY KEY (`id_reservation`),
  INDEX `fk_courses_reservations_users1_idx` (`id_pupil` ASC),
  INDEX `fk_courses_reservations_courses1_idx` (`id_course` ASC),
  CONSTRAINT `fk_courses_reservations_users1`
    FOREIGN KEY (`id_pupil`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_courses_reservations_courses1`
    FOREIGN KEY (`id_course`)
    REFERENCES `academia`.`courses` (`id_course`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
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
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`events_reservations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`events_reservations` (
  `id_reservation` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `is_confirmed` VARCHAR(45) NOT NULL,
  `id_event` INT NULL,
  `id_assistant` INT NULL,
  PRIMARY KEY (`id_reservation`),
  INDEX `fk_events_reservations_events1_idx` (`id_event` ASC),
  INDEX `fk_events_reservations_users1_idx` (`id_assistant` ASC),
  CONSTRAINT `fk_events_reservations_events1`
    FOREIGN KEY (`id_event`)
    REFERENCES `academia`.`events` (`id_event`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_events_reservations_users1`
    FOREIGN KEY (`id_assistant`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
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
-- Table `academia`.`draws`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`draws` (
  `id_draw` INT NOT NULL AUTO_INCREMENT,
  `modality` ENUM('individual', 'double') NOT NULL,
  `gender` ENUM('male', 'female') NOT NULL,
  `category` ENUM('children', 'adult', 'veteran') NOT NULL,
  `type` ENUM('regular', 'consolation') NOT NULL,
  `id_tournament` INT NULL,
  PRIMARY KEY (`id_draw`),
  INDEX `fk_draws_tournaments1_idx` (`id_tournament` ASC),
  CONSTRAINT `fk_draws_tournaments1`
    FOREIGN KEY (`id_tournament`)
    REFERENCES `academia`.`tournaments` (`id_tournament`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`tournaments_reservations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`tournaments_reservations` (
  `id_reservation` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `is_confirmed` INT NOT NULL,
  `id_tournament` INT NULL,
  `id_player` INT NULL,
  `id_draw` INT NULL,
  PRIMARY KEY (`id_reservation`),
  INDEX `fk_tournaments_reservations_tournaments1_idx` (`id_tournament` ASC),
  INDEX `fk_tournaments_reservations_users1_idx` (`id_player` ASC),
  INDEX `fk_tournaments_reservations_draws1_idx` (`id_draw` ASC),
  CONSTRAINT `fk_tournaments_reservations_tournaments1`
    FOREIGN KEY (`id_tournament`)
    REFERENCES `academia`.`tournaments` (`id_tournament`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tournaments_reservations_users1`
    FOREIGN KEY (`id_player`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_tournaments_reservations_draws1`
    FOREIGN KEY (`id_draw`)
    REFERENCES `academia`.`draws` (`id_draw`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`matches`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`matches` (
  `id_match` INT NOT NULL AUTO_INCREMENT,
  `rival1a` INT NULL,
  `rival1b` INT NULL,
  `rival2a` INT NULL,
  `rival2b` INT NULL,
  `date` DATE NOT NULL,
  `time` TIME NULL,
  `round` ENUM('champion', 'thirdplace', 'final', 'consolation', 'semifinal', 'cuarterfinal', 'roundof16', 'roundof32') NOT NULL,
  `cell` VARCHAR(45) NOT NULL,
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
  `id_draw` INT NULL,
  `id_space` INT NULL,
  PRIMARY KEY (`id_match`),
  INDEX `fk_matches_draws1_idx` (`id_draw` ASC),
  INDEX `fk_matches_spaces1_idx` (`id_space` ASC),
  CONSTRAINT `fk_matches_draws1`
    FOREIGN KEY (`id_draw`)
    REFERENCES `academia`.`draws` (`id_draw`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_matches_spaces1`
    FOREIGN KEY (`id_space`)
    REFERENCES `academia`.`spaces` (`id_space`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `academia`.`notifications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `academia`.`notifications` (
  `id_notification` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(30) NOT NULL,
  `body` TEXT NULL,
  `date` DATE NOT NULL,
  `time` TIME NOT NULL,
  `is_read` INT NOT NULL,
  `sender` INT NULL,
  `receiver` INT NULL,
  PRIMARY KEY (`id_notification`),
  INDEX `fk_received_notifications_users1_idx` (`sender` ASC),
  INDEX `fk_received_notifications_users2_idx` (`receiver` ASC),
  CONSTRAINT `fk_received_notifications_users1`
    FOREIGN KEY (`sender`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_received_notifications_users2`
    FOREIGN KEY (`receiver`)
    REFERENCES `academia`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `name`, `surname`, `dni`, `email`, `password`, `telephone`, `birthdate`, `image`, `is_active`, `is_administrator`, `is_trainer`, `is_pupil`, `is_competitor`) VALUES
(NULL, 'Brais', 'Domínguez Álvarez', '34273074S', 'braisda@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 662485513, '1991-06-10', 'multimedia/images/users/Foto Perfil2.PNG', 1, 1, NULL, NULL, NULL),
(NULL, 'Francisco', 'Expósito Martínez', '66892653M', 'panocadas@gmail.com', 'a990ba8861d2b344810851e7e6b49104', 666555444, '1984-02-06', 'multimedia/images/users/francisco.jpg', 1, NULL, 1, NULL, NULL),
(NULL, 'Fátima', 'Rodríguez Souto', '44083137A', 'fatima@gmail.com', 'a990ba8861d2b344810851e7e6b49104', 698659991, '2000-12-13', 'multimedia/images/users/fatima.jpg', 1, NULL, 1, NULL, NULL),
(NULL, 'Laura', 'Méndez Ferreiro', '37723942D', 'laura@gmail.com', 'c6865cf98b133f1f3de596a4a2894630', 699422322, '1996-09-15', 'multimedia/images/users/laura.jpg', 1, NULL, NULL, 1, NULL),
(NULL, 'Jaime', 'Vila López', '53319547G', 'jaime@gmail.com', 'c6865cf98b133f1f3de596a4a2894630', 632521141, '1977-02-25', 'multimedia/images/users/jaime.jpg', 1, NULL, NULL, 1, NULL),
(NULL, 'Raúl', 'Gil Pérez', '52301077C', 'raul@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Alba', 'Torres Quiroga', '90600220T', 'alba@gmail.com', '85e820b214862278ef667ae4bb1d8608', 600912231, '1988-07-17', 'multimedia/images/users/alba.png', 1, NULL, NULL, NULL, 1),
(NULL, 'Marcos', 'Villa López', '29576885N', 'marcos@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Abel', 'Piñeiro Vila', '69670767H', 'abel@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Mateo', 'Torres Pérez', '57061875W', 'mateo@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Zeus', 'Rajoy Jato', '15242725G', 'zeus@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Petete', 'Moreno Domínguez', '34038784A', 'petete@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Ulises', 'Feijoo Martínez', '82511304T', 'ulises@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Carlos', 'Pernía Pérez', '08976280R', 'carlos@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Gabino', 'Llorente Mata', '52784680W', 'gabino@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Juan', 'Domínguez Alonso', '06378301X', 'juan@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Bartolo', 'Navas Nos', '08573032N', 'bartolo@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Gabriel', 'Cobo Souto', '31624639F', 'gabriel@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Anxo', 'Quiroga Iglesias', '10896329X', 'anxo@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Galindo', 'Casado Vega', '62210701W', 'galindo@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Saúl', 'Gallego Pérez', '33469779H', 'saul@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Ángel', 'Blanco Gutiérrez', '79750696J', 'angel@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Paco', 'Reina Domínguez', '01420697X', 'paco@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Matín', 'Villa Casillas', '32945070P', 'martin@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Epi', 'Sánchez Borbón', '62040921P', 'epi@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Mauro', 'Castañer Dafonte', '76635464Q', 'mauro@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Gumersindo', 'Peixoto Pérez', '98011697A', 'gumersindo@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Artemio', 'Sotelo Cortés', '29624603M', 'artemio@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Manuel', 'Peña Moreno', '20652110L', 'manuel@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Ricardo', 'Veiga Pérez', '10680490A', 'ricardo@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Nicanor', 'Álvarez Casas', '91488287Z', 'nicanor@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Telmo', 'Hernández Pérez', '98723272G', 'telmo@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Iker', 'Banderas Iglesias', '44059127M', 'iker@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'David', 'López López', '86430841S', 'david@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Victor', 'Muñoz Vázquez', '09257688G', 'victor@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Andrés', 'Fernández Pérez', '55899604J', 'andres@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Fernando', 'Gil Domínguez', '51543163W', 'fer@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Sergio', 'Verao Valdés', '50037266F', 'sergio@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Unay', 'Quiroga Verne', '82817568L', 'unay@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Pablo', 'Lemos Quijote', '42674299F', 'pablo@gmail.com', '85e820b214862278ef667ae4bb1d8608', 676543334, '1981-05-28', 'multimedia/images/users/raul.jpg', 1, NULL, NULL, NULL, 1),
(NULL, 'Manuel', 'Alvarez Lopez', '02769362R', 'eliminado@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 659863111, '1970-01-30', 'multimedia/images/users/profile.png', 0, 1, NULL, NULL, NULL),
(NULL, 'Javier', 'Rodeiro Iglesias', '15197362C', 'jrodeiro@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 666666666, '1980-10-28', 'multimedia/images/users/profile.png', 1, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `spaces`
--

INSERT INTO `spaces` (`id_space`, `name`, `capacity`, `image`) VALUES
(1, 'Pista A', 350, 'multimedia/images/pista1.jpg'),
(2, 'Pista B', 120, 'multimedia/images/pista2.jpg'),
(3, 'Cafetería', 90, 'multimedia/images/cafeteria.jpg'),
(4, 'Vestuario A', 20, 'multimedia/images/vestuario.jpg'),
(5, 'Vestuario B', 15, 'multimedia/images/vestuario2.jpg'),
(6, 'Salón de Actos', 400, 'multimedia/images/salon.jpg'),
(7, 'Oficina A', 30, 'multimedia/images/oficina.png');

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id_course`, `name`, `type`, `description`, `capacity`, `days`, `start_date`, `end_date`, `start_time`, `end_time`, `id_space`, `id_trainer`, `price`) VALUES
(1, 'Iniciación', 'Children', 'Curso iniciación infantil', 10, 'Monday,Tuesday', '2017-09-14', '2018-06-14', '08:00:00', '10:00:00', 1, 2, 30),
(2, 'Iniciación', 'Adults', 'Curso iniciación adultos', 10, 'Wednesday,Thursday', '2017-09-14', '2018-06-14',  '08:00:00', '10:00:00', 1, 3, 40),
(3, 'Avanzado', 'Children', 'Curso avanzado infantil', 6, 'Friday,Saturday', '2017-09-14', '2018-06-14',  '10:00:00', '12:00:00', 2, 3, 35);

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
(NULL, 'I Torneo de Verano', 'I Torneo de Tenis La Academia celebrado en las instalaciones del club.\r\n\r\nModalidades:\r\nMasculino/Femenino individual adultos (+16 años)\r\n\r\nPremios: \r\n1º - Trofeo + 800 euros\r\n2º - Trofeo + 300 euros\r\n\r\nObsequio para todos los participantes', '2016-06-04', '2016-06-15', 20),
(NULL, 'II Torneo de Verano', 'II Torneo de Tenis La Academia celebrado en las instalaciones del club.\r\n\r\nModalidades:\r\nMasculino/Femenino individual adultos (+16 años)\r\n\r\nPremios: \r\n1º - Trofeo + 900 euros\r\n2º - Trofeo + 300 euros\r\n\r\nObsequio para todos los participantes', '2017-06-04', '2017-06-15', 20),
(NULL, 'III Torneo de Verano', 'III Torneo de Tenis La Academia celebrado en las instalaciones del club.\r\n\r\nModalidades:\r\nMasculino/Femenino individual adultos (+16 años)\r\n\r\nPremios: \r\n1º - Trofeo + 1000 euros\r\n2º - Trofeo + 300 euros\r\n\r\nObsequio para todos los participantes', '2018-06-04', '2018-06-15', 20);

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `draws`
--

INSERT INTO `draws` (`id_draw`, `modality`, `gender`, `id_tournament`, `category`, `type`) VALUES
(NULL, 'individual', 'male', '1', 'adult', 'regular'),
(NULL, 'individual', 'female', '1', 'adult', 'regular');

-- --------------------------------------------------------

--
-- Volcado de datos para la tabla `matches`
--

INSERT INTO `matches` (`id_match`, `rival1a`, `rival1b`, `rival2a`, `rival2b`, `date`, `time`, `round`, `cell`, `set1a`, `set1b`, `set2a`, `set2b`, `set3a`, `set3b`, `set4a`, `set4b`, `set5a`, `set5b`, `id_draw`, `id_space`) VALUES
(NULL, 6, NULL, 10, NULL, '2018-05-13', '08:00:00', 'roundof32', '0,0', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 11, NULL, 12, NULL, '2018-05-13', '10:00:00', 'roundof32', '0,2', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 13, NULL, 14, NULL, '2018-05-13', '12:00:00', 'roundof32', '0,4', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 15, NULL, 16, NULL, '2018-05-13', '14:00:00', 'roundof32', '0,6', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 17, NULL, 18, NULL, '2018-05-13', '16:00:00', 'roundof32', '0,8', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 19, NULL, 20, NULL, '2018-05-13', '18:00:00', 'roundof32', '0,10', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 21, NULL, 22, NULL, '2018-05-13', '20:00:00', 'roundof32', '0,12', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 23, NULL, 24, NULL, '2018-05-13', '22:00:00', 'roundof32', '0,14', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 25, NULL, 26, NULL, '2018-05-13', '08:00:00', 'roundof32', '0,16', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(NULL, 27, NULL, 28, NULL, '2018-05-13', '10:00:00', 'roundof32', '0,18', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(NULL, 29, NULL, 30, NULL, '2018-05-13', '12:00:00', 'roundof32', '0,20', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(NULL, 31, NULL, 32, NULL, '2018-05-13', '14:00:00', 'roundof32', '0,22', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(NULL, 33, NULL, 34, NULL, '2018-05-13', '16:00:00', 'roundof32', '0,24', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(NULL, 35, NULL, 36, NULL, '2018-05-13', '18:00:00', 'roundof32', '0,26', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(NULL, 37, NULL, 38, NULL, '2018-05-13', '20:00:00', 'roundof32', '0,28', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(NULL, 39, NULL, 40, NULL, '2018-05-13', '22:00:00', 'roundof32', '0,30', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 2),
(NULL, 6, NULL, 11, NULL, '2018-05-14', '08:00:00', 'roundof16', '1,1', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 13, NULL, 15, NULL, '2018-05-14', '10:00:00', 'roundof16', '1,5', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 17, NULL, 19, NULL, '2018-05-14', '12:00:00', 'roundof16', '1,9', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 21, NULL, 23, NULL, '2018-05-14', '14:00:00', 'roundof16', '1,13', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 25, NULL, 27, NULL, '2018-05-14', '16:00:00', 'roundof16', '1,17', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 29, NULL, 31, NULL, '2018-05-14', '18:00:00', 'roundof16', '1,21', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 33, NULL, 35, NULL, '2018-05-14', '20:00:00', 'roundof16', '1,25', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 37, NULL, 39, NULL, '2018-05-14', '22:00:00', 'roundof16', '1,29', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 6, NULL, 13, NULL, '2018-05-15', '10:00:00', 'cuarterfinal', '2,3', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 17, NULL, 21, NULL, '2018-05-15', '12:00:00', 'cuarterfinal', '2,11', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 25, NULL, 29, NULL, '2018-05-15', '14:00:00', 'cuarterfinal', '2,19', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 33, NULL, 37, NULL, '2018-05-15', '16:00:00', 'cuarterfinal', '2,27', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 6, NULL, 17, NULL, '2018-05-16', '16:00:00', 'semifinal', '3,7', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 25, NULL, 33, NULL, '2018-05-16', '16:00:00', 'semifinal', '3,23', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 6, NULL, 25, NULL, '2018-05-17', '20:00:00', 'final', '4,15', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 17, NULL, 33, NULL, '2018-05-17', '18:00:00', 'consolation', '4,17', 6, 0, 6, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 6, NULL, 0, NULL, '2018-05-17', '10:00:00', 'champion', '5,15', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1),
(NULL, 17, NULL, 0, NULL, '2018-05-17', '10:00:00', 'thirdplace', '5,17', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1);


--
-- Volcado de datos para la tabla `notifications`
--

INSERT INTO `notifications` (`id_notification`, `title`, `body`, `date`, `time`, `is_read`, `sender`, `receiver`) VALUES
(NULL, 'Planificación Julio', 'Buenos días, la semana que viene me gustaría presentar el informe con la planificación del mes de Julio, ¿Sería posible? Un saludo', '2018-06-01', '08:00:00', 1, 3, 1),
(NULL, 'Baja asistencia de mañana', 'Hola, las últimas semanas está bajando la asistencia a los cursos con horario de mañana, deberíamos revisar la situación', '2018-06-02', '10:00:00', 1, 3, 1),
(NULL, 'Baños sucios', 'Los baños estaban muy sucios ayer y daban asco, exijo la hoja de reclamaciones', '2018-06-03', '18:00:00', 0, 4, 1),
(NULL, 'Este mes no pago', 'Este mes voy justo de dinero, os pago el mes que viene los dos juntos, gracias', '2018-06-04', '18:00:00', 0, 4, 1),
(NULL, 'Información cursos', 'Me gustaría apuntarme a algún curso, puedes enviarme información sobre alguno que me pueda interesar?', '2018-06-05', '18:00:00', 0, 6, 1),
(NULL, 'Planificación Julio', 'Perfecto, el martes de la semana que viene lo miramos al acabar la jornada, saludos', '2018-06-02', '12:00:00', 0, 1, 3);

COMMIT;
