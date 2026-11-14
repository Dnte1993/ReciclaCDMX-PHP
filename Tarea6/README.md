# ReciclaCDMX - Fase 2
Quinta versión del portal ReciclaCDMX, que marca el inicio de la Fase 2. En esta entrega se integran el manejo de cookies, el control de acceso mediante sesiones en PHP y la navegación dinámica según el perfil del usuario.

## Versión
0.5.1

## Tecnologías
- HTML5 y CSS3 (Estructura, paleta institucional CDMX y estilos visuales)
- PHP 8.2 (Lógica, formularios, modularidad, funciones, cookies y sesiones)

## Requisitos
- Un entorno de servidor local como XAMPP o Apache.
- Un navegador web actualizado.

## Ejecución
1. Extraer el contenido del archivo .zip en la carpeta pública del servidor local (ej. `C:\xampp\htdocs\`).
2. Iniciar el servicio de Apache desde el panel de control.
3. Abrir el navegador e ingresar a la ruta local (ej. `localhost/Tarea5/index.php`).
4. Para probar la zona protegida, inicia sesión en "Iniciar Sesión" con el perfil de ciudadano (`registrado`) para habilitar la opción "Mi Contador" en el menú, o intenta acceder a `contador.php` sin sesión o con rol `admin` para observar la redirección de seguridad.

## Usuarios de prueba (Simulación temporal en PHP)
| Usuario o Correo | Contraseña de prueba | Rol |
| :--- | :--- | :--- |
| usuario@reciclacdmx.com | 12345 | registrado (Ciudadano) |
| admin@reciclacdmx.com | admin123 | admin (Administrador) |

## Funcionalidades agregadas en esta versión (0.5.0 / 0.5.1)
- **Motor de Autenticación (`auth.php`):** Archivo centralizado que maneja el arreglo simulado de usuarios y valida las credenciales, utilizando `session_start()`.
- **Manejo de Cookies (`login.php`):** Formulario que permite al usuario marcar la casilla "Recordar mi correo", utilizando `setcookie()` para almacenar el dato por 30 días, recuperarlo mediante `$_COOKIE` en futuras visitas, o eliminarlo si desmarca la opción. Asimismo, redirige dinámicamente tras el inicio de sesión según el rol (`contador.php` para `registrado` e `index.php` para `admin`).
- **Control de Acceso por Rol (`$_SESSION`):** La página "Mi Contador" (`contador.php`) está estrictamente protegida por sesión y rol. Si un visitante intenta acceder, es redirigido al Login; si accede un rol distinto a `registrado` (como `admin`), es redirigido a `index.php`.
- **Navegación Dinámica y Visibilidad por Rol (`header.php`):** La barra superior detecta el estado de la sesión mostrando "Iniciar Sesión" a los visitantes o los datos del usuario y "Cerrar Sesión" (`logout.php`) al autenticarse. Además, el enlace a **Mi Contador** en el menú principal permanece oculto por defecto y se renderiza exclusivamente cuando existe una sesión activa con el rol `registrado`.

## Base de datos propuesta (Preparación Fase 2)
Para la futura migración a un entorno con persistencia de datos (MySQL), se proponen las siguientes 3 tablas iniciales:

1. **Tabla: `usuarios`**
   - **Información:** Datos de acceso, autenticación y perfil de cada persona registrada.
   - **Campos principales:** `id_usuario` (PK), `nombre`, `correo`, `password` (encriptada), `rol`, `fecha_registro`.

2. **Tabla: `centros_acopio`**
   - **Información:** El catálogo de los puntos verdes distribuidos en la CDMX para mostrarlos dinámicamente sin depender de arreglos estáticos en el código.
   - **Campos principales:** `id_centro` (PK), `nombre`, `alcaldia`, `direccion`, `dias_atencion`, `horario`.

3. **Tabla: `aportaciones`**
   - **Información:** El historial del peso y tipo de basura que cada ciudadano recicla, permitiendo estadísticas personales.
   - **Campos principales:** `id_aportacion` (PK), `usuario_id` (FK conectada a usuarios), `tipo_material`, `cantidad_kg`, `fecha_recoleccion`.

## Historial de versiones
| Versión | Cambios principales |
|---------|---------------------|
| 0.5.1 | Refactorización de navegación por rol (Retroalimentación Tarea 5): Ocultamiento del enlace "Mi Contador" en `header.php` para visitantes y administradores (visible únicamente para el rol `registrado`). Validación de rol en `contador.php` y redirección diferenciada en `login.php`. |
| 0.5.0 | Inicio Fase 2: Integración de sistema de sesiones (`$_SESSION`), redirección de seguridad en `contador.php`, manejo de cookies (`$_COOKIE`) para recordar el correo, y renderizado de menú dinámico según rol. |
| 0.4.0 | Cierre Fase 1: Creación de carpeta `includes/` (reutilización de header y footer). Desarrollo de 4 funciones propias. Integración de sexta página (`centros.php`). Mejora en validaciones de seguridad para números y fechas. |
| 0.3.1 | Refactorización final del código: reubicación de todas las declaraciones de variables y arreglos al inicio de los archivos. |
| 0.3.0 | Implementación de formularios interactivos (GET y POST). Desarrollo de buscador y panel de registro de aportaciones. |
| 0.2.0 | Conversión de HTML a PHP. Integración de variables, arreglos, condicionales if/else y ciclos foreach. |
| 0.1.0 | Creación de la estructura base HTML5 (4 páginas), configuración de carpetas de recursos y navegación estática. |