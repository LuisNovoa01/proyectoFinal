-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-11-2021 a las 18:32:00
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_reservas`
--
CREATE DATABASE IF NOT EXISTS `gestion_reservas` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `gestion_reservas`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_reserva` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `fecha_hora_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `fecha_reserva`, `hora_inicio`, `hora_fin`, `fecha_hora_registro`) VALUES
(3, 2, '2021-11-13', '18:10:00', '18:11:00', '2021-11-12 17:10:25'),
(4, 2, '2021-11-12', '17:51:00', '17:55:00', '2021-11-12 17:13:09'),
(5, 2, '2021-11-11', '19:13:00', '18:14:00', '2021-11-12 17:13:20'),
(6, 2, '2021-11-11', '18:19:00', '18:20:00', '2021-11-12 17:19:21'),
(7, 2, '2021-11-12', '18:28:00', '18:33:00', '2021-11-12 17:30:45'),
(8, 2, '2021-11-13', '18:30:00', '18:35:00', '2021-11-12 17:30:56'),
(9, 3, '2021-11-14', '18:31:00', '18:35:00', '2021-11-12 17:31:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `cookie_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `telefono`, `email`, `password`, `foto`, `cookie_id`) VALUES
(2, 'Juan Miguel', '', 0, 'jmhurtadomontejano@gmail.com', '$2y$10$4CpkXo2DCIn9BlEM/6dh4OM2f7kZJfazD8SLQLeci9oLYIp9kQEbK', 'foto.jpg', 'bed0d05fd15d5c9cf76fc92bf9e9a9bd7e4028fd'),
(3, 'Cristian', '', 0, 'cbeldean@gmail.com', '$2y$10$zaf.UTzsvSYQhFblMUEAcennMQTuCnrxSUUcKy5zzp8GpmdsDhvx6', 'foto.jpg', '10bf5c253290e701d512d59d10e6774d19aac9be');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD PRIMARY KEY (`id_reserva`),
  ADD KEY `Id_usuario_reserva` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservas`
--
ALTER TABLE `reservas`
  ADD CONSTRAINT `Id_usuario_reserva` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
