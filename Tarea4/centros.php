<?php
    // Uso de variables para contenido dinámico
    $tituloCentros = "Centros de Acopio";
    $descripcion = "Encuentra el punto verde más cercano a tu domicilio. Recuerda llevar tus materiales limpios y separados.";
    
    // Arreglo multidimensional con las ubicaciones
    $ubicaciones = [
        "Cuauhtémoc" => "Parque México (Fines de semana de 10:00 a 16:00 hrs)",
        "Benito Juárez" => "Parque de los Venados (Lunes a Viernes de 09:00 a 17:00 hrs)",
        "Coyoacán" => "Viveros de Coyoacán (Lunes a Domingo de 08:00 a 14:00 hrs)",
        "Miguel Hidalgo" => "Bosque de Chapultepec, Segunda Sección (Sábados de 09:00 a 15:00 hrs)"
    ];

    // Reutilización de código: Se incluye el encabezado[cite: 6]
    include 'includes/header.php';
?>

    <main>
        <section>
            <h2 style="display: flex; align-items: center; justify-content: space-between;">
                <span><?php echo $tituloCentros; ?></span>
            </h2>
            <p><?php echo $descripcion; ?></p>
            
            <div style="background-color: #f5f5f5; padding: 20px; border-radius: 8px; border-top: 4px solid #E65100; margin-top: 20px;">
                <h3>Ubicaciones Activas</h3>
                <ul>
                    <?php
                        // Ciclo foreach separando HTML de PHP
                        foreach ($ubicaciones as $alcaldia => $horario) {
                    ?>
                        <li style="margin-bottom: 10px;"><strong>Alcaldía <?php echo $alcaldia; ?>:</strong> <?php echo $horario; ?></li>
                    <?php } ?>
                </ul>
            </div>
        </section>
    </main>

<?php
    // Reutilización de código: Se incluye el pie de página[cite: 6]
    include 'includes/footer.php';
?>