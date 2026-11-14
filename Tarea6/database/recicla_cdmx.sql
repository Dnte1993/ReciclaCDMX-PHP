-- Base de datos para el proyecto ReciclaCDMX (Tarea 6)
CREATE DATABASE IF NOT EXISTS recicla_cdmx CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE recicla_cdmx;

-- Estructura de tabla para la tabla `usuarios`
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('registrado', 'admin') NOT NULL DEFAULT 'registrado',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);