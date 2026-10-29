<?php
    // Reutilización de código: Se incluye el archivo de funciones propias
    require_once 'includes/funciones.php';

    // Declaración de variables iniciales
    $tituloCentros = "Centros de Acopio";
    $descripcion = "Encuentra el punto verde más cercano a tu domicilio. Selecciona tu alcaldía para ver los detalles.";
    
    // Llamamos a nuestra función 3 para obtener todos los centros
    $catalogoCentros = obtenerCentrosDeAcopio();
    $centroSeleccionado = null;

    // Procesamos el formulario GET si el usuario seleccionó un centro
    if (isset($_GET["centro"])) {
        $idCentro = htmlspecialchars($_GET["centro"]);
        
        // Verificamos que el centro exista en nuestro catálogo
        if (array_key_exists($idCentro, $catalogoCentros)) {
            $centroSeleccionado = $catalogoCentros[$idCentro];
        }
    }

    // Reutilización de código: Se incluye el encabezado
    include 'includes/header.php';
?>

    <main>
        <section>
            <h2 style="display: flex; align-items: center; justify-content: space-between;">
                <span><?php echo $tituloCentros; ?></span>
            </h2>
            <p><?php echo $descripcion; ?></p>
            
            <!-- Formulario de selección con método GET -->
            <form action="centros.php" method="GET" style="margin: 20px 0; padding: 20px; background-color: #f5f5f5; border-radius: 8px; border-top: 4px solid #E65100;">
                <label for="centro" style="font-weight: bold; display: block; margin-bottom: 10px;">Selecciona un centro de acopio:</label>
                
                <select name="centro" id="centro" style="padding: 8px; width: 60%; max-width: 400px; margin-right: 10px;">
                    <option value="">-- Elige una opción --</option>
                    <?php 
                        // Ciclo para generar las opciones del select dinámicamente
                        foreach ($catalogoCentros as $llave => $datos) { 
                            // Mantenemos seleccionada la opción que eligió el usuario
                            $selected = (isset($_GET["centro"]) && $_GET["centro"] === $llave) ? "selected" : "";
                    ?>
                        <option value="<?php echo $llave; ?>" <?php echo $selected; ?>>
                            <?php echo $datos["alcaldia"] . " - " . $datos["nombre"]; ?>
                        </option>
                    <?php } ?>
                </select>
                
                <button type="submit" style="padding: 9px 20px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Ver información</button>
            </form>
            
            <!-- Mostramos la información detallada si hay un centro seleccionado -->
            <?php if ($centroSeleccionado !== null) { ?>
                <div style="background-color: #e8f5e9; padding: 20px; border-left: 5px solid #2e7d32; border-radius: 4px; margin-top: 20px;">
                    <h3 style="color: #2e7d32; margin-top: 0; border-bottom: 1px solid #c8e6c9; padding-bottom: 10px;">
                        📍 <?php echo $centroSeleccionado["nombre"]; ?>
                    </h3>
                    
                    <ul style="list-style-type: none; padding: 0; margin-top: 15px;">
                        <li style="margin-bottom: 10px;"><strong>Alcaldía:</strong> <?php echo $centroSeleccionado["alcaldia"]; ?></li>
                        <li style="margin-bottom: 10px;"><strong>Dirección:</strong> <?php echo $centroSeleccionado["direccion"]; ?></li>
                        <li style="margin-bottom: 10px;"><strong>Días de atención:</strong> <?php echo $centroSeleccionado["dias"]; ?></li>
                        <li style="margin-bottom: 10px;"><strong>Horario:</strong> <?php echo $centroSeleccionado["horario"]; ?></li>
                    </ul>
                </div>
            <?php } elseif (isset($_GET["centro"]) && empty($_GET["centro"])) {
                // Usamos nuestra función de mensajes si le da a buscar sin seleccionar nada
                echo mostrarMensaje("Por favor selecciona un centro de la lista antes de consultar.", "error");
            } ?>
            
        </section>
    </main>

<?php
    // Reutilización de código: Se incluye el pie de página
    include 'includes/footer.php';
?>