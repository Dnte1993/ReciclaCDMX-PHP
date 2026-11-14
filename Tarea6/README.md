# ReciclaCDMX - Fase 2 (MySQL)
Sexta versión del portal ReciclaCDMX. En esta entrega se integra de manera definitiva una base de datos relacional en MySQL mediante `mysqli`, migrando el sistema de usuarios temporales a registros persistentes con contraseñas encriptadas y consultas preparadas.

## Versión
0.6.0

## Tecnologías
- HTML5 y CSS3 (Estructura y estilos visuales)
- PHP 8.2 (Lógica, sesiones, cookies, consultas preparadas y hashing)
- MySQL (Persistencia de datos y gestión de usuarios)

## Requisitos
- Servidor local con Apache y MySQL (ej. XAMPP).
- Importación previa del archivo SQL ubicado en la carpeta `database/`.

## Base de Datos y Estructura (`database/recicla_cdmx.sql`)
El repositorio incluye el archivo de respaldo en la ruta `database/recicla_cdmx.sql`, el cual genera la base de datos `recicla_cdmx` y la tabla `usuarios`:
- `id_usuario` (PK, Auto Increment)
- `nombre`
- `correo` (Único)
- `password` (Protegida con `password_hash`)
- `rol` (`registrado` o `admin`)
- `fecha_registro`

## Usuarios de prueba en MySQL
| Nombre | Correo | Contraseña de prueba | Rol |
| :--- | :--- | :--- | :--- |
| Ciudadano | usuario@reciclacdmx.com | 12345 | registrado |
| Administrador | admin@reciclacdmx.com | admin123 | admin |

## Funcionalidades agregadas en esta versión (0.6.0)
- **Conexión MySQLi (`includes/conexion.php`):** Enlace centralizado con el servidor de base de datos bajo codificación UTF-8.
- **Registro Seguro (`registro.php`):** Formulario público que valida entradas por POST, comprueba duplicidad de correos con consultas preparadas y almacena contraseñas utilizando `password_hash()` con `PASSWORD_DEFAULT`[cite: 20].
- **Autenticación con Base de Datos (`login.php` y `auth.php`):** Validación de credenciales mediante consultas preparadas en MySQL y verificación de hashes seguros con `password_verify()`[cite: 20], manteniendo intactas las cookies de recuerdo y el control de acceso por roles.

## Historial de versiones
| Versión | Cambios principales |
|---------|---------------------|
| 0.6.0 | Integración de MySQL: Creación de base de datos `recicla_cdmx`, módulo de conexión, registro público con `password_hash()`, login seguro con `password_verify()`, y script de exportación SQL en `database/`. |
| 0.5.1 | Refactorización de navegación por rol: Ocultamiento del enlace "Mi Contador" para visitantes y administradores. |
| 0.5.0 | Inicio Fase 2: Integración de sesiones (`$_SESSION`) y cookies (`$_COOKIE`). |
| 0.4.0 | Cierre Fase 1: Modularización con `includes/` y 6 páginas funcionales. |