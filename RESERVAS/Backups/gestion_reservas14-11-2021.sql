-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-11-2021 a las 20:05:44
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
(22, 2, '2021-11-14', '09:00:00', '10:00:00', '2021-11-14 18:39:19'),
(23, 2, '2021-11-14', '14:00:00', '15:00:00', '2021-11-14 18:39:29'),
(24, 2, '2021-11-15', '09:00:00', '10:00:00', '2021-11-14 18:58:20');

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
  `cookie_id` varchar(100) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `telefono`, `email`, `password`, `foto`, `cookie_id`, `fecha_registro`) VALUES
(2, 'Juan Miguel', '', 0, 'jmhurtadomontejano@gmail.com', '$2y$10$4CpkXo2DCIn9BlEM/6dh4OM2f7kZJfazD8SLQLeci9oLYIp9kQEbK', 'foto.jpg', '0dc4d7b9ab5d4d9ec7fb7ebdcd879e64fc8fdbe6', '2021-11-14 14:32:18'),
(3, 'Cristian', '', 0, 'cbeldean@gmail.com', '$2y$10$zaf.UTzsvSYQhFblMUEAcennMQTuCnrxSUUcKy5zzp8GpmdsDhvx6', 'foto.jpg', '10bf5c253290e701d512d59d10e6774d19aac9be', '2021-11-14 14:32:18'),
(4, 'Claudia', 'Ojeda', 0, 'cojeda@gmail.com', '$2y$10$tODqCppWTEXQiSWeXSgHJugP60jlZ.bbYUu4McuYzNX4iqK81e29W', 'foto.jpg', 'c5850155c7ddd1843841531ca1d38f70d129d802', '2021-11-14 14:46:34'),
(5, 'rita', 'montejano', 0, 'rmontejano@gmail.com', '$2y$10$srqWsv/BlYpfJNp//taqOOuenAerIZ5a7J99G1OZLM96gru0xJlD2', 'foto.jpg', '021af9ca0cef99fbaab478efa377399f94a1a073', '2021-11-14 16:21:08'),
(6, 'Paco', 'asas', 343434343, 'paco@gmail.com', '$2y$10$m8HgZN4zW3y/UXm8xSsNHeg.4V7qqYBdQZ.GVpzAmAtK8lO42NXM2', 'foto.jpg', '8a8b4d97c531bce9b40e7ae020653f99f5361610', '2021-11-14 16:23:21'),
(7, 'Manolo', 'ruiz', 34343434, 'manolo@gmail.com', '$2y$10$wCVARnTBYHOlFk4lE2ldR.s9N1YMJAYLbQnzwq/ucQsLqjmeEJ1uG', 'foto.jpg', '2714917b76b394b5228357a2786fbee0652e6d63', '2021-11-14 16:25:22'),
(8, 'Trini', 'Hurtado', 2147483647, 'trini@gmail.com', '$2y$10$ZjLXptdvya7WtloOBL/wYemJhHI3K6lkbu8ZWYrujj8imduQZrn9a', 'foto.jpg', '886a376ec0fb687e2e363b50fd9dfee2d7882210', '2021-11-14 16:29:54'),
(9, 'Carola', 'Mañas', 12121212, 'carola@gmail.com', '$2y$10$Ori.Q5YoxhpS299uD9.RLOGDJwBzaLHBHfJ.ZvPMLCXrsoruKONbK', 'foto.jpg', '0a8a63ddefca7df98bef2b819ee00d30c0da4a12', '2021-11-14 16:39:05');

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
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
