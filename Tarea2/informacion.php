<?php
    // 1. Declaracion de las variables para la seccion de informacion y colocacion al principio como se solicitio en los comentarios de la tarea 2

    $tituloInformacion = "¿Qué materiales reciclamos?";
    $descripcionBasica = "En nuestra plataforma encontrarás información sobre los principales materiales que se pueden reciclar en la CDMX y la forma correcta de acopiarlos. Búscalo en nuestro catálogo:";
    $campanaActiva = true; 
    
    $busqueda = "";
    $mensajeResultado = "";
    $materialEncontrado = null;

    // Arreglo con mínimo 4 elementos para la consulta GET (Actualización de los nombres de los materiales)

    $catalogoMateriales = [
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

    // 2. Procesamiento de busqueda con GET y la validacion de la variable con isset y empty 

    if (isset($_GET["buscar"])) {
        $busqueda = htmlspecialchars(trim($_GET["buscar"]));
        
        if (!empty($busqueda)) {

            // Validamos si el material existe como clave principal en el arreglo
            if (isset($catalogoMateriales[$busqueda])) {
                // Obtenemos los valores accediendo a sus claves internas[cite: 25]
                $materialEncontrado = $catalogoMateriales[$busqueda]["descripcion"];
                $imagenEncontrada = $catalogoMateriales[$busqueda]["imagen"];
            } else {
                $mensajeResultado = "No encontramos información para el material: " . $busqueda;
            }
        } else {
            $mensajeResultado = "Por favor, ingresa el nombre de un material para buscar.";
        }
        }
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReciclaCDMX - Información</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>ReciclaCDMX</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="informacion.php">Información</a></li>
                <li><a href="detalle.php">Detalles de Reciclaje</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

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
                    
                    <!-- Imagen dinámica inyectada desde PHP -->
                    <img src="<?php echo $imagenEncontrada; ?>" alt="<?php echo $busqueda; ?>" style="width: 150px; height: 150px; object-fit: cover; border-radius: 8px; margin: 15px 0;">
                    
                    <p style="text-align: left;"><?php echo $materialEncontrado; ?></p>
                </div>
            <?php } elseif (!empty($mensajeResultado)) { ?>
                <div style="background-color: #ffebee; padding: 15px; border-left: 5px solid #c62828; border-radius: 4px;">
                    <p style="color: #c62828; margin: 0;"><strong>Aviso:</strong> <?php echo $mensajeResultado; ?></p>
                </div>
            <?php } ?>
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

    <footer>
        <div class="footer-contenedor">
            <div class="footer-col">
                <p>Para emergencias,<br>marca al <strong style="color: #E65100;">911</strong></p>
                <p>Dudas e información,<br>marca al <strong style="color: #E65100;">*0311</strong></p>
            </div>
            
            <div class="footer-col">
                <strong class="titulo-naranja">Redes de la Ciudad</strong>
                <p style="font-weight: bold; font-size: 1.2rem; letter-spacing: 8px; color: #424242;">f 𝕏 📷 🎵</p>
            </div>
            
            <div class="footer-col">
                <strong class="titulo-naranja">Sitios relacionados</strong>
                <p><a href="#">Agencia Digital de Innovación Pública.</a></p>
                <strong class="titulo-naranja">Transparencia</strong>
                <p><a href="#">Ir al portal de transparencia</a></p>
            </div>
        </div>
        
        <div class="footer-copy">
            <p>&copy; 2026 ReciclaCDMX</p>
        </div>
    </footer>
</body>

</html>