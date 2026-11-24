<?php
    // 0. Protección de acceso: Validar sesión activa y rol exclusivo de administrador
    require_once 'includes/auth.php';
    if (!estaLogueado()) {
        header("Location: login.php");
        exit();
    }

    if (($_SESSION["rol"] ?? "") !== "admin") {
        header("Location: index.php");
        exit();
    }

    require_once 'includes/funciones.php';

    // 1. Declaración de variables iniciales antes del HTML
    $mensajeExito = "";
    $mensajeError = "";
    $estadosPermitidos = ["Pendiente", "Validado", "Rechazado"];

    // 2. Procesar peticiones POST del administrador (UPDATE de estado o DELETE de registro)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $accion = trim($_POST["accion"] ?? "");
        $idAportacion = (int) ($_POST["id_aportacion"] ?? 0);

        if ($accion === "actualizar" && isset($_POST["nuevo_estado"])) {
            $nuevoEstado = trim($_POST["nuevo_estado"]);

            if ($idAportacion <= 0 || !in_array($nuevoEstado, $estadosPermitidos, true)) {
                $mensajeError = "Datos inválidos para actualizar el registro seleccionado.";
            } else {
                // Consulta preparada UPDATE para cambiar el estado de validación
                $stmtUpdate = mysqli_prepare($conexion, "UPDATE aportaciones SET estado = ? WHERE id_aportacion = ?");
                mysqli_stmt_bind_param($stmtUpdate, "si", $nuevoEstado, $idAportacion);

                if (mysqli_stmt_execute($stmtUpdate)) {
                    $mensajeExito = "El estado de la aportación #" . $idAportacion . " se actualizó correctamente a '" . htmlspecialchars($nuevoEstado) . "'.";
                } else {
                    $mensajeError = "Ocurrió un error al intentar actualizar el estado en la base de datos.";
                }
                mysqli_stmt_close($stmtUpdate);
            }
        } elseif ($accion === "eliminar") {
            if ($idAportacion <= 0) {
                $mensajeError = "No se pudo identificar correctamente la aportación que deseas eliminar.";
            } else {
                // Consulta preparada DELETE para eliminar permanentemente el registro seleccionado
                $stmtDelete = mysqli_prepare($conexion, "DELETE FROM aportaciones WHERE id_aportacion = ?");
                mysqli_stmt_bind_param($stmtDelete, "i", $idAportacion);

                if (mysqli_stmt_execute($stmtDelete)) {
                    if (mysqli_stmt_affected_rows($stmtDelete) > 0) {
                        $mensajeExito = "La aportación #" . $idAportacion . " fue eliminada correctamente de la base de datos.";
                    } else {
                        $mensajeError = "La aportación #" . $idAportacion . " no existe o ya había sido eliminada.";
                    }
                } else {
                    $mensajeError = "Ocurrió un error al intentar eliminar la aportación en la base de datos.";
                }
                mysqli_stmt_close($stmtDelete);
            }
        }
    }

    // 3. Recuperar todas las aportaciones uniendo usuarios, materiales y centros_acopio mediante INNER JOIN
    $listaAportaciones = [];
    $sqlConsultaGeneral = "SELECT a.id_aportacion, a.cantidad_kg, a.fecha_recoleccion, a.estado,
                                  u.id_usuario, u.nombre AS nombre_usuario, u.correo AS correo_usuario,
                                  m.nombre AS nombre_material,
                                  c.nombre AS nombre_centro, c.alcaldia
                           FROM aportaciones a
                           INNER JOIN usuarios u ON a.id_usuario = u.id_usuario
                           INNER JOIN materiales m ON a.id_material = m.id_material
                           INNER JOIN centros_acopio c ON a.id_centro = c.id_centro
                           ORDER BY a.fecha_recoleccion DESC, a.id_aportacion DESC";

    $stmtSelectAll = mysqli_prepare($conexion, $sqlConsultaGeneral);
    mysqli_stmt_execute($stmtSelectAll);
    $resultadoGeneral = mysqli_stmt_get_result($stmtSelectAll);

    while ($fila = mysqli_fetch_assoc($resultadoGeneral)) {
        $listaAportaciones[] = $fila;
    }
    mysqli_stmt_close($stmtSelectAll);

    // 4. Incluir encabezado visual
    include 'includes/header.php';
