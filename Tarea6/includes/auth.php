<?php
// Iniciar o reanudar la sesión en cualquier página que cargue este archivo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluir la conexión a la base de datos MySQL
require_once __DIR__ . '/conexion.php';

// Función auxiliar para verificar si hay una sesión activa validando también el identificador de MySQL
function estaLogueado() {
    return isset($_SESSION['id_usuario']) && isset($_SESSION['usuario']);
}

// Función para garantizar que existan las cuentas de prueba de cada rol en MySQL con contraseña encriptada
function inicializarUsuariosPrueba($conexion) {
    $cuentasPrueba = [
        [
            "nombre" => "Ciudadano",
            "correo" => "usuario@reciclacdmx.com",
            "password" => "12345",
            "rol" => "registrado"
        ],
        [
            "nombre" => "Administrador",
            "correo" => "admin@reciclacdmx.com",
            "password" => "admin123",
            "rol" => "admin"
        ]
    ];

    foreach ($cuentasPrueba as $cuenta) {
        // Comprobar con consulta preparada si el correo ya está registrado en MySQL
        $stmtCheck = mysqli_prepare($conexion, "SELECT id_usuario FROM usuarios WHERE correo = ?");
        mysqli_stmt_bind_param($stmtCheck, "s", $cuenta['correo']);
        mysqli_stmt_execute($stmtCheck);
        $resultado = mysqli_stmt_get_result($stmtCheck);

        // Si no existe en la tabla, encriptamos su contraseña e insertamos el registro
        if (mysqli_num_rows($resultado) === 0) {
            $passwordHash = password_hash($cuenta['password'], PASSWORD_DEFAULT);
            $stmtInsert = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmtInsert, "ssss", $cuenta['nombre'], $cuenta['correo'], $passwordHash, $cuenta['rol']);
            mysqli_stmt_execute($stmtInsert);
            mysqli_stmt_close($stmtInsert);
        }
        mysqli_stmt_close($stmtCheck);
    }
}

// Ejecutar la verificación de cuentas iniciales
inicializarUsuariosPrueba($conexion);
?>