<?php
// Función 1: Validar que la fecha ingresada sea del año 2026 y no sea futura
// Recibe la fecha del formulario y la fecha actual. Retorna true (válida) o false (inválida).
function validarFechaRegistro($fecha, $fechaActual) {
    if ($fecha < "2026-01-01" || $fecha > $fechaActual) {
        return false;
    }
    return true;
}

// Función 2: Generar alertas visuales dinámicas para no repetir código HTML
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

// Función 3: Obtener el catálogo de centros de acopio 
// Retorna un arreglo multidimensional con 12 centros de acopio de la CDMX.
function obtenerCentrosDeAcopio() {
    return [
        "cuauhtemoc" => [
            "nombre" => "Parque México", 
            "alcaldia" => "Cuauhtémoc", 
            "direccion" => "Av. México s/n, Hipódromo, 06100", 
            "dias" => "Sábados y Domingos", 
            "horario" => "10:00 a 16:00 hrs"
        ],
        "benito_juarez" => [
            "nombre" => "Parque de los Venados", 
            "alcaldia" => "Benito Juárez", 
            "direccion" => "Av. División del Norte s/n, Sta Cruz Atoyac, 03310", 
            "dias" => "Lunes a Viernes", 
            "horario" => "09:00 a 17:00 hrs"
        ],
        "coyoacan" => [
            "nombre" => "Viveros de Coyoacán", 
            "alcaldia" => "Coyoacán", 
            "direccion" => "Av. Progreso 1, Del Carmen, 04100", 
            "dias" => "Lunes a Domingo", 
            "horario" => "08:00 a 14:00 hrs"
        ],
        "miguel_hidalgo" => [
            "nombre" => "Bosque de Chapultepec (2da Sección)", 
            "alcaldia" => "Miguel Hidalgo", 
            "direccion" => "Av. de los Compositores, 11100", 
            "dias" => "Sábados", 
            "horario" => "09:00 a 15:00 hrs"
        ],
        "tlalpan" => [
            "nombre" => "Bosque de Tlalpan", 
            "alcaldia" => "Tlalpan", 
            "direccion" => "Camino a Santa Teresa s/n, Parques del Pedregal, 14010", 
            "dias" => "Martes a Domingo", 
            "horario" => "08:00 a 16:00 hrs"
        ],
        "iztapalapa" => [
            "nombre" => "Parque Cuitláhuac", 
            "alcaldia" => "Iztapalapa", 
            "direccion" => "Av. Genaro Estrada s/n, Santa Cruz Meyehualco, 09290", 
            "dias" => "Lunes a Viernes", 
            "horario" => "10:00 a 15:00 hrs"
        ],
        "gam" => [
            "nombre" => "Bosque de San Juan de Aragón", 
            "alcaldia" => "Gustavo A. Madero", 
            "direccion" => "Av. José Loreto Fabela s/n, San Juan de Aragón, 07920", 
            "dias" => "Sábados y Domingos", 
            "horario" => "09:00 a 16:00 hrs"
        ],
        "azcapotzalco" => [
            "nombre" => "Parque Tezozómoc", 
            "alcaldia" => "Azcapotzalco", 
            "direccion" => "Manuel Salazar s/n, Hacienda del Rosario, 02420", 
            "dias" => "Lunes a Viernes", 
            "horario" => "09:00 a 14:00 hrs"
        ],
        "venustiano_carranza" => [
            "nombre" => "Deportivo Oceanía", 
            "alcaldia" => "Venustiano Carranza", 
            "direccion" => "Av. Oceanía s/n, Pensador Mexicano, 15510", 
            "dias" => "Miércoles a Domingo", 
            "horario" => "10:00 a 17:00 hrs"
        ],
        "xochimilco" => [
            "nombre" => "Centro Deportivo Xochimilco", 
            "alcaldia" => "Xochimilco", 
            "direccion" => "Francisco Goitia s/n, Santiago Tepalcatlalpan, 16200", 
            "dias" => "Fines de semana", 
            "horario" => "08:00 a 14:00 hrs"
        ],
        "alvaro_obregon" => [
            "nombre" => "Parque de la Bombilla", 
            "alcaldia" => "Álvaro Obregón", 
            "direccion" => "Av. de la Paz s/n, Chimalistac, 01070", 
            "dias" => "Lunes a Sábado", 
            "horario" => "09:00 a 15:00 hrs"
        ],
        "iztacalco" => [
            "nombre" => "Ciudad Deportiva Magdalena Mixhuca", 
            "alcaldia" => "Iztacalco", 
            "direccion" => "Viad. Río de la Piedad s/n, Granjas México, 08400", 
            "dias" => "Lunes a Viernes", 
            "horario" => "10:00 a 16:00 hrs"
        ]
    ];
}

// Función 4: Obtener el catálogo de materiales reciclables 

function obtenerCatalogoMateriales() {
    return [
        "PET" => [
            "descripcion" => "Plástico tipo 1. Vacía el contenido, enjuaga y aplasta el envase.",
            "imagen" => "img/pet.jpg"
        ],
        "Carton" => [
            "descripcion" => "Cajas y empaques. Desarma las cajas, mantenlas secas y atadas.",
            "imagen" => "img/carton.jpg"
        ],
        "Vidrio" => [
            "descripcion" => "Botellas y frascos. Enjuaga y separa por color (transparente, verde, ámbar).",
            "imagen" => "img/vidrio.jpg"
        ],
        "Aluminio" => [
            "descripcion" => "Latas de bebidas y alimentos. Vacía, enjuaga y aplasta para ahorrar espacio.",
            "imagen" => "img/aluminio.jpg"
        ],
        "Pilas" => [
            "descripcion" => "Baterías de uso doméstico. Retira las pilas y deposita en contenedores específicos.",
            "imagen" => "img/pilas.jpg"
        ],
        "Electrónicos" => [
            "descripcion" => "Aparatos electrónicos. Lleva a centros de acopio especializados para su reciclaje seguro.",
            "imagen" => "img/electronicos.jpg"
        ],
        "Aceite" => [
            "descripcion" => "Aceite de cocina usado. Almacena en botellas y llévalo a puntos de recolección autorizados.",
            "imagen" => "img/aceite.jpg"
        ],
        "Ropa" => [
            "descripcion" => "Prendas de vestir. Dona ropa limpia y en buen estado a centros de acopio o tiendas de segunda mano.",
            "imagen" => "img/ropa.jpg"
        ],
        "Tetrapak" => [
            "descripcion" => "Envases de cartón para líquidos. Enjuaga y aplasta antes de depositar en contenedores de reciclaje.",
            "imagen" => "img/tetrapak.jpg"
        ]
    ];
}

?>