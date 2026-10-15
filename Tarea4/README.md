# ReciclaCDMX
Cuarta versión del portal ReciclaCDMX, que marca el Cierre de la Fase 1. En esta entrega se integran funciones propias, reutilización de código mediante `include` y una sexta página interactiva para la materia de Programación Web.

## Versión
0.4.0

## Tecnologías
- HTML5 y CSS3 (Estructura, paleta institucional CDMX y estilos visuales)
- PHP 8.2 (Lógica, formularios, modularidad y funciones personalizadas)

## Requisitos
- Un entorno de servidor local como XAMPP o Apache.
- Un navegador web actualizado.

## Ejecución
1. Extraer el contenido del archivo .zip en la carpeta pública del servidor local (ej. `C:\xampp\htdocs\`).
2. Iniciar el servicio de Apache desde el panel de control.
3. Abrir el navegador e ingresar a la ruta local (ej. `localhost/Tarea4/index.php`).
4. Navegar entre las diferentes secciones utilizando el menú principal.

## Estructura
- `includes/`: Carpeta para módulos de código reutilizable.
  - `header.php`: Encabezado y menú de navegación del sitio.
  - `footer.php`: Pie de página institucional.
  - `funciones.php`: Archivo centralizado con 4 funciones propias desarrolladas.
- `css/`: Contiene la hoja de estilos (`style.css`).
- `img/`: Carpeta para recursos gráficos (imágenes ilustrativas integradas en cada sección).
- `index.php`: Página principal con mensaje de bienvenida dinámico e imagen alineada.
- `informacion.php`: Sección con buscador dinámico de materiales (método GET), alimentado por una función de catálogo.
- `centros.php`: **(NUEVO)** Sección interactiva con catálogo de centros de acopio por alcaldía (método GET).
- `detalle.php`: Detalle de preparación de materiales generado con ciclos y beneficios agregados.
- `contador.php`: Panel de usuario para registrar aportaciones de reciclaje con validaciones de rangos y fechas.
- `contacto.php`: Sección de atención ciudadana con validación de horarios y preguntas frecuentes.
- `README.md`: Documentación actualizada de la versión.

## Funcionalidades actuales y Cumplimiento de Rúbrica
- **Reutilización de Código:** Implementación de `include` y `require_once` para separar el encabezado, el pie de página y la lógica compartida, eliminando la duplicación de HTML.
- **Funciones Propias (4 implementadas):**
  1. `validarFechaRegistro()`: Validación estricta para bloquear fechas futuras y limitar los registros al año 2026.
  2. `mostrarMensaje()`: Generación dinámica de alertas HTML estilizadas por tipo (éxito, error, aviso).
  3. `obtenerCentrosDeAcopio()`: Centralización de ubicaciones reales de puntos verdes.
  4. `obtenerCatalogoMateriales()`: Abstracción de la base de datos de materiales reciclables.
- **Validación y Seguridad Mejoradas:** Se implementó una doble barrera (frontend con HTML y backend con PHP) para evitar el registro de números negativos o cero y fechas irreales, sumado al uso previo de `htmlspecialchars()`.
- **Integración de 6 páginas:** El portal cumple con el requisito de extensión, operando como un sistema cohesionado y completamente dinámico con PHP.

## Nota de Desarrollo: Uso de Flexbox
Para mejorar la presentación visual y cumplir con las observaciones de diseño, se investigó e implementó de manera autodidacta el modelo de diseño **Flexbox de CSS**. Esto permitió:
- Alinear horizontalmente las imágenes ilustrativas junto a los encabezados principales (`<h2>`) de manera limpia y responsiva.
- Estructurar el pie de página institucional en tres columnas adaptables, logrando una distribución del espacio moderna y profesional.

## Estado
Cierre de la Fase 1 completado.

## Historial de versiones
| Versión | Cambios principales |
|---------|---------------------|
| 0.4.0 | Cierre Fase 1: Creación de carpeta `includes/` (reutilización de header y footer). Desarrollo de 4 funciones propias en `funciones.php`. Integración de sexta página (`centros.php`). Mejora en validaciones de seguridad para números y fechas. |
| 0.3.1 | Refactorización final del código: reubicación de todas las declaraciones de variables y arreglos al inicio de los archivos para mayor claridad y limpieza de etiquetas HTML dentro de los ciclos y condicionales de PHP. |
| 0.3.0 | Implementación de formularios interactivos (GET y POST). Desarrollo de buscador en el catálogo de materiales y panel de registro de aportaciones. Integración de validaciones de seguridad (`empty`, `htmlspecialchars`). |
| 0.2.0 | Conversión de HTML a PHP. Integración de variables, arreglos, condicionales if/else y ciclos foreach en las 4 páginas. Ampliación de contenido informativo. |
| 0.1.0 | Creación de la estructura base HTML5 (4 páginas), configuración de carpetas de recursos y navegación estática. |