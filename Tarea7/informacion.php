<?php
    // Reutilización de código: Se incluye el archivo de funciones propias
    require_once 'includes/funciones.php';

    // 1. Declaracion de las variables para la seccion de informacion
    $tituloInformacion = "¿Qué materiales reciclamos?";
    $descripcionBasica = "En nuestra plataforma encontrarás información sobre los principales materiales que se pueden reciclar en la CDMX y la forma correcta de acopiarlos. Búscalo en nuestro catálogo:";
    $campanaActiva = true; 
    
    $busqueda = "";
    $mensajeResultado = "";
    $materialEncontrado = null;
    $imagenEncontrada = "";

    // Invocamos la Función 4 para cargar el arreglo desde el archivo centralizado
    $catalogoMateriales = obtenerCatalogoMateriales();

    // 2. Procesamiento de busqueda con GET
    if (isset($_GET["buscar"])) {
        $busqueda = htmlspecialchars(trim($_GET["buscar"]));
        
        if (!empty($busqueda)) {
            // Validamos si el material existe como clave principal en el arreglo
            if (isset($catalogoMateriales[$busqueda])) {
                $materialEncontrado = $catalogoMateriales[$busqueda]["descripcion"];
                $imagenEncontrada = $catalogoMateriales[$busqueda]["imagen"];
            } else {
                $mensajeResultado = "No encontramos información para el material: " . $busqueda;
            }
        } else {
            $mensajeResultado = "Por favor, ingresa el nombre de un material para buscar.";
        }
    }

    // Reutilización de código: Se incluye el encabezado
    include 'includes/header.php';
?>

    <main>
        <!-- Primer bloque: Presentación y Buscador GET -->
        <section>
            <h2 style="display: flex; align-items: center; justify-content: space-between;">
                <span><?php echo $tituloInformacion; ?></span>
                <img src="img/informacion.jpg" alt="Materiales reciclables CDMX" style="height: 60px; width: auto; object-fit: contain; border-radius: 8px;">
            </h2>

            <p><?php echo $descripcionBasica; ?></p>
            
            <!-- Formulario HTML con método GET -->
            <form action="informacion.php" method="GET" style="margin: 20px 0; padding: 15px; background-color: #f5f5f5; border-radius: 8px; border-left: 4px solid #E65100;">
                <label for="buscar" style="font-weight: bold;">Buscar material (Escribe correctamente como esta en el catalogo):</label><br><br>
                <input type="text" id="buscar" name="buscar" value="<?php echo $busqueda; ?>" placeholder="Ingresa el material..." style="padding: 8px; width: 60%; max-width: 300px;">
                <button type="submit" style="padding: 8px 15px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer;">Buscar</button>
            </form>
        </section>

        <!-- Segundo bloque: Resultados de la búsqueda -->
        <section>
            <?php if ($materialEncontrado !== null) { ?>
                <div style="background-color: #e8f5e9; padding: 15px; border-left: 5px solid #2e7d32; border-radius: 4px; text-align: center;">
                    <h3 style="color: #2e7d32; margin-top: 0;">Resultado encontrado para: <?php echo $busqueda; ?></h3>
                    <img src="<?php echo $imagenEncontrada; ?>" alt="<?php echo $busqueda; ?>" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; margin: 15px 0;">
                    <p style="text-align: left;"><?php echo $materialEncontrado; ?></p>
                </div>
            <?php } else { 
                // Uso de la función propia para imprimir alertas
                echo mostrarMensaje($mensajeResultado, 'error');
            } ?>
        </section>

        <!-- Tercer bloque: Lista dinámica e Impacto Ambiental -->
        <section>
            <h3>Catálogo Completo</h3>
            <ul>
                <?php foreach ($catalogoMateriales as $nombre => $datos) { ?>
                    <li><strong><?php echo $nombre; ?></strong></li>
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
    // Reutilización de código: Se incluye el pie de página
    include 'includes/footer.php';
?>