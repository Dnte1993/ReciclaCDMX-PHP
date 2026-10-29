<?php
    // 0. Protección de acceso (Sesiones)[cite: 42]
    require_once 'includes/auth.php';
    if (!estaLogueado()) {
        // Si no hay sesión activa, impedimos el acceso y redirigimos al login[cite: 42]
        header("Location: login.php");
        exit();
    }

    // Reutilización de código: Se incluye el archivo de funciones propias
    require_once 'includes/funciones.php';
    
    // 1. Declaración de variables
    $tipoMaterial = "";
    $cantidad = "";
    $fecha = "";
    $mensajeExito = "";
    $mensajeError = "";

    // Obtenemos la fecha actual
    $fechaActual = date("Y-m-d");

    // 2. Recepción y validación de datos con POST
    if (isset($_POST["material"])) {
        
        $tipoMaterial = $_POST["material"];
        $cantidad = $_POST["cantidad"];
        $fecha = $_POST["fecha"];

        if (empty($fecha)) {
            $fecha = $fechaActual;
        }

        if (empty($tipoMaterial) || empty($cantidad)) {
            $mensajeError = "Por favor, selecciona un material e ingresa la cantidad.";
        } elseif ($cantidad <= 0) {
            $mensajeError = "La cantidad ingresada no puede ser negativa ni cero.";
        } 
        // Uso de la función propia para validar la fecha
        elseif (!validarFechaRegistro($fecha, $fechaActual)) {
            $mensajeError = "La fecha debe pertenecer al año 2026 y no puede ser una fecha futura.";
        } 
        else {
            $materialSeguro = htmlspecialchars($tipoMaterial);
            $cantidadSegura = htmlspecialchars($cantidad);
            $fechaSegura = htmlspecialchars($fecha);

            $mensajeExito = "Has sumado " . $cantidadSegura . " kg de " . $materialSeguro . " a tu contador personal el día " . $fechaSegura . ".";
        }
    }

    // Reutilización de código: Se incluye el encabezado
    include 'includes/header.php';
?>

    <main>
        <section>
            <h2>Mi Contador de Reciclaje</h2>
            <p>Registra tus aportaciones. Cada gramo cuenta para una ciudad más limpia.</p>

            <!-- Uso de la función propia para imprimir alertas sin repetir HTML -->
            <?php 
                echo mostrarMensaje($mensajeError, 'error');
                echo mostrarMensaje($mensajeExito, 'exito');
            ?>

            <!-- Formulario POST que no muestra los datos en la URL -->
            <form action="contador.php" method="POST" style="margin: 20px 0; padding: 20px; background-color: #f5f5f5; border-radius: 8px; max-width: 500px; border-top: 4px solid #E65100;">
                
                <div style="margin-bottom: 15px;">
                    <label for="material" style="font-weight: bold; display: block; margin-bottom: 5px;">Tipo de Material:</label>
                    <select id="material" name="material" style="width: 100%; padding: 8px; box-sizing: border-box;">
                        <option value="">Selecciona una opción</option>
                        <option value="PET">PET</option>
                        <option value="Cartón">Cartón</option>
                        <option value="Vidrio">Vidrio</option>
                        <option value="Aluminio">Aluminio</option>
                        <option value="Pilas">Pilas</option>
                        <option value="Electrónicos">Electrónicos</option>
                        <option value="Aceite">Aceite</option>
                        <option value="Ropa">Ropa</option>
                        <option value="Tetrapak">Tetrapak</option>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="cantidad" style="font-weight: bold; display: block; margin-bottom: 5px;">Cantidad ingresada (kg):</label>
                    <input type="number" id="cantidad" name="cantidad" step="0.01" min="0.01" placeholder="Ej. 10.50" style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="fecha" style="font-weight: bold; display: block; margin-bottom: 5px;">Fecha de recolección:</label>
                    <input type="date" id="fecha" name="fecha" min="2026-01-01" max="<?php echo $fechaActual; ?>" style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <button type="submit" style="padding: 10px 20px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold;">Registrar Material</button>
            </form>
        </section>
    </main>

<?php
    // Reutilización de código: Se incluye el pie de página[cite: 6]
    include 'includes/footer.php';
?>