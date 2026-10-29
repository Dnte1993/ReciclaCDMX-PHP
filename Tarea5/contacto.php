<?php
    // Reutilización de código: Se incluye el archivo de funciones propias
    require_once 'includes/funciones.php';

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

    // Arreglo 2: Preguntas Frecuentes
    $preguntasFrecuentes = [
        "¿Tiene algún costo la recolección? - No, todos nuestros servicios en centros de acopio son gratuitos.",
        "¿Qué pasa si mi alcaldía no tiene centro fijo? - Contamos con unidades móviles. Escríbenos para conocer la ruta.",
        "¿Puedo ser voluntario? - ¡Claro! Envía un correo al departamento de Alianzas estratégicas."
    ];

    // Reutilización de código: Se incluye el encabezado
    include 'includes/header.php';
?>

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
                // Uso de la función propia para imprimir alertas sin repetir HTML
                if ($centroAbierto) { 
                    echo mostrarMensaje("Actualmente nuestros canales de atención están abiertos y listos para apoyarte.", "exito");
                } else {
                    echo mostrarMensaje("En este momento nuestras oficinas están cerradas. Déjanos un correo y te responderemos el siguiente día hábil.", "error");
                }
            ?>
        </section>

        <!-- Segundo bloque de contenido -->
        <section>
            <h3>Áreas de Atención</h3>
            <p>Dependiendo de tu duda, puedes solicitar hablar con los siguientes departamentos:</p>
            <ul>
                <?php
                    // Estructura repetitiva foreach
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

<?php
    // Reutilización de código: Se incluye el pie de página
    include 'includes/footer.php';
?>