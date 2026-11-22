# ReciclaCDMX - Fase 2 (Gestión de Información con MySQL)
Séptima versión del portal ReciclaCDMX. En esta entrega se integra el manejo completo de información relacional en MySQL diferenciando las capacidades operativas según el rol: registro y consulta de aportaciones propias para el ciudadano (`registrado`), y panel de supervisión global con actualización de estado de validación para el administrador (`admin`).

## Versión
0.7.0

## Tecnologías
- HTML5 y CSS3 (Estructura, tablas de datos, paleta institucional CDMX y estilos visuales)
- PHP 8.2 (Lógica, sesiones, cookies, control de acceso por rol, consultas preparadas `INSERT`, `SELECT`, `UPDATE` y hashing)
- MySQL / MariaDB (Persistencia relacional entre `usuarios` y `aportaciones`)

## Enlaces del Proyecto
- **Repositorio en GitHub:** [Ver repositorio en GitHub](https://github.com/d2wars/ProgramacionWeb)

## Requisitos
- Servidor local con Apache y MySQL (ej. XAMPP).
- Importación previa del archivo SQL ubicado en `database/recicla_cdmx.sql`.

## Ejecución
1. Extraer el contenido del archivo `.zip` en la carpeta pública del servidor local (ej. `C:\xampp\htdocs\`).
2. Iniciar los servicios de Apache y MySQL desde el panel de control de XAMPP.
3. Importar el archivo `database/recicla_cdmx.sql` desde phpMyAdmin (o abrir directamente `login.php`, el cual verifica e inicializa automáticamente las tablas y los datos de prueba).
4. Ingresar desde el navegador a `localhost/Tarea7/index.php`.

## Usuarios de prueba en MySQL
Se incluyen dos cuentas de ciudadano distintas (cada una con sus propios registros de reciclaje iniciales) y una cuenta administrativa para comprobar el aislamiento de datos por sesión y la gestión por rol:

| Nombre | Correo | Contraseña de prueba | Rol | Funcionalidad principal |
| :--- | :--- | :--- | :--- | :--- |
| Ciudadano Uno | usuario@reciclacdmx.com | 12345 | registrado | Registrar aportaciones y consultar únicamente su propio historial (`contador.php`) |
| María López | ciudadano2@reciclacdmx.com | 12345 | registrado | Registrar aportaciones y consultar únicamente su propio historial (`contador.php`) |
| Administrador | admin@reciclacdmx.com | admin123 | admin | Consultar aportaciones de todos los usuarios y actualizar su estado (`gestion_aportaciones.php`) |

## Funcionalidades agregadas en esta versión (0.7.0)
- **Estructura Relacional (`aportaciones`):** Creación de la tabla `aportaciones` vinculada mediante llave foránea (`id_usuario`) a la tabla `usuarios`, incorporando el campo `estado` (`Pendiente`, `Validado`, `Rechazado`) para el seguimiento administrativo.
- **Registro y Consulta del Ciudadano (`contador.php`):** Almacenamiento de nuevas aportaciones mediante consulta preparada `INSERT` asociada al `id_usuario` en sesión, y tabla inferior con consulta preparada `SELECT` que filtra y muestra exclusivamente los registros propios del usuario activo junto con el estado asignado por el administrador.
- **Panel de Gestión del Administrador (`gestion_aportaciones.php`):** Apartado exclusivo para el rol `admin` que recupera mediante `SELECT ... INNER JOIN` todas las aportaciones registradas identificando al ciudadano (nombre y correo), permitiendo modificar el estado de validación de cada registro mediante una consulta preparada con `UPDATE`.
- **Navegación Diferenciada por Rol (`header.php` y `login.php`):** El menú superior y las redirecciones de acceso distinguen entre visitante (muestra `Registro`), ciudadano `registrado` (muestra `Mi Contador`) y `admin` (muestra `Gestión de Aportaciones`).

## Base de datos implementada (`recicla_cdmx`)
1. **Tabla: `usuarios` (Implementada en Tarea 6)**
   - **Información:** Datos de acceso, autenticación y perfil de cada persona registrada.
   - **Campos:** `id_usuario` (PK, AUTO_INCREMENT), `nombre`, `correo` (UNIQUE), `password` (hash seguro), `rol` (`registrado`, `admin`), `fecha_registro`.

2. **Tabla: `aportaciones` (Implementada en Tarea 7)**
   - **Información:** Historial de reciclaje registrado por cada ciudadano y su estado de validación administrativa.
   - **Campos:** `id_aportacion` (PK, AUTO_INCREMENT), `id_usuario` (FK hacia `usuarios.id_usuario`), `tipo_material`, `cantidad_kg`, `fecha_recoleccion`, `estado` (`Pendiente`, `Validado`, `Rechazado`), `fecha_registro`.

3. **Tabla: `centros_acopio` (Propuesta complementaria)**
   - **Información:** Catálogo de los puntos verdes distribuidos en la CDMX.

## Historial de versiones
| Versión | Cambios principales |
|---------|---------------------|
| 0.7.0 | Gestión de información con MySQL (Tarea 7): Creación de tabla relacional `aportaciones` con llave foránea a `usuarios`. Inserción (`INSERT`) y consulta (`SELECT`) de registros propios por usuario en `contador.php`. Creación de `gestion_aportaciones.php` exclusivo para el rol `admin` con consulta global (`INNER JOIN`) y actualización de estado (`UPDATE`) mediante consultas preparadas. |
| 0.6.0 | Integración de MySQL (Tarea 6): Creación de base de datos `recicla_cdmx` y tabla `usuarios`, módulo de conexión `mysqli`, registro público con `password_hash()`, login seguro con `password_verify()`, y respaldo SQL en `database/recicla_cdmx.sql`. |
| 0.5.1 | Refactorización de navegación por rol (Retroalimentación Tarea 5): Ocultamiento del enlace "Mi Contador" en `header.php` para visitantes y administradores (visible únicamente para el rol `registrado`). Validación de rol en `contador.php` y redirección diferenciada en `login.php`. |
| 0.5.0 | Inicio Fase 2: Integración de sistema de sesiones (`$_SESSION`), redirección de seguridad en `contador.php`, manejo de cookies (`$_COOKIE`) para recordar el correo, y renderizado de menú dinámico según rol. |
| 0.4.0 | Cierre Fase 1: Creación de carpeta `includes/` (reutilización de header y footer). Desarrollo de 4 funciones propias. Integración de sexta página (`centros.php`). Mejora en validaciones de seguridad para números y fechas. |
| 0.3.1 | Refactorización final del código: reubicación de todas las declaraciones de variables y arreglos al inicio de los archivos. |
| 0.3.0 | Implementación de formularios interactivos (GET y POST). Desarrollo de buscador y panel de registro de aportaciones. |
| 0.2.0 | Conversión de HTML a PHP. Integración de variables, arreglos, condicionales if/else y ciclos foreach. |
| 0.1.0 | Creación de la estructura base HTML5 (4 páginas), configuración de carpetas de recursos y navegación estática. |