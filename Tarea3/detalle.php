<?php
    // Declaración de variables y arreglos al inicio del archivo
    
    // Variables con la información principal del material
    $nombreMaterial = "Plástico PET";
    $tipoMaterial = "Tipo 1";
    $descripcion = "El PET (Tereftalato de polietileno) es uno de los plásticos más comunes, ligeros y 100% reciclables, utilizado principalmente en envases de bebidas, agua purificada y aceites.";
    $altaDemanda = true; // Variable booleana para la condición
    
    // Arreglo 1: Pasos de preparación (mínimo 4 elementos)
    $pasosPreparacion = [
        "Vacía todo el contenido líquido por completo.",
        "Enjuaga el envase ligeramente para evitar malos olores o atracción de fauna nociva.",
        "Aplástalo desde la base para que ocupe menos espacio en tu bote y en el transporte.",
        "Tápalo de nuevo con su rosca original (la tapa y el arillo también se reciclan)."
    ];

    // Arreglo 2: Beneficios agregados para enriquecer el contenido dinámico
    $beneficiosAmbientales = [
        "Un kilo de PET reciclado ahorra hasta el 84% de la energía necesaria para fabricarlo desde cero.",
        "Se reduce drásticamente la emisión de gases de efecto invernadero.",
        "El material recuperado puede transformarse en fibra textil para ropa, mochilas o nuevos envases.",
        "Disminuye la saturación de los rellenos sanitarios de la Ciudad de México."
    ];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReciclaCDMX - Detalle PET</title>
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
        <!-- Primer bloque: Detalles generales del material -->
        <section>
            <!-- Título con Flexbox para alinear la imagen a la derecha sin deformar la línea -->
            <h2 style="display: flex; align-items: center; justify-content: space-between;">
                <span>Detalle del Material: <?php echo $nombreMaterial . " (" . $tipoMaterial . ")"; ?></span>
                <img src="img/detalle.jpg" alt="Botellas de plástico PET" style="height: 60px; width: auto; object-fit: contain; border-radius: 8px;">
            </h2>

            <p><?php echo $descripcion; ?></p>
            
            <p>Reciclar este tipo de plástico es fundamental para la ciudad, ya que ayuda a ahorrar energía, agua y petróleo, disminuyendo significativamente el volumen de basura que termina en nuestros rellenos sanitarios. Además, fomenta una economía circular donde los desechos vuelven a tener valor comercial.</p>
            
            <?php
                // Uso de condicional if/else separando el HTML de las etiquetas PHP
                if ($altaDemanda) {
            ?>
                <p style="background-color: #e3f2fd; padding: 10px; border-left: 4px solid #1976D2;"><strong>¡Dato útil!</strong> Este material tiene una altísima tasa de reciclaje y es sumamente aceptado en los centros de acopio de todas las alcaldías.</p>
            <?php } else { ?>
                <p>Verifica con tu centro de acopio más cercano si reciben este tipo de plástico.</p>
            <?php } ?>
        </section>

        <!-- Segundo bloque: Instrucciones generadas dinámicamente -->
        <section>
            <h3>¿Cómo prepararlo para reciclar?</h3>
            <ol>
                <?php
                    // Estructura repetitiva foreach con el HTML por fuera
                    foreach ($pasosPreparacion as $paso) {
                ?>
                    <li><?php echo $paso; ?></li>
                <?php } ?>
            </ol>
        </section>

        <!-- Tercer bloque extra: Generado dinámicamente para ampliar la información -->
        <section>
            <h3>Beneficios de su Reciclaje</h3>
            <ul>
                <?php
                    // Segundo foreach para imprimir el nuevo arreglo
                    foreach ($beneficiosAmbientales as $beneficio) {
                ?>
                    <li><?php echo $beneficio; ?></li>
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