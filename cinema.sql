-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-11-2021 a las 04:18:07
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cinema`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacionpelicula`
--

CREATE TABLE `calificacionpelicula` (
  `id_calificacion` int(11) NOT NULL,
  `id_pelicula` int(11) NOT NULL,
  `calificacion` float(2,1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id_categoria` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id_categoria`, `nombre`) VALUES
(1, 'Accion'),
(2, 'Terror'),
(3, 'Fantasia'),
(4, 'Comedia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pelicula`
--

CREATE TABLE `pelicula` (
  `id_pelicula` int(11) NOT NULL,
  `nombre` varchar(1000) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `ruta_caratula` varchar(10000) NOT NULL,
  `duracion` time NOT NULL DEFAULT '00:00:00',
  `rutatrailer` varchar(10000) NOT NULL,
  `fecha_estreno` date NOT NULL,
  `visto` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pelicula`
--

INSERT INTO `pelicula` (`id_pelicula`, `nombre`, `descripcion`, `ruta_caratula`, `duracion`, `rutatrailer`, `fecha_estreno`, `visto`) VALUES
(10, 'No time to die', 'Primera desc', 'images/No-Time-To-Die-miaminews24-1.png', '02:48:00', 'https://www.youtube.com/watch?v=BIhNsAtPbPI&t=58s', '2021-10-18', 65);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `peliculaporcategoria`
--

CREATE TABLE `peliculaporcategoria` (
  `id_peliculaporcategoria` int(11) NOT NULL,
  `id_pelicula` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `peliculaporcategoria`
--

INSERT INTO `peliculaporcategoria` (`id_peliculaporcategoria`, `id_pelicula`, `id_categoria`) VALUES
(4, 10, 1),
(7, 10, 4);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificacionpelicula`
--
ALTER TABLE `calificacionpelicula`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD KEY `id_pelicula` (`id_pelicula`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  ADD PRIMARY KEY (`id_pelicula`);

--
-- Indices de la tabla `peliculaporcategoria`
--
ALTER TABLE `peliculaporcategoria`
  ADD PRIMARY KEY (`id_peliculaporcategoria`),
  ADD KEY `id_pelicula` (`id_pelicula`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificacionpelicula`
--
ALTER TABLE `calificacionpelicula`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pelicula`
--
ALTER TABLE `pelicula`
  MODIFY `id_pelicula` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de la tabla `peliculaporcategoria`
--
ALTER TABLE `peliculaporcategoria`
  MODIFY `id_peliculaporcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calificacionpelicula`
--
ALTER TABLE `calificacionpelicula`
  ADD CONSTRAINT `calificacionpelicula_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `pelicula` (`id_pelicula`);

--
-- Filtros para la tabla `peliculaporcategoria`
--
ALTER TABLE `peliculaporcategoria`
  ADD CONSTRAINT `peliculaporcategoria_ibfk_1` FOREIGN KEY (`id_pelicula`) REFERENCES `pelicula` (`id_pelicula`),
  ADD CONSTRAINT `peliculaporcategoria_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categoria` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
