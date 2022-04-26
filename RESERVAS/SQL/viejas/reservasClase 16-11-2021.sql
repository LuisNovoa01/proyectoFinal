-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-11-2021 a las 17:53:58
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
(24, 2, '2021-11-15', '09:00:00', '10:00:00', '2021-11-14 18:58:20'),
(25, 9, '2021-11-15', '11:00:00', '12:00:00', '2021-11-14 19:08:45'),
(27, 2, '2021-11-15', '13:00:00', '14:00:00', '2021-11-14 19:50:04'),
(29, 2, '2021-11-15', '14:00:00', '15:00:00', '2021-11-14 19:52:55'),
(30, 2, '2021-11-15', '15:00:00', '16:00:00', '2021-11-14 19:53:01'),
(31, 2, '2021-11-16', '11:00:00', '12:00:00', '2021-11-14 19:53:49'),
(32, 2, '2021-11-16', '14:00:00', '15:00:00', '2021-11-14 19:54:30'),
(33, 2, '2021-11-16', '09:00:00', '10:00:00', '2021-11-14 19:55:50'),
(34, 4, '2021-11-15', '12:00:00', '13:00:00', '2021-11-14 19:56:33'),
(35, 4, '2021-11-16', '12:00:00', '13:00:00', '2021-11-14 19:58:32'),
(36, 4, '2021-11-17', '09:00:00', '10:00:00', '2021-11-14 20:23:10'),
(37, 9, '2021-11-16', '10:00:00', '11:00:00', '2021-11-14 20:37:51'),
(40, 10, '2021-11-17', '15:00:00', '16:00:00', '2021-11-15 10:29:01'),
(41, 10, '2021-11-15', '10:00:00', '11:00:00', '2021-11-15 10:58:09'),
(46, 10, '2021-11-17', '14:00:00', '15:00:00', '2021-11-16 15:48:41'),
(48, 11, '2021-11-18', '13:00:00', '14:00:00', '2021-11-16 16:02:42');

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
(2, 'Juan Miguel', '', 0, 'jmhurtadomontejano@gmail.com', '$2y$10$4CpkXo2DCIn9BlEM/6dh4OM2f7kZJfazD8SLQLeci9oLYIp9kQEbK', 'foto.jpg', 'f969f47fa4e4b6aae05f5c0608fa1a45718bf3ad', '2021-11-14 14:32:18'),
(3, 'Cristian', '', 0, 'cbeldean@gmail.com', '$2y$10$zaf.UTzsvSYQhFblMUEAcennMQTuCnrxSUUcKy5zzp8GpmdsDhvx6', 'foto.jpg', '10bf5c253290e701d512d59d10e6774d19aac9be', '2021-11-14 14:32:18'),
(4, 'Claudia', 'Ojeda', 0, 'cojeda@gmail.com', '$2y$10$tODqCppWTEXQiSWeXSgHJugP60jlZ.bbYUu4McuYzNX4iqK81e29W', 'foto.jpg', 'a802bf055751d8de977f7f7afffbbae8db116c99', '2021-11-14 14:46:34'),
(5, 'rita', 'montejano', 0, 'rmontejano@gmail.com', '$2y$10$srqWsv/BlYpfJNp//taqOOuenAerIZ5a7J99G1OZLM96gru0xJlD2', 'foto.jpg', '021af9ca0cef99fbaab478efa377399f94a1a073', '2021-11-14 16:21:08'),
(6, 'Paco', 'asas', 343434343, 'paco@gmail.com', '$2y$10$m8HgZN4zW3y/UXm8xSsNHeg.4V7qqYBdQZ.GVpzAmAtK8lO42NXM2', 'foto.jpg', '8a8b4d97c531bce9b40e7ae020653f99f5361610', '2021-11-14 16:23:21'),
(7, 'Manolo', 'ruiz', 34343434, 'manolo@gmail.com', '$2y$10$wCVARnTBYHOlFk4lE2ldR.s9N1YMJAYLbQnzwq/ucQsLqjmeEJ1uG', 'foto.jpg', '2714917b76b394b5228357a2786fbee0652e6d63', '2021-11-14 16:25:22'),
(8, 'Trini', 'Hurtado', 2147483647, 'trini@gmail.com', '$2y$10$ZjLXptdvya7WtloOBL/wYemJhHI3K6lkbu8ZWYrujj8imduQZrn9a', 'foto.jpg', '886a376ec0fb687e2e363b50fd9dfee2d7882210', '2021-11-14 16:29:54'),
(9, 'Carola', 'Mañas', 12121212, 'carola@gmail.com', '$2y$10$Ori.Q5YoxhpS299uD9.RLOGDJwBzaLHBHfJ.ZvPMLCXrsoruKONbK', 'foto.jpg', '089a51eef333039f22b3554c1992acb7c6d2d33e', '2021-11-14 16:39:05'),
(10, 'Luisa', 'Hurtado', 656565656, 'luisa@gmail.com', '$2y$10$pffbBs02x3BcMuMJXj2hPelhkJpFMCjfOxg3T/ZWAJUCRTv1GF2Kq', 'foto.jpg', '1377e986c464d9fd310a4f35f79a0d85b6e18eff', '2021-11-15 09:49:01'),
(11, 'Manoli', 'Cañas', 2147483647, 'manoli@gmail.com', '$2y$10$WuhCAAgb5j.FVA1rd4BQPesD.6KczhmYUeoD6CrefjyamEuCSs8I2', 'foto.jpg', 'a9c88922255d0d60bbcfcf8a9a929c6dc1762781', '2021-11-16 16:00:07'),
(12, 'Juan Miguel', 'Montejano', 649564806, 'jm@gmail.com', '$2y$10$FHyIFIXP3IMnRQ5chTF03ObnQUsUygZ9N.1NfDlDGFfRgrm3o.bV.', 'foto.jpg', '96bb6bc8a4579c2c3f92b18251ee5e111da9be92', '2021-11-16 16:36:47');

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
  MODIFY `id_reserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
