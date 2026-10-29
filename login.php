<?php
    // 1. Requerir lógica de autenticación y funciones al inicio
    require_once 'includes/auth.php';
    require_once 'includes/funciones.php';

    // 2. Proteger la página: Si ya está logueado, lo mandamos al contador[cite: 42]
    if (estaLogueado()) {
        header("Location: contador.php");
        exit();
    }

    $mensajeError = "";
    $correoGuardado = "";

    // 3. RECUPERAR COOKIE: Si existe, llenamos la variable para ponerla en el formulario[cite: 41]
    if (isset($_COOKIE['correo_recordado'])) {
        $correoGuardado = $_COOKIE['correo_recordado'];
    }

    // 4. Procesar el formulario cuando se envía por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $correo = htmlspecialchars(trim($_POST['correo']));
        $password = $_POST['password'];
        $recordarme = isset($_POST['recordarme']); // Verifica si el checkbox fue marcado

        $usuarios = obtenerUsuarios();

        // 5. Validar credenciales contra nuestro arreglo temporal[cite: 42]
        if (isset($usuarios[$correo]) && $usuarios[$correo]['password'] === $password) {
            
            // Credenciales correctas: CREAR SESIÓN[cite: 42]
            $_SESSION['usuario'] = $correo;
            $_SESSION['nombre'] = $usuarios[$correo]['nombre'];
            $_SESSION['rol'] = $usuarios[$correo]['rol'];

            // 6. MANEJO DE COOKIES (Guardar o Eliminar)[cite: 41]
            if ($recordarme) {
                // Crear cookie por 30 días
                setcookie("correo_recordado", $correo, time() + (86400 * 30), "/");
            } else {
                // Eliminar cookie restando tiempo
                setcookie("correo_recordado", "", time() - 3600, "/");
            }

            // Redirigir a la zona protegida[cite: 42]
            header("Location: contador.php");
            exit();
        } else {
            $mensajeError = "Correo o contraseña incorrectos.";
        }
    }

    // Incluir encabezado visual
    include 'includes/header.php';
?>

    <main>
        <section style="display: flex; justify-content: center; align-items: center; min-height: 50vh;">
            <div style="background-color: #f5f5f5; padding: 30px; border-radius: 8px; border-top: 4px solid #E65100; width: 100%; max-width: 400px;">
                <h2 style="text-align: center; margin-top: 0;">Iniciar Sesión</h2>
                <p style="text-align: center; font-size: 0.9em;">Accede para registrar tus aportaciones</p>
                
                <?php echo mostrarMensaje($mensajeError, 'error'); ?>

                <form action="login.php" method="POST">
                    <div style="margin-bottom: 15px;">
                        <label for="correo" style="font-weight: bold; display: block; margin-bottom: 5px;">Correo electrónico:</label>
                        <!-- Se imprime el correo de la cookie si existe[cite: 41] -->
                        <input type="email" id="correo" name="correo" value="<?php echo $correoGuardado; ?>" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="password" style="font-weight: bold; display: block; margin-bottom: 5px;">Contraseña:</label>
                        <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 20px; display: flex; align-items: center;">
                        <!-- Checkbox marcado por defecto si la cookie ya existe[cite: 41] -->
                        <input type="checkbox" id="recordarme" name="recordarme" <?php echo !empty($correoGuardado) ? 'checked' : ''; ?> style="margin-right: 10px;">
                        <label for="recordarme">Recordar mi correo en este equipo</label>
                    </div>

                    <button type="submit" style="padding: 10px 20px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold;">Ingresar</button>
                </form>
            </div>
        </section>
    </main>

<?php
    // Incluir pie de página
    include 'includes/footer.php';
?>