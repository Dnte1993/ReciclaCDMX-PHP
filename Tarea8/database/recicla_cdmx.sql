-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-11-2026 a las 19:07:27
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
  `id_material` int(11) NOT NULL,
  `id_centro` int(11) NOT NULL,
  `cantidad_kg` decimal(10,2) NOT NULL,
  `fecha_recoleccion` date NOT NULL,
  `estado` enum('Pendiente','Validado','Rechazado') NOT NULL DEFAULT 'Pendiente',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `aportaciones`
--

INSERT INTO `aportaciones` (`id_aportacion`, `id_usuario`, `id_material`, `id_centro`, `cantidad_kg`, `fecha_recoleccion`, `estado`, `fecha_registro`) VALUES
(1, 1, 1, 1, 4.50, '2026-11-05', 'Validado', '2026-11-16 19:48:13'),
(2, 1, 4, 2, 2.20, '2026-11-10', 'Pendiente', '2026-11-16 19:48:13'),
(3, 4, 2, 3, 8.00, '2026-11-08', 'Validado', '2026-11-16 19:48:13'),
(4, 4, 3, 4, 3.75, '2026-11-12', 'Pendiente', '2026-11-16 19:48:13'),
(5, 1, 3, 1, 15.50, '2026-11-16', 'Rechazado', '2026-11-16 19:51:08'),
(6, 4, 6, 3, 2.00, '2026-11-16', 'Rechazado', '2026-11-16 19:51:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `centros_acopio`
--

CREATE TABLE `centros_acopio` (
  `id_centro` int(11) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `nombre` varchar(120) NOT NULL,
  `alcaldia` varchar(80) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `dias` varchar(80) NOT NULL,
  `horario` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `centros_acopio`
--

INSERT INTO `centros_acopio` (`id_centro`, `clave`, `nombre`, `alcaldia`, `direccion`, `dias`, `horario`) VALUES
(1, 'cuauhtemoc', 'Parque México', 'Cuauhtémoc', 'Av. México s/n, Hipódromo, 06100', 'Sábados y Domingos', '10:00 a 16:00 hrs'),
(2, 'benito_juarez', 'Parque de los Venados', 'Benito Juárez', 'Av. División del Norte s/n, Sta Cruz Atoyac, 03310', 'Lunes a Viernes', '09:00 a 17:00 hrs'),
(3, 'coyoacan', 'Viveros de Coyoacán', 'Coyoacán', 'Av. Progreso 1, Del Carmen, 04100', 'Lunes a Domingo', '08:00 a 14:00 hrs'),
(4, 'miguel_hidalgo', 'Bosque de Chapultepec (2da Sección)', 'Miguel Hidalgo', 'Av. de los Compositores, 11100', 'Sábados', '09:00 a 15:00 hrs'),
(5, 'tlalpan', 'Bosque de Tlalpan', 'Tlalpan', 'Camino a Santa Teresa s/n, Parques del Pedregal, 14010', 'Martes a Domingo', '08:00 a 16:00 hrs'),
(6, 'iztapalapa', 'Parque Cuitláhuac', 'Iztapalapa', 'Av. Genaro Estrada s/n, Santa Cruz Meyehualco, 09290', 'Lunes a Viernes', '10:00 a 15:00 hrs'),
(7, 'gam', 'Bosque de San Juan de Aragón', 'Gustavo A. Madero', 'Av. José Loreto Fabela s/n, San Juan de Aragón, 07920', 'Sábados y Domingos', '09:00 a 16:00 hrs'),
(8, 'azcapotzalco', 'Parque Tezozómoc', 'Azcapotzalco', 'Manuel Salazar s/n, Hacienda del Rosario, 02420', 'Lunes a Viernes', '09:00 a 14:00 hrs'),
(9, 'venustiano_carranza', 'Deportivo Oceanía', 'Venustiano Carranza', 'Av. Oceanía s/n, Pensador Mexicano, 15510', 'Miércoles a Domingo', '10:00 a 17:00 hrs'),
(10, 'xochimilco', 'Centro Deportivo Xochimilco', 'Xochimilco', 'Francisco Goitia s/n, Santiago Tepalcatlalpan, 16200', 'Fines de semana', '08:00 a 14:00 hrs'),
(11, 'alvaro_obregon', 'Parque de la Bombilla', 'Álvaro Obregón', 'Av. de la Paz s/n, Chimalistac, 01070', 'Lunes a Sábado', '09:00 a 15:00 hrs'),
(12, 'iztacalco', 'Ciudad Deportiva Magdalena Mixhuca', 'Iztacalco', 'Viad. Río de la Piedad s/n, Granjas México, 08400', 'Lunes a Viernes', '10:00 a 16:00 hrs');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id_material` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `descripcion` text NOT NULL,
  `imagen` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id_material`, `nombre`, `descripcion`, `imagen`) VALUES
(1, 'PET', 'Plástico tipo 1. Vacía el contenido, enjuaga y aplasta el envase.', 'img/pet.jpg'),
(2, 'Cartón', 'Cajas y empaques. Desarma las cajas, mantenlas secas y atadas.', 'img/carton.jpg'),
(3, 'Vidrio', 'Botellas y frascos. Enjuaga y separa por color (transparente, verde, ámbar).', 'img/vidrio.jpg'),
(4, 'Aluminio', 'Latas de bebidas y alimentos. Vacía, enjuaga y aplasta para ahorrar espacio.', 'img/aluminio.jpg'),
(5, 'Pilas', 'Baterías de uso doméstico. Retira las pilas y deposita en contenedores específicos.', 'img/pilas.jpg'),
(6, 'Electrónicos', 'Aparatos electrónicos. Lleva a centros de acopio especializados para su reciclaje seguro.', 'img/electronicos.jpg'),
(7, 'Aceite', 'Aceite de cocina usado. Almacena en botellas y llévalo a puntos de recolección autorizados.', 'img/aceite.jpg'),
(8, 'Ropa', 'Prendas de vestir. Dona ropa limpia y en buen estado a centros de acopio o tiendas de segunda mano.', 'img/ropa.jpg'),
(9, 'Tetrapak', 'Envases de cartón para líquidos. Enjuaga y aplasta antes de depositar en contenedores de reciclaje.', 'img/tetrapak.jpg');

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
  ADD KEY `fk_aportacion_usuario` (`id_usuario`),
  ADD KEY `fk_aportacion_material` (`id_material`),
  ADD KEY `fk_aportacion_centro` (`id_centro`);

--
-- Indices de la tabla `centros_acopio`
--
ALTER TABLE `centros_acopio`
  ADD PRIMARY KEY (`id_centro`),
  ADD UNIQUE KEY `uq_centro_clave` (`clave`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id_material`),
  ADD UNIQUE KEY `uq_material_nombre` (`nombre`);

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
  MODIFY `id_aportacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `centros_acopio`
--
ALTER TABLE `centros_acopio`
  MODIFY `id_centro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
  ADD CONSTRAINT `fk_aportacion_centro` FOREIGN KEY (`id_centro`) REFERENCES `centros_acopio` (`id_centro`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_aportacion_material` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`id_material`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_aportacion_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
