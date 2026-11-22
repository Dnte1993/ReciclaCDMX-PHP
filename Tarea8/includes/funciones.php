<?php
// Función 1: Validar que la fecha ingresada sea del año 2026 y no sea futura
function validarFechaRegistro($fecha, $fechaActual) {
    if ($fecha < "2026-01-01" || $fecha > $fechaActual) {
        return false;
    }
    return true;
}

// Función 2: Generar alertas visuales dinámicas según el tipo (error, exito, info)
function mostrarMensaje($mensaje, $tipo = 'info') {
    if (empty($mensaje)) {
        return "";
    }

    if ($tipo === 'error') {
        $bgColor = "#ffebee"; $borderColor = "#c62828"; $textColor = "#c62828"; $prefijo = "Error:";
    } elseif ($tipo === 'exito') {
        $bgColor = "#e8f5e9"; $borderColor = "#2e7d32"; $textColor = "#2e7d32"; $prefijo = "¡Éxito!";
    } else {
        $bgColor = "#e3f2fd"; $borderColor = "#1976d2"; $textColor = "#1976d2"; $prefijo = "Aviso:";
    }

    return "<div style='background-color: $bgColor; padding: 15px; border-left: 5px solid $borderColor; border-radius: 4px; margin-bottom: 20px;'>
                <p style='color: $textColor; margin: 0;'><strong>$prefijo</strong> $mensaje</p>
            </div>";
}

// Función 3: Consultar el catálogo de centros de acopio desde MySQL
function obtenerCentrosDeAcopio($conexion) {
    $centros = [];
    $sql = "SELECT id_centro, clave, nombre, alcaldia, direccion, dias, horario
            FROM centros_acopio
            ORDER BY alcaldia ASC, nombre ASC";

    $stmt = mysqli_prepare($conexion, $sql);
    if ($stmt) {
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $centros[] = $fila;
        }
        mysqli_stmt_close($stmt);
    }

    return $centros;
}

// Función 4: Consultar el catálogo de materiales reciclables desde MySQL
function obtenerCatalogoMateriales($conexion) {
    $materiales = [];
    $sql = "SELECT id_material, nombre, descripcion, imagen
            FROM materiales
            ORDER BY id_material ASC";

    $stmt = mysqli_prepare($conexion, $sql);
    if ($stmt) {
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $materiales[] = $fila;
        }
        mysqli_stmt_close($stmt);
    }

    return $materiales;
}
?>