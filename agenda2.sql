-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-02-2025 a las 11:02:19
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agenda2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `amisusuarios`
--

CREATE TABLE `amisusuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `fecha_nac` date NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `amisusuarios`
--

INSERT INTO `amisusuarios` (`id`, `nombre`, `apellido`, `fecha_nac`, `id_usuario`) VALUES
(1, 'pepo', 'ruiz', '2002-10-14', 1),
(2, 'Manuel', 'Romero', '2005-01-12', 2),
(3, 'Manuel', 'Romero', '2005-05-19', 3),
(4, 'Manuel', 'Romero', '2005-05-19', 3),
(5, 'Ana', 'Khalifa', '2003-06-04', 7),
(7, 'Juan', 'De Dios', '2011-06-07', 6),
(8, 'Perri', 'beniterz', '2025-01-29', 1),
(9, 'Manuel', 'Romero', '2005-01-12', 2),
(10, 'Manu', 'Sanchez', '2025-01-01', 1),
(11, 'Manu2', 'Sanchez2', '2025-01-30', 1),
(12, 'Manu23', 'Sanchez23', '2025-01-30', 1),
(13, 'ASDF', 'ASDF', '2025-01-30', 1),
(14, 'ASDF', 'ASDF', '2025-01-30', 1),
(15, 'ASDF', 'ASDF', '2025-01-30', 1),
(16, 'Manu', 'ASDF', '2025-01-29', 3),
(17, 'Eica', 'Palomino', '2025-01-27', 1),
(18, 'Concha', 'Velazquez', '2025-01-28', 2),
(19, 'fvd', 'cvx', '2025-02-05', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `juegos`
--

CREATE TABLE `juegos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `juego` varchar(20) NOT NULL,
  `plataforma` varchar(20) NOT NULL,
  `urlFoto` varchar(30) NOT NULL,
  `anio_lanzamiento` int(4) NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `juegos`
--

INSERT INTO `juegos` (`id`, `juego`, `plataforma`, `urlFoto`, `anio_lanzamiento`, `id_usuario`) VALUES
(1, 'Fortnite OG', 'PC', '../img/agch/Fortnite OG.webp', 2017, 2),
(2, 'GTAV', 'PC', '../img/agch/GTAV.webp', 2013, 2),
(3, 'MINECRAFT', 'PC', '../img/agch/MINECRAFT.jpeg', 2009, 2),
(7, 'FIFA 25', 'PC', '../img/agch/FIFA 25.avif', 2025, 2),
(8, 'Roblox', 'PC', '../img/agch/Roblox', 2029, 2),
(9, 'PES 2012', 'PC', '../img/agch/PES 2012', 2012, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_juego` bigint(20) UNSIGNED NOT NULL,
  `id_ami` bigint(20) UNSIGNED NOT NULL,
  `fecha_inicio` date NOT NULL,
  `devuelta` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `id_usuario`, `id_juego`, `id_ami`, `fecha_inicio`, `devuelta`) VALUES
(1, 2, 2, 1, '2025-01-31', 1),
(2, 2, 1, 2, '2025-02-14', 1),
(3, 2, 1, 3, '2025-01-01', 1),
(4, 2, 3, 3, '2025-01-09', 1),
(5, 2, 2, 3, '2025-01-02', 1),
(6, 2, 7, 3, '2025-01-01', 1),
(7, 2, 2, 3, '2025-01-16', 1),
(8, 2, 2, 3, '2025-02-01', 1),
(9, 2, 3, 3, '2025-02-12', 1),
(10, 2, 1, 2, '2025-03-14', 1),
(11, 2, 2, 2, '2025-02-04', 1),
(12, 2, 1, 2, '2025-02-04', 1),
(13, 2, 1, 2, '2025-01-28', 1),
(14, 2, 1, 2, '2025-02-05', 1),
(15, 2, 3, 2, '2025-01-28', 1),
(16, 2, 1, 2, '2025-01-27', 1),
(17, 2, 7, 2, '2025-01-28', 1),
(19, 2, 1, 2, '2025-02-13', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `contrasenia` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `contrasenia`) VALUES
(1, 'admin', 'admin'),
(2, 'agch', 'AGCH'),
(3, 'Manuel', '1234'),
(4, 'perri', 'perri'),
(5, 'Jaled', '1234'),
(6, 'Eli', 'eli'),
(7, 'Ana', 'ana'),
(8, 'Alejandro', '1234'),
(9, 'Nasaro', '1234');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `amisusuarios`
--
ALTER TABLE `amisusuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_amiusu_usu` (`id_usuario`);

--
-- Indices de la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_jue_usu` (`id_usuario`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_pres_usu` (`id_usuario`),
  ADD KEY `fk_pres_ami` (`id_ami`),
  ADD KEY `fk_pres_juego` (`id_juego`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `amisusuarios`
--
ALTER TABLE `amisusuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `amisusuarios`
--
ALTER TABLE `amisusuarios`
  ADD CONSTRAINT `fk_amiusu_usu` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `juegos`
--
ALTER TABLE `juegos`
  ADD CONSTRAINT `fk_jue_usu` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_pres_ami` FOREIGN KEY (`id_ami`) REFERENCES `amisusuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pres_juego` FOREIGN KEY (`id_juego`) REFERENCES `juegos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pres_usu` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
