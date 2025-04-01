-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-03-2025 a las 19:19:51
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
-- Base de datos: `sabor_caribe`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platos`
--

CREATE TABLE `platos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `platos`
--

INSERT INTO `platos` (`id`, `nombre`, `descripcion`, `precio`, `categoria`, `disponible`) VALUES
(1, 'Arroz con Pollo', 'Delicioso arroz con trozos de pollo y verduras.', 8.99, 'Principal', 1),
(2, 'Empanadas de Carne', 'Empanadas rellenas de carne molida y especias.', 3.50, 'Entrada', 1),
(3, 'Pescado Frito', 'Pescado fresco frito al estilo caribeño.', 12.00, 'Principal', 1),
(4, 'Tostones', 'Plátanos verdes fritos y crujientes.', 4.00, 'Acompañante', 1),
(5, 'Ceviche de Camarón', 'Camarones marinados en jugo de limón con cebolla y cilantro.', 10.50, 'Entrada', 1),
(6, 'Arepas Rellenas', 'Arepas rellenas con queso y carne.', 6.75, 'Principal', 1),
(7, 'Mofongo', 'Plátano machacado con chicharrón y ajo.', 9.50, 'Principal', 1),
(8, 'Yuca Frita', 'Trozos de yuca frita acompañados de salsa.', 4.25, 'Acompañante', 1),
(9, 'Sancocho', 'Sopa tradicional con carne y vegetales.', 11.00, 'Principal', 1),
(10, 'Flan de Coco', 'Postre tradicional de coco con caramelo.', 5.00, 'Postre', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','client') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin_user', '123', 'admin'),
(2, 'client1', '1234', 'client'),
(3, 'client2', '1234', 'client');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `platos`
--
ALTER TABLE `platos`
  ADD PRIMARY KEY (`id`);


-- Indices de la tabla `users`
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);



-- AUTO_INCREMENT de la tabla `platos`

ALTER TABLE `platos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

-- AUTO_INCREMENT de la tabla `users`
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
