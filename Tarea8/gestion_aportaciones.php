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

    $mensajeExito = "";
    $mensajeError = "";
    $estadosPermitidos = ["Pendiente", "Validado", "Rechazado"];

    // 1. Procesar la actualización del estado de una aportación mediante POST y consulta preparada UPDATE
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id_aportacion"], $_POST["nuevo_estado"])) {
        $idAportacion = (int) $_POST["id_aportacion"];
        $nuevoEstado = trim($_POST["nuevo_estado"]);

        if ($idAportacion <= 0 || !in_array($nuevoEstado, $estadosPermitidos, true)) {
            $mensajeError = "Datos inválidos para actualizar el registro seleccionado.";
        } else {
            // Consulta preparada con UPDATE para modificar el estado del registro identificado
            $stmtUpdate = mysqli_prepare($conexion, "UPDATE aportaciones SET estado = ? WHERE id_aportacion = ?");
            mysqli_stmt_bind_param($stmtUpdate, "si", $nuevoEstado, $idAportacion);

            if (mysqli_stmt_execute($stmtUpdate)) {
                $mensajeExito = "El estado de la aportación #" . $idAportacion . " se actualizó correctamente a '" . htmlspecialchars($nuevoEstado) . "'.";
            } else {
                $mensajeError = "Ocurrió un error al intentar actualizar el estado en la base de datos.";
            }
            mysqli_stmt_close($stmtUpdate);
        }
    }

    // 2. Recuperar mediante SELECT todas las aportaciones junto con los datos del usuario relacionado
    $listaAportaciones = [];
    $sqlConsultaGeneral = "SELECT a.id_aportacion, a.tipo_material, a.cantidad_kg, a.fecha_recoleccion, a.estado, 
                                  u.id_usuario, u.nombre AS nombre_usuario, u.correo AS correo_usuario
                           FROM aportaciones a
                           INNER JOIN usuarios u ON a.id_usuario = u.id_usuario
                           ORDER BY a.fecha_recoleccion DESC, a.id_aportacion DESC";

    $stmtSelectAll = mysqli_prepare($conexion, $sqlConsultaGeneral);
    mysqli_stmt_execute($stmtSelectAll);
    $resultadoGeneral = mysqli_stmt_get_result($stmtSelectAll);

    while ($fila = mysqli_fetch_assoc($resultadoGeneral)) {
        $listaAportaciones[] = $fila;
    }
    mysqli_stmt_close($stmtSelectAll);

    // Incluir encabezado visual
    include 'includes/header.php';
?>

    <main>
        <section>
            <h2>Panel de Administración: Gestión de Aportaciones</h2>
            <p>Consulta los registros de reciclaje de todos los ciudadanos y actualiza su estado de validación.</p>

            <?php 
                echo mostrarMensaje($mensajeError, 'error');
                echo mostrarMensaje($mensajeExito, 'exito');
            ?>

            <?php if (count($listaAportaciones) === 0) { ?>
                <p style="padding: 15px; background-color: #fff3e0; border-left: 4px solid #E65100;">No existen aportaciones registradas en el sistema por el momento.</p>
            <?php } else { ?>
                <div style="overflow-x: auto; margin-top: 20px;">
                    <table style="width: 100%; border-collapse: collapse; background-color: white;">
                        <thead>
                            <tr style="background-color: #E65100; color: white; text-align: left;">
                                <th style="padding: 10px; border: 1px solid #ddd;">ID</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Ciudadano</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Correo</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Material</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Cantidad (kg)</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Fecha</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Estado Actual</th>
                                <th style="padding: 10px; border: 1px solid #ddd;">Actualizar Estado</th>
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
                                    <td style="padding: 10px; border: 1px solid #ddd;">#<?php echo (int) $registro['id_aportacion']; ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;"><?php echo htmlspecialchars($registro['nombre_usuario']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($registro['correo_usuario']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($registro['tipo_material']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo number_format((float)$registro['cantidad_kg'], 2); ?> kg</td>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?php echo htmlspecialchars($registro['fecha_recoleccion']); ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; color: <?php echo $colorEstado; ?>;">
                                        <?php echo htmlspecialchars($registro['estado']); ?>
                                    </td>
                                    <td style="padding: 10px; border: 1px solid #ddd;">
                                        <form action="gestion_aportaciones.php" method="POST" style="display: flex; gap: 8px; align-items: center; margin: 0;">
                                            <input type="hidden" name="id_aportacion" value="<?php echo (int) $registro['id_aportacion']; ?>">
                                            <select name="nuevo_estado" style="padding: 6px; border-radius: 4px; border: 1px solid #ccc;">
                                                <?php foreach ($estadosPermitidos as $estadoOpcion) { ?>
                                                    <option value="<?php echo $estadoOpcion; ?>" <?php echo ($registro['estado'] === $estadoOpcion) ? 'selected' : ''; ?>>
                                                        <?php echo $estadoOpcion; ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                            <button type="submit" style="padding: 6px 12px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">
                                                Guardar
                                            </button>
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
    // Incluir pie de página
    include 'includes/footer.php';
?>