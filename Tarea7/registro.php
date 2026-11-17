<?php
    // 1. Requerir lógica de autenticación (que ya incluye la conexión a MySQL) y funciones
    require_once 'includes/auth.php';
    require_once 'includes/funciones.php';

    // 2. Si el usuario ya tiene sesión activa, redirigirlo según su rol
    if (estaLogueado()) {
        if (($_SESSION["rol"] ?? "") === "registrado") {
            header("Location: contador.php");
        } else {
            header("Location: index.php");
        }
        exit();
    }

    $nombre = "";
    $correo = "";
    $mensajeError = "";
    $mensajeExito = "";

    // 3. Recibir y validar los datos mediante POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = trim($_POST['nombre'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validaciones básicas de campos obligatorios y formato
        if (empty($nombre) || empty($correo) || empty($password)) {
            $mensajeError = "Todos los campos son obligatorios.";
        } elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $mensajeError = "Por favor, ingresa un correo electrónico válido.";
        } elseif (strlen($password) < 5) {
            $mensajeError = "La contraseña debe tener al menos 5 caracteres.";
        } else {
            // 4. Comprobar mediante consulta preparada que el correo no esté registrado previamente
            $stmtVerificar = mysqli_prepare($conexion, "SELECT id_usuario FROM usuarios WHERE correo = ?");
            mysqli_stmt_bind_param($stmtVerificar, "s", $correo);
            mysqli_stmt_execute($stmtVerificar);
            $resultadoVerificar = mysqli_stmt_get_result($stmtVerificar);

            if (mysqli_num_rows($resultadoVerificar) > 0) {
                $mensajeError = "Este correo electrónico ya se encuentra registrado. Intenta iniciar sesión.";
            } else {
                // 5. Proteger la contraseña mediante password_hash() y PASSWORD_DEFAULT
                $passwordEncriptada = password_hash($password, PASSWORD_DEFAULT);

                // 6. Asignar el rol correspondiente (restringido a 'registrado' por seguridad)
                $rolAsignado = "registrado";

                // 7. Guardar la información en MySQL utilizando una consulta preparada
                $stmtInsertar = mysqli_prepare($conexion, "INSERT INTO usuarios (nombre, correo, password, rol) VALUES (?, ?, ?, ?)");
                mysqli_stmt_bind_param($stmtInsertar, "ssss", $nombre, $correo, $passwordEncriptada, $rolAsignado);

                if (mysqli_stmt_execute($stmtInsertar)) {
                    $mensajeExito = "Registro exitoso. ¡Ahora puedes iniciar sesión con tu cuenta!";
                    // Limpiar variables del formulario tras el éxito
                    $nombre = "";
                    $correo = "";
                } else {
                    $mensajeError = "Ocurrió un error al registrar la cuenta. Inténtalo de nuevo.";
                }
                mysqli_stmt_close($stmtInsertar);
            }
            mysqli_stmt_close($stmtVerificar);
        }
    }

    // Incluir encabezado visual
    include 'includes/header.php';
?>

    <main>
        <section style="display: flex; justify-content: center; align-items: center; min-height: 55vh;">
            <div style="background-color: #f5f5f5; padding: 30px; border-radius: 8px; border-top: 4px solid #E65100; width: 100%; max-width: 420px;">
                <h2 style="text-align: center; margin-top: 0;">Crear Cuenta</h2>
                <p style="text-align: center; font-size: 0.9em;">Regístrate como ciudadano en ReciclaCDMX</p>
                
                <?php 
                    echo mostrarMensaje($mensajeError, 'error'); 
                    echo mostrarMensaje($mensajeExito, 'exito'); 
                ?>

                <form action="registro.php" method="POST">
                    <div style="margin-bottom: 15px;">
                        <label for="nombre" style="font-weight: bold; display: block; margin-bottom: 5px;">Nombre completo:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required placeholder="Ej. Juan Pérez" style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 15px;">
                        <label for="correo" style="font-weight: bold; display: block; margin-bottom: 5px;">Correo electrónico:</label>
                        <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" required placeholder="correo@ejemplo.com" style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <div style="margin-bottom: 20px;">
                        <label for="password" style="font-weight: bold; display: block; margin-bottom: 5px;">Contraseña (mín. 5 caracteres):</label>
                        <input type="password" id="password" name="password" required style="width: 100%; padding: 8px; box-sizing: border-box;">
                    </div>

                    <button type="submit" style="padding: 10px 20px; background-color: #E65100; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%; font-weight: bold;">Registrarme</button>
                </form>

                <p style="text-align: center; margin-top: 15px; font-size: 0.9em;">
                    ¿Ya tienes cuenta? <a href="login.php" style="color: #E65100; font-weight: bold; text-decoration: none;">Inicia sesión aquí</a>
                </p>
            </div>
        </section>
    </main>

<?php
    // Incluir pie de página
    include 'includes/footer.php';
?>