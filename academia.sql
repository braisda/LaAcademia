-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 27-03-2018 a las 20:01:43
-- Versión del servidor: 10.1.29-MariaDB
-- Versión de PHP: 7.2.0

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

--
-- Estructura de tabla para la tabla `attends`
--

CREATE TABLE `attends` (
  `id_event` int(4) NOT NULL,
  `id_athlete` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `id_course` int(4) NOT NULL,
  `name` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `type` enum('Children','Adults') COLLATE utf8_spanish_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_spanish_ci NOT NULL,
  `capacity` int(4) NOT NULL,
  `days` set('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') COLLATE utf8_spanish_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `id_space` int(4) NOT NULL,
  `id_trainer` int(4) NOT NULL,
  `price` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `courses`
--

INSERT INTO `courses` (`id_course`, `name`, `type`, `description`, `capacity`, `days`, `start_time`, `end_time`, `id_space`, `id_trainer`, `price`) VALUES
(1, 'Iniciación', 'Children', 'Curso iniciación infantil', 10, 'Monday,Tuesday', '08:00:00', '10:00:00', 1, 2, 30),
(2, 'Iniciación', 'Adults', 'Curso iniciación adultos', 10, 'Wednesday,Thursday', '08:00:00', '10:00:00', 1, 3, 40),
(3, 'Avanzado', 'Children', 'Curso avanzado infantil', 6, 'Friday,Saturday', '10:00:00', '12:00:00', 2, 3, 35);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `draws`
--

CREATE TABLE `draws` (
  `id_draw` int(4) NOT NULL,
  `modality` enum('individual','double') COLLATE utf8_spanish_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8_spanish_ci NOT NULL,
  `id_tournament` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `draws`
--

INSERT INTO `draws` (`id_draw`, `modality`, `gender`, `id_tournament`) VALUES
(1, 'individual', 'male', 1),
(2, 'individual', 'female', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id_event` int(1) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  `price` int(4) NOT NULL,
  `capacity` int(4) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `id_space` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id_event`, `name`, `description`, `price`, `capacity`, `date`, `time`, `id_space`) VALUES
(1, 'Conferencia Psicología Deportiva', 'Conferencia \"Psicología Deportiva (Dirigida a Padres y Entrenadores)\" a cargo de D. Carlos Méndez Gil, psicólogo de la Real Federación Española de Tenis.', 10, 400, '2018-06-15', '11:00:00', 6),
(2, 'Cena Navidad', 'Cena navideña para miembros del club y familiares', 20, 89, '2018-06-30', '22:00:00', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inscriptions`
--

CREATE TABLE `inscriptions` (
  `id_inscription` int(5) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `is_confirmed` int(1) NOT NULL,
  `id_player` int(4) NOT NULL,
  `id_tournament` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matches`
--

CREATE TABLE `matches` (
  `id_match` int(6) NOT NULL,
  `rival1a` int(4) NOT NULL,
  `rival1b` int(4) DEFAULT NULL,
  `rival2a` int(4) NOT NULL,
  `rival2b` int(4) DEFAULT NULL,
  `date` date NOT NULL,
  `id_round` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `id_notification` int(4) NOT NULL,
  `title` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `body` text COLLATE utf8_spanish_ci NOT NULL,
  `sender` int(4) NOT NULL,
  `receiver` int(4) NOT NULL,
  `is_read` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `receives`
--

CREATE TABLE `receives` (
  `id_user` int(4) NOT NULL,
  `id_notification` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(5) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `is_confirmed` int(1) NOT NULL,
  `id_pupil` int(4) NOT NULL,
  `id_course` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `results`
--

CREATE TABLE `results` (
  `id_result` int(6) NOT NULL,
  `set1a` int(2) NOT NULL,
  `set1b` int(2) NOT NULL,
  `set2a` int(2) NOT NULL,
  `set2b` int(2) NOT NULL,
  `set3a` int(2) DEFAULT NULL,
  `set3b` int(2) DEFAULT NULL,
  `set4a` int(2) DEFAULT NULL,
  `set4b` int(2) DEFAULT NULL,
  `set5a` int(2) DEFAULT NULL,
  `set5b` int(2) DEFAULT NULL,
  `id_match` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rounds`
--

CREATE TABLE `rounds` (
  `id_round` int(5) NOT NULL,
  `name` enum('champion','third place','final','consolation','semifinal','cuarterfinal','round of 16','round of 32') COLLATE utf8_spanish_ci NOT NULL,
  `id_draw` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `spaces`
--

CREATE TABLE `spaces` (
  `id_space` int(4) NOT NULL,
  `name` varchar(25) COLLATE utf8_spanish_ci NOT NULL,
  `capacity` int(4) NOT NULL,
  `image` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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
-- Estructura de tabla para la tabla `tournaments`
--

CREATE TABLE `tournaments` (
  `id_tournament` int(4) NOT NULL,
  `name` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `tournaments`
--

INSERT INTO `tournaments` (`id_tournament`, `name`, `description`, `start_date`, `end_date`) VALUES
(1, 'I Torneo ESEI', 'I edición del Torneo ESEI para aficionados.\r\n\r\nSe llevará a cabo entre el 17 y 23 de Junio de 2018 en modalidades individual/dobles y masculino/femenino, en las instalaciones del centro de tenis \"La Academia\".\r\n\r\nPlazo de inscripción abierto hasta el 15 de Junio.', '2018-06-17', '2018-06-23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(4) NOT NULL,
  `name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `dni` varchar(9) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `telephone` int(9) NOT NULL,
  `birthdate` date NOT NULL,
  `image` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `is_active` int(1) DEFAULT '1',
  `is_administrator` int(1) DEFAULT NULL,
  `is_trainer` int(1) DEFAULT NULL,
  `is_pupil` int(1) DEFAULT NULL,
  `is_competitor` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

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

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `attends`
--
ALTER TABLE `attends`
  ADD PRIMARY KEY (`id_event`,`id_athlete`),
  ADD KEY `id_athlete` (`id_athlete`);

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id_course`),
  ADD KEY `id_trainer` (`id_trainer`),
  ADD KEY `id_space` (`id_space`);

--
-- Indices de la tabla `draws`
--
ALTER TABLE `draws`
  ADD PRIMARY KEY (`id_draw`),
  ADD KEY `id_tournament` (`id_tournament`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `id_space` (`id_space`);

--
-- Indices de la tabla `inscriptions`
--
ALTER TABLE `inscriptions`
  ADD PRIMARY KEY (`id_inscription`),
  ADD KEY `id_tournament` (`id_tournament`),
  ADD KEY `id_player` (`id_player`);

--
-- Indices de la tabla `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id_match`),
  ADD KEY `id_round` (`id_round`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id_notification`),
  ADD KEY `receiver` (`receiver`),
  ADD KEY `sender` (`sender`);

--
-- Indices de la tabla `rounds`
--
ALTER TABLE `rounds`
  ADD PRIMARY KEY (`id_round`),
  ADD KEY `id_draw` (`id_draw`);

--
-- Indices de la tabla `spaces`
--
ALTER TABLE `spaces`
  ADD PRIMARY KEY (`id_space`);

--
-- Indices de la tabla `tournaments`
--
ALTER TABLE `tournaments`
  ADD PRIMARY KEY (`id_tournament`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `courses`
--
ALTER TABLE `courses`
  MODIFY `id_course` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `draws`
--
ALTER TABLE `draws`
  MODIFY `id_draw` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `matches`
--
ALTER TABLE `matches`
  MODIFY `id_match` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id_notification` int(4) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rounds`
--
ALTER TABLE `rounds`
  MODIFY `id_round` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `spaces`
--
ALTER TABLE `spaces`
  MODIFY `id_space` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tournaments`
--
ALTER TABLE `tournaments`
  MODIFY `id_tournament` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`id_trainer`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`id_space`) REFERENCES `spaces` (`id_space`);

--
-- Filtros para la tabla `draws`
--
ALTER TABLE `draws`
  ADD CONSTRAINT `draws_ibfk_1` FOREIGN KEY (`id_tournament`) REFERENCES `tournaments` (`id_tournament`);

--
-- Filtros para la tabla `matches`
--
ALTER TABLE `matches`
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`id_round`) REFERENCES `rounds` (`id_round`);

--
-- Filtros para la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`receiver`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `users` (`id_user`);

--
-- Filtros para la tabla `rounds`
--
ALTER TABLE `rounds`
  ADD CONSTRAINT `rounds_ibfk_1` FOREIGN KEY (`id_draw`) REFERENCES `draws` (`id_draw`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
