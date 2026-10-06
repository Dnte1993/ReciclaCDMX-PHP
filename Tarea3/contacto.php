<?php
    // Declaración de variables y arreglos al inicio del archivo
    
    // Uso de variables para configurar la disponibilidad del servicio
    $horarioAtencion = "Lunes a Viernes de 9:00 a 18:00 hrs.";
    $centroAbierto = true; // Si se cambia a false, el mensaje de abajo cambiará
    
    // Arreglo 1: Departamentos de atención
    $departamentos = [
        "Atención ciudadana",
        "Soporte técnico de la plataforma",
        "Alianzas estratégicas para reciclaje",
        "Reporte de problemas en centros de acopio"
    ];

    // Arreglo 2: Preguntas Frecuentes (Para alargar el contenido)
    $preguntasFrecuentes = [
        "¿Tiene algún costo la recolección? - No, todos nuestros servicios en centros de acopio son gratuitos.",
        "¿Qué pasa si mi alcaldía no tiene centro fijo? - Contamos con unidades móviles. Escríbenos para conocer la ruta.",
        "¿Puedo ser voluntario? - ¡Claro! Envía un correo al departamento de Alianzas estratégicas."
    ];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReciclaCDMX - Contacto</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <h1>ReciclaCDMX</h1>
        <nav>
            <ul>
                <!-- Enlaces actualizados a .php para navegación funcional -->
                <li><a href="index.php">Inicio</a></li>
                <li><a href="informacion.php">Información</a></li>
                <li><a href="detalle.php">Detalles de Reciclaje</a></li>
                <li><a href="contador.php">Mi Contador</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Primer bloque de contenido -->
        <section>
            <!-- Título con Flexbox para alinear la imagen a la derecha -->
            <h2 style="display: flex; align-items: center; justify-content: space-between;">
                <span>Contáctanos</span>
                <img src="img/contacto.jpg" alt="Atención ciudadana ReciclaCDMX" style="height: 60px; width: auto; object-fit: contain; border-radius: 8px;">
            </h2>

            <p>¿Tienes dudas sobre algún centro de acopio o quieres sumar tu iniciativa? Comunícate con nosotros a través de los siguientes medios:</p>

            <ul>
                <li><strong>Teléfono:</strong> 55 1234 5678</li>
                <li><strong>Correo electrónico:</strong> contacto@reciclacdmx.com</li>
                <li><strong>Horario:</strong> <?php echo $horarioAtencion; ?></li>
            </ul>
            
            <?php
                // Uso de condicional if/else sin etiquetas HTML dentro de los echo
                if ($centroAbierto) { 
            ?>
                <p style='background-color: #e8f5e9; padding: 10px; border-left: 4px solid #2e7d32;'><strong>Estado:</strong> Actualmente nuestros canales de atención están abiertos y listos para apoyarte.</p>
            <?php } else { ?>
                <p style='background-color: #ffebee; padding: 10px; border-left: 4px solid #d32f2f;'><strong>Estado:</strong> En este momento nuestras oficinas están cerradas. Déjanos un correo y te responderemos el siguiente día hábil.</p>
            <?php } ?>
        </section>

        <!-- Segundo bloque de contenido -->
        <section>
            <h3>Áreas de Atención</h3>
            <p>Dependiendo de tu duda, puedes solicitar hablar con los siguientes departamentos:</p>
            <ul>
                <?php
                    // Estructura repetitiva foreach con el HTML por fuera
                    foreach ($departamentos as $depto) { 
                ?>
                    <li><?php echo $depto; ?></li>
                <?php } ?>
            </ul>
            <p>Nuestro equipo está capacitado para orientarte sobre los procesos de separación de residuos y la ubicación de los puntos verdes móviles que recorren las distintas alcaldías de la ciudad de manera programada.</p>
        </section>

        <!-- Tercer bloque de contenido extra generado con PHP -->
        <section>
            <h3>Preguntas Frecuentes</h3>
            <ul>
                <?php
                    // Estructura repetitiva foreach para el segundo arreglo
                    foreach ($preguntasFrecuentes as $faq) { 
                ?>
                    <li><?php echo $faq; ?></li>
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