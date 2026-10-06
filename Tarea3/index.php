<?php
    // Uso de variables para el título y descripción general
    
    $tituloPrincipal = "Bienvenido a ReciclaCDMX";
    $mensajeBienvenida = "Plataforma para la gestión y consulta de reciclaje en la Ciudad de México. Únete a nuestra iniciativa para un futuro más limpio.";
    $esUsuarioNuevo = true; // Variable booleana para la condición inicial
    
    // Arreglo con elementos sobre los beneficios o metas del portal

    $nuestrosObjetivos = [
        "Facilitar la ubicación de centros de acopio cercanos.",
        "Fomentar la cultura del reciclaje en la CDMX.",
        "Proporcionar guías claras para preparar materiales.",
        "Conectar iniciativas ciudadanas con puntos de reciclaje."
    ];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReciclaCDMX - Inicio</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>ReciclaCDMX</h1>
        <nav>
            <ul>
                <!-- Enlaces actualizados a .php -->
                <li><a href="index.php">Inicio</a></li>
                <li><a href="informacion.php">Información</a></li>
                <li><a href="detalle.php">Detalles de Reciclaje</a></li>
                <li><a href="contador.php">Mi Contador</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Primer bloque: Bienvenida y mensaje dinámico -->
        <section>
            <h2 style="display: flex; align-items: center; justify-content: space-between;">
                <span><?php echo $tituloPrincipal; ?></span>
                <img src="img/CDMX.jpg" alt="Reciclaje CDMX" style="height: 60px; width: auto; object-fit: contain; border-radius: 8px;">
            </h2>
            
            <p><?php echo $mensajeBienvenida; ?></p>
            <p>Al participar en este programa, ayudas a que miles de toneladas de residuos sean procesadas adecuadamente, reduciendo la contaminación urbana y fomentando una economía circular en tu alcaldía.</p>
            
            <?php
                // Condicional if/else separando el HTML de las etiquetas PHP

                if ($esUsuarioNuevo) {
            ?>
                <p style="background-color: #e8f5e9; padding: 10px; border-left: 4px solid #2e7d32;"><strong>¡Qué gusto tenerte aquí!</strong> Te invitamos a explorar la sección de Información para comenzar a reciclar.</p>
            <?php } else { ?>
                <p style="background-color: #e3f2fd; padding: 10px; border-left: 4px solid #1976d2;"><strong>¡Qué bueno verte de regreso!</strong> Conoce las últimas actualizaciones en nuestros centros de acopio.</p>
            <?php } ?>
        </section>

        <!-- Segundo bloque: Lista generada con foreach -->

        <section>
            <h3>Nuestros Objetivos</h3>
            <ul>
                <?php
                    // Estructura repetitiva foreach con el HTML por fuera

                    foreach ($nuestrosObjetivos as $objetivo) {
                ?>
                    <li><?php echo $objetivo; ?></li>
                <?php } ?>
            </ul>
        </section>
    </main>

  <footer>
        <div class="footer-contenedor">
            <!-- Columna 1: Teléfonos de emergencia -->

            <div class="footer-col">
                <p>Para emergencias,<br>marca al <strong style="color: #E65100;">911</strong></p>
                <p>Dudas e información,<br>marca al <strong style="color: #E65100;">*0311</strong></p>
            </div>
            
            <!-- Columna 2: Redes Sociales -->

            <div class="footer-col">
                <strong class="titulo-naranja">Redes de la Ciudad</strong>
                <p style="font-weight: bold; font-size: 1.2rem; letter-spacing: 8px; color: #424242;">f 𝕏 📷 🎵</p>
            </div>
            
            <!-- Columna 3: Enlaces relacionados -->

            <div class="footer-col">
                <strong class="titulo-naranja">Sitios relacionados</strong>
                <p><a href="#">Agencia Digital de Innovación Pública.</a></p>
                
                <strong class="titulo-naranja">Transparencia</strong>
                <p><a href="#">Ir al portal de transparencia</a></p>
            </div>
        </div>
        
        <!-- Barra de Copyright -->

        <div class="footer-copy">
            <p>&copy; 2026 ReciclaCDMX</p>
        </div>
    </footer>
</body>

</html>