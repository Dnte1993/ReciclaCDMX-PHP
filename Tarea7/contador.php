<?php
    // 0. Protección de acceso (Sesiones y Rol)
    require_once 'includes/auth.php';
    if (!estaLogueado()) {
        // Si no hay sesión activa, impedimos el acceso y redirigimos al login
        header("Location: login.php");
        exit();
    }

    // Validación de rol: Solo el usuario "registrado" tiene acceso a Mi Contador
    if (($_SESSION["rol"] ?? "") !== "registrado") {
        header("Location: index.php");
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
    $idUsuarioActual = (int) $_SESSION['id_usuario'];

    // Obtenemos la fecha actual
    $fechaActual = date("Y-m-d");

    // 2. Recepción, validación y registro en MySQL mediante POST
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["material"])) {
        
        $tipoMaterial = trim($_POST["material"]);
        $cantidad = $_POST["cantidad"];
        $fecha = $_POST["fecha"];

        if (empty($fecha)) {
            $fecha = $fechaActual;
        }

        if (empty($tipoMaterial) || empty($cantidad)) {
            $mensajeError = "Por favor, selecciona un material e ingresa la cantidad.";
        } elseif (!is_numeric($cantidad) || (float)$cantidad <= 0) {
            $mensajeError = "La cantidad ingresada no puede ser negativa ni cero.";
        } elseif (!validarFechaRegistro($fecha, $fechaActual)) {
            $mensajeError = "La fecha debe pertenecer al año 2026 y no puede ser una fecha futura.";
        } else {
            $cantidadNum = (float) $cantidad;
            $estadoInicial = "Pendiente";

            // Guardar la aportación en MySQL con consulta preparada (INSERT) relacionada al id_usuario en sesión
            $stmtInsert = mysqli_prepare(
                $conexion,
                "INSERT INTO aportaciones (id_usuario, tipo_material, cantidad_kg, fecha_recoleccion, estado) VALUES (?, ?, ?, ?, ?)"
            );
            mysqli_stmt_bind_param($stmtInsert, "isdss", $idUsuarioActual, $tipoMaterial, $cantidadNum, $fecha, $estadoInicial);

            if (mysqli_stmt_execute($stmtInsert)) {
                $materialSeguro = htmlspecialchars($tipoMaterial);
                $cantidadSegura = htmlspecialchars(number_format($cantidadNum, 2));
                $fechaSegura = htmlspecialchars($fecha);
                $mensajeExito = "Has registrado " . $cantidadSegura . " kg de " . $materialSeguro . " con fecha " . $fechaSegura . " (Estado: Pendiente de validación).";
            } else {
                $mensajeError = "Ocurrió un error al guardar tu aportación en la base de datos.";
            }
            mysqli_stmt_close($stmtInsert);
        }
    }

    // 3. Consultar mediante SELECT preparado únicamente los registros del usuario con sesión activa
    $misAportaciones = [];
    $totalKgUsuario = 0.0;

    $stmtSelect = mysqli_prepare(
        $conexion,
        "SELECT id_aportacion, tipo_material, cantidad_kg, fecha_recoleccion, estado, fecha_registro 
         FROM aportaciones 
         WHERE id_usuario = ? 
         ORDER BY fecha_recoleccion DESC, id_aportacion DESC"
    );
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

    // Reutilización de código: Se incluye el encabezado
    include 'includes/header.php';
?>

    <main>
        <section>
            <h2>Mi Contador de Reciclaje</h2>
            <p>Registra tus aportaciones y consulta el estado de validación asignado por la administración.</p>

            <!-- Uso de la función propia para imprimir alertas sin repetir HTML -->
            <?php 
                echo mostrarMensaje($mensajeError, 'error');
                echo mostrarMensaje($mensajeExito, 'exito');
            ?>

            <!-- Formulario POST para registrar aportación en MySQL -->
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
                                <th style="padding: 10px; border: 1px solid #ddd;">Cantidad (kg)</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Fecha de Recolección</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Estado de Validación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($misAportaciones as $item) { 
                                // Color distintivo según el estado actualizado por el administrador
                                $colorEstado = "#f57c00"; // Pendiente
                                if ($item['estado'] === "Validado") {
                                    $colorEstado = "#2e7d32";
                                } elseif ($item['estado'] === "Rechazado") {
                                    $colorEstado = "#c62828";
                                }
                            ?>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;">#<?php echo (int) $item['id_aportacion']; ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($item['tipo_material']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo number_format((float)$item['cantidad_kg'], 2); ?> kg</td>
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
    // Reutilización de código: Se incluye el pie de página
    include 'includes/footer.php';
?>