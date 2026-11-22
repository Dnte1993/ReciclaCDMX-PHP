<?php
    // 0. Protección de acceso: Validar sesión activa y rol exclusivo de ciudadano ("registrado")
    require_once 'includes/auth.php';
    if (!estaLogueado()) {
        header("Location: login.php");
        exit();
    }

    if (($_SESSION["rol"] ?? "") !== "registrado") {
        header("Location: index.php");
        exit();
    }

    // Incluir archivo de funciones propias
    require_once 'includes/funciones.php';

    // 1. Declaración de variables y carga de catálogos desde MySQL antes del HTML
    $idMaterial = 0;
    $idCentro = 0;
    $cantidad = "";
    $fecha = "";
    $mensajeExito = "";
    $mensajeError = "";
    $idUsuarioActual = (int) $_SESSION['id_usuario'];
    $fechaActual = date("Y-m-d");

    $catalogoMateriales = obtenerCatalogoMateriales($conexion);
    $catalogoCentros = obtenerCentrosDeAcopio($conexion);

    // Mapas auxiliares para validar IDs recibidos por POST y construir mensajes claros
    $mapaMateriales = [];
    foreach ($catalogoMateriales as $mat) {
        $mapaMateriales[(int) $mat['id_material']] = $mat['nombre'];
    }

    $mapaCentros = [];
    foreach ($catalogoCentros as $cen) {
        $mapaCentros[(int) $cen['id_centro']] = $cen['alcaldia'] . " - " . $cen['nombre'];
    }

    // 2. Recepción, validación y registro en MySQL mediante POST (INSERT preparado)
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_material"])) {
        $idMaterial = (int) ($_POST["id_material"] ?? 0);
        $idCentro = (int) ($_POST["id_centro"] ?? 0);
        $cantidad = trim($_POST["cantidad"] ?? "");
        $fecha = trim($_POST["fecha"] ?? "");

        if (empty($fecha)) {
            $fecha = $fechaActual;
        }

        if (!isset($mapaMateriales[$idMaterial]) || !isset($mapaCentros[$idCentro]) || $cantidad === "") {
            $mensajeError = "Por favor, selecciona un material válido, un centro de acopio e ingresa la cantidad.";
        } elseif (!is_numeric($cantidad) || (float) $cantidad <= 0) {
            $mensajeError = "La cantidad ingresada no puede ser negativa ni cero.";
        } elseif (!validarFechaRegistro($fecha, $fechaActual)) {
            $mensajeError = "La fecha debe pertenecer al año 2026 y no puede ser una fecha futura.";
        } else {
            $cantidadNum = (float) $cantidad;
            $estadoInicial = "Pendiente";

            // Guardar la aportación relacionada con usuario, material y centro de acopio
            $stmtInsert = mysqli_prepare(
                $conexion,
                "INSERT INTO aportaciones (id_usuario, id_material, id_centro, cantidad_kg, fecha_recoleccion, estado)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmtInsert, "iiidss", $idUsuarioActual, $idMaterial, $idCentro, $cantidadNum, $fecha, $estadoInicial);

            if (mysqli_stmt_execute($stmtInsert)) {
                $materialSeguro = htmlspecialchars($mapaMateriales[$idMaterial]);
                $centroSeguro = htmlspecialchars($mapaCentros[$idCentro]);
                $cantidadSegura = htmlspecialchars(number_format($cantidadNum, 2));
                $fechaSegura = htmlspecialchars($fecha);
                $mensajeExito = "Has registrado " . $cantidadSegura . " kg de " . $materialSeguro . " en " . $centroSeguro . " con fecha " . $fechaSegura . " (Estado: Pendiente de validación).";
            } else {
                $mensajeError = "Ocurrió un error al guardar tu aportación en la base de datos.";
            }
            mysqli_stmt_close($stmtInsert);
        }
    }

    // 3. Consultar mediante SELECT con INNER JOIN las aportaciones propias del usuario en sesión
    $misAportaciones = [];
    $totalKgUsuario = 0.0;

    $sqlMisAportaciones = "SELECT a.id_aportacion, m.nombre AS nombre_material, c.nombre AS nombre_centro, c.alcaldia,
                                  a.cantidad_kg, a.fecha_recoleccion, a.estado, a.fecha_registro
                           FROM aportaciones a
                           INNER JOIN materiales m ON a.id_material = m.id_material
                           INNER JOIN centros_acopio c ON a.id_centro = c.id_centro
                           WHERE a.id_usuario = ?
                           ORDER BY a.fecha_recoleccion DESC, a.id_aportacion DESC";

    $stmtSelect = mysqli_prepare($conexion, $sqlMisAportaciones);
    mysqli_stmt_bind_param($stmtSelect, "i", $idUsuarioActual);
    mysqli_stmt_execute($stmtSelect);
    $resultadoAportaciones = mysqli_stmt_get_result($stmtSelect);

    while ($fila = mysqli_fetch_assoc($resultadoAportaciones)) {
        $misAportaciones[] = $fila;
        if ($fila['estado'] !== 'Rechazado') {
            $totalKgUsuario += (float) $fila['cantidad_kg'];
        }
    }
    mysqli_stmt_close($stmtSelect);

    // 4. Incluir encabezado
    include 'includes/header.php';
