<?php
// 1. Iniciar o reanudar la sesión de forma segura en cualquier página protegida
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Incluir la conexión a la base de datos MySQL
require_once __DIR__ . '/conexion.php';

// 3. Verificar si existe una sesión activa validando el identificador de MySQL
function estaLogueado() {
    return isset($_SESSION['id_usuario']) && isset($_SESSION['usuario']);
}
?>