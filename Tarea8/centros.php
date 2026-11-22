<?php
    // 1. Incluir conexión a MySQL y funciones propias
    require_once 'includes/conexion.php';
    require_once 'includes/funciones.php';

    // 2. Declaración de variables iniciales antes del HTML
    $tituloCentros = "Centros de Acopio";
    $descripcion = "Encuentra el punto verde más cercano a tu domicilio. Selecciona tu alcaldía para ver los detalles y el impacto acumulado.";
    $catalogoCentros = obtenerCentrosDeAcopio($conexion);
    $centroSeleccionado = null;
    $claveSeleccionada = "";
    $mensajeError = "";

    // 3. Procesar el formulario GET y consultar el centro con LEFT JOIN hacia aportaciones
    if (isset($_GET["centro"])) {
        $claveSeleccionada = trim($_GET["centro"]);

        if (empty($claveSeleccionada)) {
            $mensajeError = "Por favor selecciona un centro de la lista antes de consultar.";
        } else {
            $sqlCentro = "SELECT c.id_centro, c.clave, c.nombre, c.alcaldia, c.direccion, c.dias, c.horario,
                                 COUNT(a.id_aportacion) AS total_aportaciones,
                                 COALESCE(SUM(a.cantidad_kg), 0) AS total_kg
                          FROM centros_acopio c
                          LEFT JOIN aportaciones a 
                                 ON c.id_centro = a.id_centro AND a.estado <> 'Rechazado'
                          WHERE c.clave = ?
                          GROUP BY c.id_centro, c.clave, c.nombre, c.alcaldia, c.direccion, c.dias, c.horario";

            $stmtCentro = mysqli_prepare($conexion, $sqlCentro);
            mysqli_stmt_bind_param($stmtCentro, "s", $claveSeleccionada);
            mysqli_stmt_execute($stmtCentro);
            $resultadoCentro = mysqli_stmt_get_result($stmtCentro);

            if ($filaCentro = mysqli_fetch_assoc($resultadoCentro)) {
                $centroSeleccionado = $filaCentro;
            } else {
                $mensajeError = "El centro de acopio seleccionado no se encuentra registrado.";
            }
            mysqli_stmt_close($stmtCentro);
        }
    }

    // 4. Incluir encabezado
    include 'includes/header.php';
?>

    <main>
        <section>
            <h2 style="display: flex; align-items: center; justify-content: space-between;">
                <span><?php echo htmlspecialchars($tituloCentros); ?></span>
            </h2>
            <p><?php echo htmlspecialchars($descripcion); ?></p>
            
            <!-- Formulario de selección con método GET -->
            <form action="centros.php" method="GET" style="margin: 20px 0; padding: 20px; background-color: #f5f5f5; border-radius: 8px; border-top: 4px solid #E65100;">
                <label for="centro" style="font-weight: bold; display: block; margin-bottom: 10px;">Selecciona un centro de acopio:</label>
                
                <select name="centro" id="centro" style="padding: 8px; width: 60%; max-width: 400px; margin-right: 10px;">
                    <option value="">-- Elige una opción --</option>
                    <?php foreach ($catalogoCentros as $centro) { 
                        $selected = ($claveSeleccionada === $centro["clave"]) ? "selected" : "";
                    ?>
                        <option value="<?php echo htmlspecialchars($centro["clave"]); ?>" <?php echo $selected; ?>>
                            <?php echo htmlspecialchars($centro["alcaldia"] . " - " . $centro["nombre"]); ?>
                        </option>
                    <?php } ?>
                </select>
                
                <button type="submit" style="padding: 9px 20px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Ver información</button>
            </form>

            <!-- Mensajes de validación o error -->
            <?php echo mostrarMensaje($mensajeError, 'error'); ?>
            
            <!-- Información detallada del centro seleccionado desde MySQL -->
            <?php if ($centroSeleccionado !== null) { ?>
                <div style="background-color: #e8f5e9; padding: 20px; border-left: 5px solid #2e7d32; border-radius: 4px; margin-top: 20px;">
                    <h3 style="color: #2e7d32; margin-top: 0; border-bottom: 1px solid #c8e6c9; padding-bottom: 10px;">
                        📍 <?php echo htmlspecialchars($centroSeleccionado["nombre"]); ?>
                    </h3>
                    
                    <ul style="list-style-type: none; padding: 0; margin-top: 15px;">
                        <li style="margin-bottom: 10px;"><strong>Alcaldía:</strong> <?php echo htmlspecialchars($centroSeleccionado["alcaldia"]); ?></li>
                        <li style="margin-bottom: 10px;"><strong>Dirección:</strong> <?php echo htmlspecialchars($centroSeleccionado["direccion"]); ?></li>
                        <li style="margin-bottom: 10px;"><strong>Días de atención:</strong> <?php echo htmlspecialchars($centroSeleccionado["dias"]); ?></li>
                        <li style="margin-bottom: 10px;"><strong>Horario:</strong> <?php echo htmlspecialchars($centroSeleccionado["horario"]); ?></li>
                        <li style="margin-bottom: 10px;"><strong>Aportaciones registradas (activas):</strong> <?php echo (int) $centroSeleccionado["total_aportaciones"]; ?></li>
                        <li style="margin-bottom: 10px;"><strong>Total reciclado en este centro:</strong> <?php echo number_format((float) $centroSeleccionado["total_kg"], 2); ?> kg</li>
                    </ul>
                </div>
            <?php } ?>
            
        </section>
    </main>

<?php
    // 5. Incluir pie de página
    include 'includes/footer.php';
?>