?>

    <main>
        <section>
            <h2>Mi Contador de Reciclaje</h2>
            <p>Registra tus aportaciones y consulta el estado de validación asignado por la administración.</p>

            <!-- Alertas dinámicas de error o éxito -->
            <?php 
                echo mostrarMensaje($mensajeError, 'error');
                echo mostrarMensaje($mensajeExito, 'exito');
            ?>

            <!-- Formulario POST para registrar aportación en MySQL -->
            <form action="contador.php" method="POST" style="margin: 20px 0; padding: 20px; background-color: #f5f5f5; border-radius: 8px; max-width: 500px; border-top: 4px solid #E65100;">
                
                <div style="margin-bottom: 15px;">
                    <label for="id_material" style="font-weight: bold; display: block; margin-bottom: 5px;">Tipo de Material:</label>
                    <select id="id_material" name="id_material" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                        <option value="">Selecciona una opción</option>
                        <?php foreach ($catalogoMateriales as $material) { ?>
                            <option value="<?php echo (int) $material['id_material']; ?>">
                                <?php echo htmlspecialchars($material['nombre']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="id_centro" style="font-weight: bold; display: block; margin-bottom: 5px;">Centro de Acopio:</label>
                    <select id="id_centro" name="id_centro" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                        <option value="">Selecciona un centro</option>
                        <?php foreach ($catalogoCentros as $centro) { ?>
                            <option value="<?php echo (int) $centro['id_centro']; ?>">
                                <?php echo htmlspecialchars($centro['alcaldia'] . " - " . $centro['nombre']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="cantidad" style="font-weight: bold; display: block; margin-bottom: 5px;">Cantidad ingresada (kg):</label>
                    <input type="number" id="cantidad" name="cantidad" step="0.01" min="0.01" required placeholder="Ej. 10.50" style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="fecha" style="font-weight: bold; display: block; margin-bottom: 5px;">Fecha de recolección:</label>
                    <input type="date" id="fecha" name="fecha" min="2026-01-01" max="<?php echo $fechaActual; ?>" style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <button type="submit" style="padding: 10px 20px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold;">Registrar Material</button>
            </form>
        </section>

        <!-- Apartado de consulta de aportaciones propias del usuario en sesión -->
        <section style="margin-top: 35px;">
            <h3>Mis Aportaciones Registradas</h3>
            <p>Total acumulado (aportaciones pendientes y validadas): <strong><?php echo number_format($totalKgUsuario, 2); ?> kg</strong></p>

            <?php if (count($misAportaciones) === 0) { ?>
                <p style="padding: 15px; background-color: #fff3e0; border-left: 4px solid #E65100;">Aún no tienes aportaciones registradas en tu cuenta.</p>
            <?php } else { ?>
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; margin-top: 10px; background-color: white;">
                        <thead>
                            <tr style="background-color: #E65100; color: white; text-align: left;">
                                <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Material</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Centro de Acopio</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Cantidad (kg)</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Fecha de Recolección</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Estado de Validación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($misAportaciones as $item) { 
                                $colorEstado = "#f57c00"; // Pendiente
                                if ($item['estado'] === "Validado") {
                                    $colorEstado = "#2e7d32";
                                } elseif ($item['estado'] === "Rechazado") {
                                    $colorEstado = "#c62828";
                                }
                            ?>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;">#<?php echo (int) $item['id_aportacion']; ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($item['nombre_material']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($item['alcaldia'] . " - " . $item['nombre_centro']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo number_format((float) $item['cantidad_kg'], 2); ?> kg</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($item['fecha_recoleccion']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: <?php echo $colorEstado; ?>;">
                                        <?php echo htmlspecialchars($item['estado']); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } ?>
        </section>
    </main>

<?php
    // 5. Incluir pie de página
    include 'includes/footer.php';
?>