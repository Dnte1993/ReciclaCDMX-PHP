# ReciclaCDMX - Versión Final (Cierre de Fase 2)
Versión final (`1.0.0`) del portal web **ReciclaCDMX**. En esta entrega se consolida la integración completa con MySQL mediante cuatro tablas relacionadas, tres consultas con `JOIN` integradas a las vistas existentes, la eliminación segura de registros mediante `DELETE` preparado para el rol administrador y la migración de los catálogos desde arreglos PHP hacia la base de datos.

## Versión
1.0.0

## Tecnologías
- HTML5 y CSS3 (Estructura semántica, tablas de datos, paleta institucional CDMX y estilos visuales)
- PHP 8.2 (Sesiones, cookies, control de acceso por rol, consultas preparadas `INSERT`, `SELECT`, `UPDATE`, `DELETE`, consultas `JOIN` y hashing con `password_hash()` / `password_verify()`)
- MySQL / MariaDB (Base de datos relacional con cuatro tablas vinculadas mediante llaves foráneas)

## Estructura del proyecto
- `Tarea8/`
  - `css/style.css`
  - `database/recicla_cdmx.sql`
  - `img/`
  - `includes/` (`auth.php`, `conexion.php`, `footer.php`, `funciones.php`, `header.php`)
  - `centros.php`
  - `contacto.php`
  - `contador.php`
  - `detalle.php`
  - `gestion_aportaciones.php`
  - `index.php`
  - `informacion.php`
  - `login.php`
  - `logout.php`
  - `registro.php`
  - `README.md`

