<?php
    // 1. Incluir conexión a MySQL y funciones propias
    require_once 'includes/conexion.php';
    require_once 'includes/funciones.php';

    // 2. Declaración de variables iniciales antes del HTML
    $tituloInformacion = "¿Qué materiales reciclamos?";
    $descripcionBasica = "En nuestra plataforma encontrarás información sobre los principales materiales que se pueden reciclar en la CDMX y la forma correcta de acopiarlos. Búscalo en nuestro catálogo:";
    $campanaActiva = true;

    $busqueda = "";
    $mensajeResultado = "";
    $materialEncontrado = null;

    // Cargar el catálogo completo de materiales desde MySQL
    $catalogoMateriales = obtenerCatalogoMateriales($conexion);

    // 3. Procesamiento de búsqueda con GET mediante consulta preparada en MySQL
    if (isset($_GET["buscar"])) {
        $busqueda = trim($_GET["buscar"]);

        if (!empty($busqueda)) {
            $sqlBuscar = "SELECT id_material, nombre, descripcion, imagen
                          FROM materiales
                          WHERE nombre = ?
                          LIMIT 1";

            $stmtBuscar = mysqli_prepare($conexion, $sqlBuscar);
            mysqli_stmt_bind_param($stmtBuscar, "s", $busqueda);
            mysqli_stmt_execute($stmtBuscar);
            $resultadoBuscar = mysqli_stmt_get_result($stmtBuscar);

            if ($filaMaterial = mysqli_fetch_assoc($resultadoBuscar)) {
                $materialEncontrado = $filaMaterial;
            } else {
                $mensajeResultado = "No encontramos información para el material: " . htmlspecialchars($busqueda);
            }
            mysqli_stmt_close($stmtBuscar);
        } else {
            $mensajeResultado = "Por favor, ingresa el nombre de un material para buscar.";
        }
    }

    // 4. Incluir encabezado
    include 'includes/header.php';
?>

    <main>
        <!-- Primer bloque: Presentación y Buscador GET -->
        <section>
            <h2 style="display: flex; align-items: center; justify-content: space-between;">
                <span><?php echo htmlspecialchars($tituloInformacion); ?></span>
                <img src="img/informacion.jpg" alt="Materiales reciclables CDMX" style="height: 60px; width: auto; object-fit: contain; border-radius: 8px;">
            </h2>

            <p><?php echo htmlspecialchars($descripcionBasica); ?></p>
            
            <!-- Formulario HTML con método GET -->
            <form action="informacion.php" method="GET" style="margin: 20px 0; padding: 15px; background-color: #f5f5f5; border-radius: 8px; border-left: 4px solid #E65100;">
                <label for="buscar" style="font-weight: bold;">Buscar material (Ej. PET, Cartón, Vidrio, Aluminio):</label><br><br>
                <input type="text" id="buscar" name="buscar" value="<?php echo htmlspecialchars($busqueda); ?>" placeholder="Ingresa el material..." style="padding: 8px; width: 60%; max-width: 300px;">
                <button type="submit" style="padding: 8px 15px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
            </form>
        </section>

        <!-- Segundo bloque: Resultados de la búsqueda -->
        <section>
            <?php if ($materialEncontrado !== null) { ?>
                <div style="background-color: #e8f5e9; padding: 15px; border-left: 5px solid #2e7d32; border-radius: 4px; text-align: center;">
                    <h3 style="color: #2e7d32; margin-top: 0;">Resultado encontrado para: <?php echo htmlspecialchars($materialEncontrado["nombre"]); ?></h3>
                    <img src="<?php echo htmlspecialchars($materialEncontrado["imagen"]); ?>" alt="<?php echo htmlspecialchars($materialEncontrado["nombre"]); ?>" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; margin: 15px 0;">
                    <p style="text-align: left;"><?php echo htmlspecialchars($materialEncontrado["descripcion"]); ?></p>
                </div>
            <?php } else { 
                echo mostrarMensaje($mensajeResultado, 'error');
            } ?>
        </section>

        <!-- Tercer bloque: Lista dinámica e Impacto Ambiental -->
        <section>
            <h3>Catálogo Completo</h3>
            <ul>
                <?php foreach ($catalogoMateriales as $material) { ?>
                    <li><strong><?php echo htmlspecialchars($material["nombre"]); ?></strong></li>
                <?php } ?>
            </ul>

            <h3 style="margin-top: 30px;">Impacto Ambiental</h3>
            <p>Separar correctamente tus residuos ayuda a reducir la contaminación y facilita el trabajo en los centros de acopio.</p>
            <p>La Ciudad de México genera miles de toneladas de residuos diariamente. Al utilizar los centros de acopio autorizados, garantizas que estos materiales sean reincorporados a la cadena productiva, reduciendo la extracción de materias primas vírgenes y disminuyendo la huella de carbono de nuestra ciudad.</p>
            
            <?php if ($campanaActiva) { ?>
                <p style="background-color: #fff3e0; padding: 10px; border-left: 4px solid #d84315; color: #d84315;"><strong>¡Aviso!</strong> Este mes tenemos campaña especial de recolección de Vidrio. Llévalo a tu centro más cercano.</p>
            <?php } else { ?>
                <p>Recuerda limpiar y aplastar tus envases antes de entregarlos.</p>
            <?php } ?>
        </section>
    </main>

<?php
    // 5. Incluir pie de página
    include 'includes/footer.php';
?>