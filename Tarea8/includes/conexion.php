<?php
// Configuración de credenciales para conexión local a MySQL (XAMPP)
$servidor = "localhost";
$usuario_bd = "root";
$password_bd = "";
$nombre_bd = "recicla_cdmx";

// Establecer la conexión utilizando mysqli
$conexion = mysqli_connect($servidor, $usuario_bd, $password_bd, $nombre_bd);

// Verificar si ocurrió algún error en la conexión
if (!$conexion) {
    die("Error de conexión a la base de datos: " . mysqli_connect_error());
}

// Configurar el conjunto de caracteres a UTF-8 para soportar acentos y caracteres especiales
mysqli_set_charset($conexion, "utf8mb4");
?>