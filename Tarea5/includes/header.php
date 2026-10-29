<?php
// Iniciamos sesión de forma segura si no está iniciada, para leer el estado del usuario en toda la navegación[cite: 42]
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReciclaCDMX</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h1 style="margin: 0;">ReciclaCDMX</h1>
            
            <!-- Panel de navegación condicional según sesión[cite: 42] -->
            <div style="color: white; font-weight: bold; font-size: 0.9em;">
                <?php if (isset($_SESSION['usuario'])) { ?>
                    👤 Hola, <?php echo $_SESSION['nombre']; ?> (<?php echo $_SESSION['rol']; ?>) | <a href="logout.php" style="color: #ffccbc; text-decoration: none;">Cerrar Sesión</a>
                <?php } else { ?>
                    <a href="login.php" style="background-color: #ffccbc; color: #d84315; padding: 6px 15px; border-radius: 4px; text-decoration: none;">Iniciar Sesión</a>
                <?php } ?>
            </div>
        </div>
        <nav style="margin-top: 15px;">
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="informacion.php">Información</a></li>
                <li><a href="centros.php">Centros de Acopio</a></li>
                <li><a href="detalle.php">Detalles de Reciclaje</a></li>
                <li><a href="contador.php">Mi Contador</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>