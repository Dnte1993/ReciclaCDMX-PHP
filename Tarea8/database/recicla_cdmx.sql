-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-11-2026 a las 02:58:15
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
-- Base de datos: `recicla_cdmx`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aportaciones`
--

CREATE TABLE `aportaciones` (
  `id_aportacion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tipo_material` varchar(50) NOT NULL,
  `cantidad_kg` decimal(10,2) NOT NULL,
  `fecha_recoleccion` date NOT NULL,
  `estado` enum('Pendiente','Validado','Rechazado') NOT NULL DEFAULT 'Pendiente',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `aportaciones`
--

INSERT INTO `aportaciones` (`id_aportacion`, `id_usuario`, `tipo_material`, `cantidad_kg`, `fecha_recoleccion`, `estado`, `fecha_registro`) VALUES
(1, 1, 'PET', 4.50, '2026-11-05', 'Validado', '2026-11-16 19:48:13'),
(2, 1, 'Aluminio', 2.20, '2026-11-10', 'Pendiente', '2026-11-16 19:48:13'),
(3, 4, 'Cartón', 8.00, '2026-11-08', 'Validado', '2026-11-16 19:48:13'),
(4, 4, 'Vidrio', 3.75, '2026-11-12', 'Pendiente', '2026-11-16 19:48:13'),
(5, 1, 'Vidrio', 15.50, '2026-11-16', 'Rechazado', '2026-11-16 19:51:08'),
(6, 4, 'Electrónicos', 2.00, '2026-11-16', 'Validado', '2026-11-16 19:51:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('registrado','admin') NOT NULL DEFAULT 'registrado',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `correo`, `password`, `rol`, `fecha_registro`) VALUES
(1, 'Ciudadano', 'usuario@reciclacdmx.com', '$2y$10$lv2w0Mz8rXAKOM0oEXBRP.D..IiJqe6G8pE9fbv1FHa8MaPZjVT4y', 'registrado', '2026-11-14 10:27:36'),
(2, 'Administrador', 'admin@reciclacdmx.com', '$2y$10$ytm8a0N1zEbek16feNLfa.rqec5YCxGapw14hCP8IXWhh7BHbHLwy', 'admin', '2026-11-14 10:27:36'),
(3, 'Dante Hernández Rodriguez', 'Dan@reciclacdmx.com', '$2y$10$DkxLNW3gZKRlEetEJKSJCehNZGzlVpr2bOGeZ6.UKUi73veH5YkcG', 'registrado', '2026-11-14 10:28:02'),
(4, 'María López', 'ciudadano2@reciclacdmx.com', '$2y$10$uFhAXVPDthwHTZpyf.pX0eG5tbfwq/yT1vC2HAqZOcS3Ts4Yn3NGe', 'registrado', '2026-11-16 19:48:13');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aportaciones`
--
ALTER TABLE `aportaciones`
  ADD PRIMARY KEY (`id_aportacion`),
  ADD KEY `fk_aportacion_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aportaciones`
--
ALTER TABLE `aportaciones`
  MODIFY `id_aportacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `aportaciones`
--
ALTER TABLE `aportaciones`
  ADD CONSTRAINT `fk_aportacion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