?>

   <main class="main-ancho">
        <section>
            <h2>Panel de Administración: Gestión de Aportaciones</h2>
            <p>Consulta los registros de reciclaje de todos los ciudadanos, actualiza su estado de validación o elimina registros cuando sea necesario.</p>

            <?php 
                echo mostrarMensaje($mensajeError, 'error');
                echo mostrarMensaje($mensajeExito, 'exito');
            ?>

            <?php if (count($listaAportaciones) === 0) { ?>
                <p style="padding: 15px; background-color: #fff3e0; border-left: 4px solid #E65100;">No existen aportaciones registradas en el sistema por el momento.</p>
            <?php } else { ?>
                <div class="tabla-contenedor">
                    <table class="tabla-admin">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ciudadano</th>
                                <th>Correo</th>
                                <th>Material</th>
                                <th>Centro de Acopio</th>
                                <th>Cantidad (kg)</th>
                                <th>Fecha</th>
                                <th>Estado Actual</th>
                                <th>Actualizar Estado</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listaAportaciones as $registro) { 
                                $colorEstado = "#f57c00"; // Pendiente
                                if ($registro['estado'] === "Validado") {
                                    $colorEstado = "#2e7d32";
                                } elseif ($registro['estado'] === "Rechazado") {
                                    $colorEstado = "#c62828";
                                }
                            ?>
                                <tr>
                                    <td class="col-nowrap">#<?php echo (int) $registro['id_aportacion']; ?></td>
                                    <td style="font-weight: bold;"><?php echo htmlspecialchars($registro['nombre_usuario']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['correo_usuario']); ?></td>
                                    <td class="col-nowrap"><?php echo htmlspecialchars($registro['nombre_material']); ?></td>
                                    <td><?php echo htmlspecialchars($registro['alcaldia'] . " - " . $registro['nombre_centro']); ?></td>
                                    <td class="col-nowrap"><?php echo number_format((float) $registro['cantidad_kg'], 2); ?> kg</td>
                                    <td class="col-nowrap"><?php echo htmlspecialchars($registro['fecha_recoleccion']); ?></td>
                                    <td class="col-nowrap" style="font-weight: bold; color: <?php echo $colorEstado; ?>;">
                                        <?php echo htmlspecialchars($registro['estado']); ?>
                                    </td>
                                    <td>
                                        <form action="gestion_aportaciones.php" method="POST" class="form-inline">
                                            <input type="hidden" name="accion" value="actualizar">
                                            <input type="hidden" name="id_aportacion" value="<?php echo (int) $registro['id_aportacion']; ?>">
                                            <select name="nuevo_estado">
                                                <?php foreach ($estadosPermitidos as $estadoOpcion) { ?>
                                                    <option value="<?php echo $estadoOpcion; ?>" <?php echo ($registro['estado'] === $estadoOpcion) ? 'selected' : ''; ?>>
                                                        <?php echo $estadoOpcion; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <button type="submit">Guardar</button>
                                        </form>
                                    </td>
                                    <td style="text-align: center;">
                                        <form action="gestion_aportaciones.php" method="POST" style="margin: 0;" onsubmit="return confirm('¿Seguro que deseas eliminar permanentemente la aportación #<?php echo (int) $registro['id_aportacion']; ?>?');">
                                            <input type="hidden" name="accion" value="eliminar">
                                            <input type="hidden" name="id_aportacion" value="<?php echo (int) $registro['id_aportacion']; ?>">
                                            <button type="submit" class="btn-eliminar">Eliminar</button>
                                        </form>
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