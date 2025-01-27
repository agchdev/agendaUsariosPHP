-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-01-2025 a las 23:45:28
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `agenda`
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
(1, 'pepe', 'ruiz', '2002-10-14', 1),
(2, 'Manuel', 'Romero', '2005-01-12', 1),
(3, 'Maite', 'Correa', '2002-10-15', 2),
(4, 'Manuel', 'Romero', '2005-05-11', 2),
(5, 'Ana', 'Khalifa', '2003-06-04', 2);

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
(1, 'Fortnite', 'PC', '../imgs/Fortnite', 2017, 2),
(2, 'GTAV', 'PC', './imgs/GTAV', 2013, 2),
(3, 'MINECRAFT', 'PC', './imgs/MINECRAFT', 2009, 2);

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
(2, 'agch', 'agch');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `juegos`
--
ALTER TABLE `juegos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
