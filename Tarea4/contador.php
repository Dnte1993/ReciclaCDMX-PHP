<?php
    // 1. Declaración de variables
    
    $tipoMaterial = "";
    $cantidad = "";
    $fecha = "";
    $mensajeExito = "";
    $mensajeError = "";

    // 2. Recepción y validación de datos con POST[cite: 46]

    if (isset($_POST["material"])) {
        
        $tipoMaterial = $_POST["material"];
        $cantidad = $_POST["cantidad"];
        $fecha = $_POST["fecha"];

        // Si el usuario no elige fecha, usamos date() para asignar la fecha actual[cite: 64]
        if (empty($fecha)) {
            $fecha = date("Y-m-d");
        }

        // Validación: verificamos que material y cantidad no estén vacíos[cite: 8]
        if (empty($tipoMaterial) || empty($cantidad)) {
            $mensajeError = "Por favor, selecciona un material e ingresa la cantidad.";
        } else {
            // Manejo seguro con htmlspecialchars()[cite: 53]
            $materialSeguro = htmlspecialchars($tipoMaterial);
            $cantidadSegura = htmlspecialchars($cantidad);
            $fechaSegura = htmlspecialchars($fecha);

            // Mensaje de éxito dinámico concatenado
            $mensajeExito = "¡Registro exitoso! Has sumado " . $cantidadSegura . " kg de " . $materialSeguro . " a tu contador personal el día " . $fechaSegura . ".";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReciclaCDMX - Mi Contador</title>
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
                 <!-- Enlace al nuevo dashboard -->
                <li><a href="contador.php">Mi Contador</a></li>
                <li><a href="contacto.php">Contacto</a></li>
               
          
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Mi Contador de Reciclaje</h2>
            <p>Registra tus aportaciones. Cada gramo cuenta para una ciudad más limpia.</p>

            <!-- Mensajes dinámicos -->
            <?php if (!empty($mensajeError)) { ?>
                <div style="background-color: #ffebee; padding: 15px; border-left: 5px solid #c62828; border-radius: 4px; margin-bottom: 20px;">
                    <p style="color: #c62828; margin: 0;"><strong>Error:</strong> <?php echo $mensajeError; ?></p>
                </div>
            <?php } elseif (!empty($mensajeExito)) { ?>
                <div style="background-color: #e8f5e9; padding: 15px; border-left: 5px solid #2e7d32; border-radius: 4px; margin-bottom: 20px;">
                    <p style="color: #2e7d32; margin: 0;"><?php echo $mensajeExito; ?></p>
                </div>
            <?php } ?>

            <!-- Formulario POST que no muestra los datos en la URL -->

            <form action="contador.php" method="POST" style="margin: 20px 0; padding: 20px; background-color: #f5f5f5; border-radius: 8px; max-width: 500px; border-top: 4px solid #E65100;">
                
                <div style="margin-bottom: 15px;">
                    <label for="material" style="font-weight: bold; display: block; margin-bottom: 5px;">Tipo de Material:</label>
                    <select id="material" name="material" style="width: 100%; padding: 8px; box-sizing: border-box;">
                        <option value="">Selecciona una opción</option>
                        <option value="PET">PET</option>
                        <option value="Cartón">Cartón</option>
                        <option value="Vidrio">Vidrio</option>
                        <option value="Aluminio">Aluminio</option>
                        <option value="Pilas">Pilas</option>
                        <option value="Electrónicos">Electrónicos</option>
                        <option value="Aceite">Aceite</option>
                        <option value="Ropa">Ropa</option>
                        <option value="Tetrapak">Tetrapak</option>

                    </select>
                </div>

                <div style="margin-bottom: 15px;">
                    <label for="cantidad" style="font-weight: bold; display: block; margin-bottom: 5px;">Cantidad ingresada (kg):</label>
                    <!-- El step="0.01" permite decimales como 10.50 -->
                    <input type="number" id="cantidad" name="cantidad" step="0.01" placeholder="Ej. 10.50" style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 20px;">
                    <label for="fecha" style="font-weight: bold; display: block; margin-bottom: 5px;">Fecha de recolección:</label>
                    <input type="date" id="fecha" name="fecha" style="width: 100%; padding: 8px; box-sizing: border-box;">
                </div>

                <button type="submit" style="padding: 10px 20px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold;">Registrar Material</button>
            </form>
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