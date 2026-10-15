<?php
// Función 1: Validar que la fecha ingresada sea del año 2026 y no sea futura
// Recibe la fecha del formulario y la fecha actual. Retorna true (válida) o false (inválida).
function validarFechaRegistro($fecha, $fechaActual) {
    if ($fecha < "2026-01-01" || $fecha > $fechaActual) {
        return false;
    }
    return true;
}

// Función 2: Generar alertas visuales dinámicas para no repetir código HTML[cite: 6]
// Recibe el texto del mensaje y el tipo (error, exito, info) para aplicar estilos automáticamente.
function mostrarMensaje($mensaje, $tipo = 'info') {
    if (empty($mensaje)) {
        return ""; // Si no hay mensaje, no imprime nada
    }

    // Estilos dinámicos según el tipo de mensaje
    if ($tipo === 'error') {
        $bgColor = "#ffebee"; $borderColor = "#c62828"; $textColor = "#c62828"; $prefijo = "Error:";
    } elseif ($tipo === 'exito') {
        $bgColor = "#e8f5e9"; $borderColor = "#2e7d32"; $textColor = "#2e7d32"; $prefijo = "¡Éxito!";
    } else {
        $bgColor = "#e3f2fd"; $borderColor = "#1976d2"; $textColor = "#1976d2"; $prefijo = "Aviso:";
    }

    // Retorna el bloque HTML construido
    return "<div style='background-color: $bgColor; padding: 15px; border-left: 5px solid $borderColor; border-radius: 4px; margin-bottom: 20px;'>
                <p style='color: $textColor; margin: 0;'><strong>$prefijo</strong> $mensaje</p>
            </div>";
}
?>