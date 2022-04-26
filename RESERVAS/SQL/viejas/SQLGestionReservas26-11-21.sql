-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 26-11-2021 a las 18:35:38
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
-- Estructura de tabla para la tabla `instalaciones`
--

CREATE TABLE `instalaciones` (
  `id_instalacion` int(11) NOT NULL,
  `nombre_instalacion` varchar(50) NOT NULL,
  `descripcion_instalacion` varchar(500) NOT NULL,
  `precio_hora_instalacion` int(11) NOT NULL,
  `foto_instalacion` varchar(200) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `instalaciones`
--

INSERT INTO `instalaciones` (`id_instalacion`, `nombre_instalacion`, `descripcion_instalacion`, `precio_hora_instalacion`, `foto_instalacion`, `fecha_registro`) VALUES
(1, 'pista Padel 1', 'pues es una pista bien acondicionada, con paredes de metraquilato...', 25, '', '2021-11-19 10:15:45'),
(2, 'Pista Padel 2', 'Es una pista mas pequeña, con paredes de reja...', 15, '', '2021-11-19 10:15:45'),
(3, 'pista Padel 3', 'Es la peor pista de todas. las paredes son de cemento y no tiene luz.', 10, '', '2021-11-19 16:07:06'),
(4, 'Pista Padel 4', 'Descripcion Pista padel 4', 8, '', '2021-11-19 19:59:00'),
(5, 'Pista Padel 5', 'descripcion Pista 5', 6, '', '2021-11-19 20:01:07'),
(6, 'Pista 6', 'Descripcion Pista 6', 2, '', '2021-11-26 17:36:54');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservas`
--

CREATE TABLE `reservas` (
  `id_reserva` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_instalacion` int(11) NOT NULL,
  `fecha_reserva` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `fecha_hora_registro` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reservas`
--

INSERT INTO `reservas` (`id_reserva`, `id_usuario`, `id_instalacion`, `fecha_reserva`, `hora_inicio`, `hora_fin`, `fecha_hora_registro`) VALUES
(22, 2, 3, '2021-11-14', '09:00:00', '10:00:00', '2021-11-19 18:13:27'),
(23, 2, 1, '2021-11-14', '14:00:00', '15:00:00', '2021-11-19 11:41:21'),
(24, 2, 1, '2021-11-15', '09:00:00', '10:00:00', '2021-11-19 11:41:21'),
(25, 9, 1, '2021-11-15', '11:00:00', '12:00:00', '2021-11-19 11:41:21'),
(27, 2, 1, '2021-11-15', '13:00:00', '14:00:00', '2021-11-19 11:41:21'),
(29, 2, 1, '2021-11-15', '14:00:00', '15:00:00', '2021-11-19 11:41:21'),
(30, 2, 1, '2021-11-15', '15:00:00', '16:00:00', '2021-11-19 11:41:21'),
(31, 2, 2, '2021-11-16', '11:00:00', '12:00:00', '2021-11-19 11:41:40'),
(32, 2, 1, '2021-11-16', '14:00:00', '15:00:00', '2021-11-19 11:41:21'),
(33, 2, 1, '2021-11-16', '09:00:00', '10:00:00', '2021-11-19 11:41:21'),
(34, 4, 1, '2021-11-15', '12:00:00', '13:00:00', '2021-11-19 11:41:21'),
(35, 4, 1, '2021-11-16', '12:00:00', '13:00:00', '2021-11-19 11:41:21'),
(36, 4, 1, '2021-11-17', '09:00:00', '10:00:00', '2021-11-19 11:41:21'),
(37, 9, 1, '2021-11-16', '10:00:00', '11:00:00', '2021-11-19 11:41:21'),
(40, 10, 1, '2021-11-17', '15:00:00', '16:00:00', '2021-11-19 11:41:21'),
(41, 10, 1, '2021-11-15', '10:00:00', '11:00:00', '2021-11-19 11:41:21'),
(44, 2, 1, '2021-11-19', '13:00:00', '14:00:00', '2021-11-19 11:41:21'),
(45, 2, 1, '2021-11-20', '12:00:00', '13:00:00', '2021-11-19 11:41:21'),
(46, 11, 1, '2021-11-26', '12:00:00', '13:00:00', '2021-11-19 11:41:21'),
(47, 2, 2, '2021-11-20', '13:00:00', '14:00:00', '2021-11-19 11:41:21'),
(48, 2, 2, '2021-11-19', '09:00:00', '10:00:00', '2021-11-19 18:46:42'),
(49, 2, 3, '2021-11-19', '15:00:00', '16:00:00', '2021-11-19 18:46:56'),
(50, 2, 4, '2021-11-19', '10:00:00', '11:00:00', '2021-11-19 18:59:12'),
(51, 2, 5, '2021-11-19', '15:00:00', '16:00:00', '2021-11-19 19:12:38'),
(52, 4, 4, '2021-11-19', '12:00:00', '13:00:00', '2021-11-19 19:17:29'),
(53, 4, 2, '2021-11-20', '10:00:00', '11:00:00', '2021-11-19 19:17:40'),
(54, 2, 2, '2021-11-19', '12:00:00', '13:00:00', '2021-11-19 19:51:10'),
(55, 2, 2, '2021-11-19', '10:00:00', '11:00:00', '2021-11-19 19:51:21'),
(56, 2, 1, '2021-11-21', '12:00:00', '13:00:00', '2021-11-19 20:11:02'),
(57, 2, 1, '2021-11-19', '09:00:00', '10:00:00', '2021-11-19 21:28:07'),
(58, 2, 5, '2021-11-20', '12:00:00', '13:00:00', '2021-11-20 10:53:08'),
(59, 2, 1, '2021-11-20', '09:00:00', '10:00:00', '2021-11-20 11:05:24'),
(60, 2, 0, '2021-11-20', '10:00:00', '11:00:00', '2021-11-20 11:06:36'),
(61, 2, 0, '2021-11-20', '09:00:00', '10:00:00', '2021-11-20 11:06:47'),
(62, 2, 0, '2021-11-20', '10:00:00', '11:00:00', '2021-11-20 11:09:14'),
(63, 2, 0, '2021-11-20', '10:00:00', '11:00:00', '2021-11-20 11:09:22'),
(64, 2, 0, '2021-11-21', '14:00:00', '15:00:00', '2021-11-20 11:36:32'),
(65, 2, 0, '2021-11-21', '09:00:00', '10:00:00', '2021-11-20 11:36:42'),
(66, 2, 0, '2021-11-21', '09:00:00', '10:00:00', '2021-11-20 11:37:20'),
(67, 2, 0, '2021-11-21', '09:00:00', '10:00:00', '2021-11-20 11:38:02'),
(68, 2, 0, '2021-11-21', '09:00:00', '10:00:00', '2021-11-20 11:38:25'),
(69, 2, 0, '2021-11-21', '09:00:00', '10:00:00', '2021-11-20 11:39:20'),
(70, 2, 2, '2021-11-21', '09:00:00', '10:00:00', '2021-11-20 11:39:24'),
(71, 2, 2, '2021-11-21', '09:00:00', '10:00:00', '2021-11-20 11:39:26'),
(72, 2, 2, '2021-11-21', '09:00:00', '10:00:00', '2021-11-20 11:39:27'),
(73, 2, 2, '2021-11-21', '10:00:00', '11:00:00', '2021-11-20 11:39:45'),
(74, 2, 2, '2021-11-21', '10:00:00', '11:00:00', '2021-11-20 11:40:04'),
(75, 2, 2, '2021-11-21', '10:00:00', '11:00:00', '2021-11-20 11:40:05'),
(76, 2, 2, '2021-11-21', '10:00:00', '11:00:00', '2021-11-20 11:40:24'),
(77, 2, 2, '2021-11-21', '10:00:00', '11:00:00', '2021-11-20 11:40:28'),
(78, 2, 2, '2021-11-21', '10:00:00', '11:00:00', '2021-11-20 11:40:29'),
(79, 2, 2, '2021-11-21', '11:00:00', '12:00:00', '2021-11-20 11:40:42'),
(80, 2, 2, '2021-11-21', '12:00:00', '13:00:00', '2021-11-20 11:54:08'),
(81, 2, 3, '2021-11-21', '10:00:00', '11:00:00', '2021-11-20 11:54:23'),
(82, 2, 2, '2021-11-26', '13:00:00', '14:00:00', '2021-11-26 14:01:53'),
(83, 3, 1, '2021-11-27', '10:00:00', '11:00:00', '2021-11-26 16:35:35'),
(84, 3, 2, '2021-11-28', '13:00:00', '14:00:00', '2021-11-26 16:35:41'),
(87, 2, 1, '2021-11-29', '10:00:00', '11:00:00', '2021-11-26 17:27:32'),
(88, 2, 2, '2021-11-29', '12:00:00', '13:00:00', '2021-11-26 17:34:51');

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
  `privilegios` varchar(200) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `telefono`, `email`, `password`, `foto`, `cookie_id`, `privilegios`, `fecha_registro`) VALUES
(2, 'Juan Miguel', '', 0, 'jmhurtadomontejano@gmail.com', '$2y$10$4CpkXo2DCIn9BlEM/6dh4OM2f7kZJfazD8SLQLeci9oLYIp9kQEbK', 'Juanmi.jpg', '192b0265663920fd847e215ea91382daf43efa40', 'admin', '2021-11-14 14:32:18'),
(3, 'Cristian', '', 0, 'cbeldean@gmail.com', '$2y$10$zaf.UTzsvSYQhFblMUEAcennMQTuCnrxSUUcKy5zzp8GpmdsDhvx6', 'foto.jpg', 'eb8ca454f457f546b3a82ae239846a8f52bcdc8f', '', '2021-11-14 14:32:18'),
(4, 'Claudia', 'Ojeda', 0, 'cojeda@gmail.com', '$2y$10$tODqCppWTEXQiSWeXSgHJugP60jlZ.bbYUu4McuYzNX4iqK81e29W', 'foto.jpg', 'ad83f746cbea8d0561810857542e82e3d92d940f', '', '2021-11-14 14:46:34'),
(5, 'rita', 'montejano', 0, 'rmontejano@gmail.com', '$2y$10$srqWsv/BlYpfJNp//taqOOuenAerIZ5a7J99G1OZLM96gru0xJlD2', 'foto.jpg', '021af9ca0cef99fbaab478efa377399f94a1a073', '', '2021-11-14 16:21:08'),
(6, 'Paco', 'asas', 343434343, 'paco@gmail.com', '$2y$10$m8HgZN4zW3y/UXm8xSsNHeg.4V7qqYBdQZ.GVpzAmAtK8lO42NXM2', 'foto.jpg', '8a8b4d97c531bce9b40e7ae020653f99f5361610', '', '2021-11-14 16:23:21'),
(7, 'Manolo', 'ruiz', 34343434, 'manolo@gmail.com', '$2y$10$wCVARnTBYHOlFk4lE2ldR.s9N1YMJAYLbQnzwq/ucQsLqjmeEJ1uG', 'foto.jpg', '2714917b76b394b5228357a2786fbee0652e6d63', '', '2021-11-14 16:25:22'),
(8, 'Trini', 'Hurtado', 2147483647, 'trini@gmail.com', '$2y$10$ZjLXptdvya7WtloOBL/wYemJhHI3K6lkbu8ZWYrujj8imduQZrn9a', 'foto.jpg', '886a376ec0fb687e2e363b50fd9dfee2d7882210', '', '2021-11-14 16:29:54'),
(9, 'Carola', 'Mañas', 12121212, 'carola@gmail.com', '$2y$10$Ori.Q5YoxhpS299uD9.RLOGDJwBzaLHBHfJ.ZvPMLCXrsoruKONbK', 'foto.jpg', '089a51eef333039f22b3554c1992acb7c6d2d33e', '', '2021-11-14 16:39:05'),
(10, 'Luisa', 'Hurtado', 656565656, 'luisa@gmail.com', '$2y$10$pffbBs02x3BcMuMJXj2hPelhkJpFMCjfOxg3T/ZWAJUCRTv1GF2Kq', 'foto.jpg', '9e62511b2af33b4a79b3f874f997520a1d8bfe51', '', '2021-11-15 09:49:01'),
(11, 'Monica', 'Noviembre', 34343434, 'monica@gmail.com', '$2y$10$XRQz8AO0y.KrNWpNYIXNAuvNEMd6YJT0tqtXKugPPFSTFyLgcLrcm', '', '541b5e37e7735f4548a8d7d9d434adaa752b560c', '', '2021-11-19 11:13:36'),
(12, 'Juan Miguel', 'Montejano', 649564806, 'jmhurtadomontejano2@gmail.com', '$2y$10$tkGBzv4fbXgz1QeRxn9h.OzC78Kfm4Md2faUm0URHqHCT2PEr1Jmy', '220f7b8d1191c448e4410b5ffb107b84.PNG', '5e775dc916c7d06594f4e2f0810ffad19f866d61', '', '2021-11-26 16:17:46'),
(13, 'Evelyn', 'Cutillas', 68989895, 'evalyn@gmail.com', '$2y$10$aNkY1kTMUMZrs8qNGA87LeCwfBBCVo3046Nj/9I3JNzvwVBJoMwwS', '2473a5a45a9ffee8df7507f64077f448.PNG', '01f6fdde2c1a391d5aa4c60080c8540435229b51', '', '2021-11-26 16:26:42'),
(14, 'Alberto', 'asasas', 6586865, 'alberto@gmail.com', '$2y$10$IetouFyfflR3cIhDev/JO.G8vj.eqkpSTISvqfFAsUAd8TgwNbG6y', 'd6611884d89b83540f835dbbdb92f95f.PNG', '35290e9d945bc398bba56e7c5ea8afdc70db04bc', '', '2021-11-26 16:27:48'),
(15, 'Cris', 'sdsd', 656565, 'cris@gmail.com', '$2y$10$3GSOzExgJOLDpT7IQNSDQuREz/Xt014QoZMK421RJn6QKAbKZOdea', '5fff1a473e8ed1b78e59ea77d068cf88.PNG', '0b8da55b3ebc671c96e46351d82736dc95f420f8', '', '2021-11-26 16:55:32');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `instalaciones`
--
ALTER TABLE `instalaciones`
  ADD PRIMARY KEY (`id_instalacion`);

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
-- AUTO_INCREMENT de la tabla `instalaciones`
--
ALTER TABLE `instalaciones`
  MODIFY `id_instalacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `reservas`
--
ALTER TABLE `reservas`
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
