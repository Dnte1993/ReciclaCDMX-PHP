<?php
    // Iniciar o recuperar la sesión actual
    session_start();

    // Limpiar todas las variables de sesión
    session_unset();

    // Destruir la sesión por completo
    session_destroy();

    // Redirigir al usuario a la página principal
    header("Location: index.php");
    exit();
?>