## Enlaces del Proyecto
- **Repositorio en GitHub:** [Ver repositorio en GitHub](https://github.com/Dnte1993/ReciclaCDMX-PHP)

## Requisitos
- Servidor local con Apache y MySQL (ej. XAMPP).
- Importación previa del archivo SQL ubicado en `database/recicla_cdmx.sql`.

## Ejecución
1. Extraer el contenido del archivo `.zip` en la carpeta pública del servidor local (ej. `C:\xampp\htdocs\`).
2. Iniciar los servicios de Apache y MySQL desde el panel de control de XAMPP.
3. Crear la base de datos `recicla_cdmx` en phpMyAdmin e importar el archivo `database/recicla_cdmx.sql`.
4. Ingresar desde el navegador a `localhost/Tarea8/index.php`.

## Usuarios de prueba en MySQL
Se incluyen cuentas de ciudadano (cada una con sus propios registros de reciclaje iniciales) y una cuenta administrativa para comprobar el aislamiento de datos por sesión y la gestión completa por rol:

| Nombre | Correo | Contraseña de prueba | Rol | Funcionalidad principal |
| :--- | :--- | :--- | :--- | :--- |
| Ciudadano | usuario@reciclacdmx.com | 12345 | registrado | Registrar aportaciones eligiendo material y centro de acopio, y consultar únicamente su propio historial (`contador.php`) |
| María López | ciudadano2@reciclacdmx.com | 12345 | registrado | Registrar aportaciones eligiendo material y centro de acopio, y consultar únicamente su propio historial (`contador.php`) |
| Administrador | admin@reciclacdmx.com | admin123 | admin | Consultar aportaciones de todos los usuarios, actualizar su estado de validación y eliminar registros (`gestion_aportaciones.php`) |

## Funcionalidades consolidadas en la versión final (1.0.0)
- **Migración completa de catálogos a MySQL (`includes/funciones.php`, `informacion.php`, `centros.php`, `contador.php`):** Los catálogos de materiales reciclables y centros de acopio dejaron de definirse en arreglos PHP y ahora se consultan dinámicamente desde las tablas `materiales` y `centros_acopio` mediante consultas preparadas.
- **Tres consultas relacionales con `JOIN`:**
  1. `gestion_aportaciones.php`: `INNER JOIN` entre `aportaciones`, `usuarios`, `materiales` y `centros_acopio` para el panel administrativo.
  2. `contador.php`: `INNER JOIN` entre `aportaciones`, `materiales` y `centros_acopio` filtrado por el usuario en sesión.
  3. `centros.php`: `LEFT JOIN` entre `centros_acopio` y `aportaciones` para mostrar el total de aportaciones activas y kilogramos reciclados por punto verde.
- **Eliminación de registros con `DELETE` (`gestion_aportaciones.php`):** El rol `admin` puede eliminar aportaciones mediante consulta preparada `DELETE`, con ventana de confirmación previa, mensajes de éxito/error y actualización inmediata de la tabla.
- **Revisión y depuración integral:** Eliminación de scripts de inicialización obsoletos en `includes/auth.php`, limpieza de etiquetas HTML duplicadas en `detalle.php`, actualización de enlaces externos en `includes/footer.php` y ajuste de validaciones frontend/backend y redirecciones por rol en `registro.php`.

## Base de datos implementada (`recicla_cdmx`)
1. **Tabla: `usuarios`**
   - **Información:** Datos de acceso, autenticación y perfil de cada persona registrada.
   - **Campos:** `id_usuario` (PK, AUTO_INCREMENT), `nombre`, `correo` (UNIQUE), `password` (hash seguro), `rol` (`registrado`, `admin`), `fecha_registro`.

2. **Tabla: `materiales`**
   - **Información:** Catálogo de materiales reciclables aceptados en la CDMX.
   - **Campos:** `id_material` (PK, AUTO_INCREMENT), `nombre` (UNIQUE), `descripcion`, `imagen`.

3. **Tabla: `centros_acopio`**
   - **Información:** Catálogo de los 12 puntos verdes distribuidos en distintas alcaldías de la CDMX.
   - **Campos:** `id_centro` (PK, AUTO_INCREMENT), `clave` (UNIQUE), `nombre`, `alcaldia`, `direccion`, `dias`, `horario`.

4. **Tabla: `aportaciones`**
   - **Información:** Historial de reciclaje registrado por cada ciudadano, vinculado al material entregado, el centro de acopio y su estado de validación administrativa.
   - **Campos:** `id_aportacion` (PK, AUTO_INCREMENT), `id_usuario` (FK hacia `usuarios.id_usuario`), `id_material` (FK hacia `materiales.id_material`), `id_centro` (FK hacia `centros_acopio.id_centro`), `cantidad_kg`, `fecha_recoleccion`, `estado` (`Pendiente`, `Validado`, `Rechazado`), `fecha_registro`.

## Historial de versiones
| Versión | Cambios principales |
|---------|---------------------|
| 1.0.0 | Cierre de Fase 2 (Tarea 8): Creación de tablas `materiales` y `centros_acopio` vinculadas con `aportaciones` (4 tablas relacionadas). Migración de catálogos fijos de PHP a MySQL. Implementación de 3 consultas `JOIN` (`gestion_aportaciones.php`, `contador.php` y `centros.php`). Incorporación de eliminación de aportaciones con `DELETE` preparado y confirmación en `gestion_aportaciones.php`. Auditoría general de validaciones, enlaces, etiquetas y documentación final. |
| 0.7.0 | Gestión de información con MySQL (Tarea 7): Creación de tabla relacional `aportaciones` con llave foránea a `usuarios`. Inserción (`INSERT`) y consulta (`SELECT`) de registros propios por usuario en `contador.php`. Creación de `gestion_aportaciones.php` exclusivo para el rol `admin` con consulta global (`INNER JOIN`) y actualización de estado (`UPDATE`) mediante consultas preparadas. |
| 0.6.0 | Integración de MySQL (Tarea 6): Creación de base de datos `recicla_cdmx` y tabla `usuarios`, módulo de conexión `mysqli`, registro público con `password_hash()`, login seguro con `password_verify()`, y respaldo SQL en `database/recicla_cdmx.sql`. |
| 0.5.1 | Refactorización de navegación por rol (Retroalimentación Tarea 5): Ocultamiento del enlace "Mi Contador" en `header.php` para visitantes y administradores (visible únicamente para el rol `registrado`). Validación de rol en `contador.php` y redirección diferenciada en `login.php`. |
| 0.5.0 | Inicio Fase 2: Integración de sistema de sesiones (`$_SESSION`), redirección de seguridad en `contador.php`, manejo de cookies (`$_COOKIE`) para recordar el correo, y renderizado de menú dinámico según rol. |
| 0.4.0 | Cierre Fase 1: Creación de carpeta `includes/` (reutilización de header y footer). Desarrollo de 4 funciones propias. Integración de sexta página (`centros.php`). Mejora en validaciones de seguridad para números y fechas. |
| 0.3.1 | Refactorización final del código: reubicación de todas las declaraciones de variables y arreglos al inicio de los archivos. |
| 0.3.0 | Implementación de formularios interactivos (GET y POST). Desarrollo de buscador y panel de registro de aportaciones. |
| 0.2.0 | Conversión de HTML a PHP. Integración de variables, arreglos, condicionales if/else y ciclos foreach. |
| 0.1.0 | Creación de la estructura base HTML5 (4 páginas), configuración de carpetas de recursos y navegación estática. |