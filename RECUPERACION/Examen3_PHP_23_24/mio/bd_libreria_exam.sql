-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-04-2024 a las 20:37:31
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bd_libreria_exam`
--
CREATE DATABASE IF NOT EXISTS `bd_libreria_exam` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bd_libreria_exam`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `referencia` int(11) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `autor` varchar(30) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `precio` decimal(5,2) NOT NULL,
  `portada` varchar(50) NOT NULL DEFAULT 'no_imagen.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`referencia`, `titulo`, `autor`, `descripcion`, `precio`, `portada`) VALUES
(1, 'Código Limpio', 'Robert C. Martin', 'Cada año, se invierten innumerables horas y se pierden numerosos recursos debido a código mal escrito, ralentizando el desarrollo, disminuyendo la pro', 50.02, 'no_imagen.jpg'),
(2, 'El viaje del héroe: Un camino ', 'Robert Dilts', 'Si pudieras oír furtivamente una conversación entre dos de los autores que más han contribuido a la espiritualidad de la PNL, aquí la tienes...', 18.00, 'no_imagen.jpg'),
(3, 'El Programador Pragmático, Via', 'David Thomas', 'El programador pragmático es uno de esos raros casos de libros técnicos que se leen, se releen y se vuelven a leer durante años. Tanto si es nuevo en ', 38.00, 'no_imagen.jpg'),
(4, 'Diseño Funcional. Principios, ', 'Robert C. Martin', 'En Diseño funcional, el reputado ingeniero de software Robert C. Martin (\"Uncle Bob\") explica cómo y por que utilizar la programación funcional para c', 0.00, 'no_imagen.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `lector` varchar(15) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `tipo` enum('admin','normal') NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `lector`, `clave`, `tipo`) VALUES
(1, 'Nacho', '827ccb0eea8a706c4c34a16891f84e7b', 'admin'),
(2, 'Juan', '81dc9bdb52d04dc20036dbd8313ed055', 'normal');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`referencia`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
