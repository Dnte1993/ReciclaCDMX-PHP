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

// Función para garantizar la estructura de la tabla aportaciones, usuarios de prueba y registros iniciales
function inicializarDatosPruebaTarea7($conexion) {
    // 1. Asegurar que la tabla aportaciones exista en la base de datos
    $sqlTabla = "CREATE TABLE IF NOT EXISTS aportaciones (
        id_aportacion INT AUTO_INCREMENT PRIMARY KEY,
        id_usuario INT NOT NULL,
        tipo_material VARCHAR(50) NOT NULL,
        cantidad_kg DECIMAL(10,2) NOT NULL,
        fecha_recoleccion DATE NOT NULL,
        estado ENUM('Pendiente', 'Validado', 'Rechazado') NOT NULL DEFAULT 'Pendiente',
        fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_aportacion_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    mysqli_query($conexion, $sqlTabla);

    // 2. Definir al menos dos usuarios ciudadanos de prueba y un administrador
    $cuentasPrueba = [
        [
            "nombre" => "Ciudadano Uno",
            "correo" => "usuario@reciclacdmx.com",
            "password" => "12345",
            "rol" => "registrado"
        ],
        [
            "nombre" => "María López",
            "correo" => "ciudadano2@reciclacdmx.com",
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

    // 3. Sembrar aportaciones de prueba para cada ciudadano si la tabla aportaciones está vacía
    $resConteo = mysqli_query($conexion, "SELECT COUNT(*) AS total FROM aportaciones");
    $filaConteo = mysqli_fetch_assoc($resConteo);

    if ((int)$filaConteo['total'] === 0) {
        $aportacionesIniciales = [
            // Registros propios del Ciudadano 1
            ["correo" => "usuario@reciclacdmx.com", "material" => "PET", "cantidad" => 4.50, "fecha" => "2026-11-05", "estado" => "Validado"],
            ["correo" => "usuario@reciclacdmx.com", "material" => "Aluminio", "cantidad" => 2.20, "fecha" => "2026-11-10", "estado" => "Pendiente"],
            // Registros propios del Ciudadano 2
            ["correo" => "ciudadano2@reciclacdmx.com", "material" => "Cartón", "cantidad" => 8.00, "fecha" => "2026-11-08", "estado" => "Validado"],
            ["correo" => "ciudadano2@reciclacdmx.com", "material" => "Vidrio", "cantidad" => 3.75, "fecha" => "2026-11-12", "estado" => "Pendiente"]
        ];

        foreach ($aportacionesIniciales as $item) {
            // Obtener el id_usuario correspondiente al correo
            $stmtUser = mysqli_prepare($conexion, "SELECT id_usuario FROM usuarios WHERE correo = ?");
            mysqli_stmt_bind_param($stmtUser, "s", $item['correo']);
            mysqli_stmt_execute($stmtUser);
            $resUser = mysqli_stmt_get_result($stmtUser);

            if ($userRow = mysqli_fetch_assoc($resUser)) {
                $idUsuario = (int)$userRow['id_usuario'];
                $stmtAportacion = mysqli_prepare(
                    $conexion,
                    "INSERT INTO aportaciones (id_usuario, tipo_material, cantidad_kg, fecha_recoleccion, estado) VALUES (?, ?, ?, ?, ?)"
                );
                mysqli_stmt_bind_param(
                    $stmtAportacion,
                    "isdss",
                    $idUsuario,
                    $item['material'],
                    $item['cantidad'],
                    $item['fecha'],
                    $item['estado']
                );
                mysqli_stmt_execute($stmtAportacion);
                mysqli_stmt_close($stmtAportacion);
            }
            mysqli_stmt_close($stmtUser);
        }
    }
}

// Ejecutar la verificación de estructura, cuentas iniciales y aportaciones de prueba
inicializarDatosPruebaTarea7($conexion);
?>