<?php
    // Uso de variables para el título y descripción general
    $tituloPrincipal = "Bienvenido a ReciclaCDMX";
    $mensajeBienvenida = "Plataforma para la gestión y consulta de reciclaje en la Ciudad de México. Únete a nuestra iniciativa para un futuro más limpio.";
    $esUsuarioNuevo = true; 
    
    // Arreglo con elementos sobre los beneficios o metas del portal
    $nuestrosObjetivos = [
        "Facilitar la ubicación de centros de acopio cercanos.",
        "Fomentar la cultura del reciclaje en la CDMX.",
        "Proporcionar guías claras para preparar materiales.",
        "Conectar iniciativas ciudadanas con puntos de reciclaje."
    ];

    // Reutilización de código: Se incluye el encabezado
    include 'includes/header.php';
?>

    <main>
        <section>
            <h2 style="display: flex; align-items: center; justify-content: space-between;">
                <span><?php echo $tituloPrincipal; ?></span>
                <img src="img/CDMX.jpg" alt="Reciclaje CDMX" style="height: 60px; width: auto; object-fit: contain; border-radius: 8px;">
            </h2>
            
            <p><?php echo $mensajeBienvenida; ?></p>
            <p>Al participar en este programa, ayudas a que miles de toneladas de residuos sean procesadas adecuadamente, reduciendo la contaminación urbana y fomentando una economía circular en tu alcaldía.</p>
            
            <?php if ($esUsuarioNuevo) { ?>
                <p style="background-color: #e8f5e9; padding: 10px; border-left: 4px solid #2e7d32;"><strong>¡Qué gusto tenerte aquí!</strong> Te invitamos a explorar la sección de Información para comenzar a reciclar.</p>
            <?php } else { ?>
                <p style="background-color: #e3f2fd; padding: 10px; border-left: 4px solid #1976d2;"><strong>¡Qué bueno verte de regreso!</strong> Conoce las últimas actualizaciones en nuestros centros de acopio.</p>
            <?php } ?>
        </section>

        <section>
            <h3>Nuestros Objetivos</h3>
            <ul>
                <?php foreach ($nuestrosObjetivos as $objetivo) { ?>
                    <li><?php echo $objetivo; ?></li>
                <?php } ?>
            </ul>
        </section>
    </main>

<?php
    // Reutilización de código: Se incluye el pie de página
    include 'includes/footer.php';
?>