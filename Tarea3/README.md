# ReciclaCDMX
Tercera versión del portal ReciclaCDMX, integrando formularios, validación de datos y manejo seguro de la información con PHP para la materia de Programación Web.

## Versión
0.3.0

## Tecnologías
* HTML5 y CSS3 (Estructura, paleta institucional CDMX y estilos visuales)
* PHP 8.2 (Lógica, formularios y contenido dinámico)

## Requisitos
* Un entorno de servidor local como XAMPP o Apache.
* Un navegador web actualizado.

## Ejecución
1. Extraer el contenido del archivo .zip en la carpeta pública del servidor local (ej. `C:\xampp\htdocs\`).
2. Iniciar el servicio de Apache desde el panel de control.
3. Abrir el navegador e ingresar a la ruta local (ej. `localhost/Tarea3/index.php`).
4. Navegar entre las diferentes secciones utilizando el menú principal.

## Estructura
* `css/`: Contiene la hoja de estilos (`style.css`).
* `img/`: Carpeta para recursos gráficos (imágenes ilustrativas integradas en cada sección).
* `index.php`: Página principal con mensaje de bienvenida dinámico e imagen alineada.
* `informacion.php`: Sección con catálogo multidimensional y buscador dinámico de materiales (método GET).
* `detalle.php`: Detalle de preparación de materiales generado con ciclos y beneficios agregados.
* `contador.php`: Panel de usuario para registrar aportaciones de reciclaje (método POST).
* `contacto.php`: Sección de atención ciudadana con validación de horarios y preguntas frecuentes.
* `README.md`: Documentación actualizada de la versión.

## Funcionalidades actuales y Cumplimiento de Rúbrica
* **Consulta GET:** Buscador integrado para filtrar y consultar información específica de un catálogo de materiales.
* **Formulario POST:** Recepción y procesamiento de datos ocultos en la solicitud HTTP para registrar iniciativas ciudadanas.
* **Validación y Seguridad:** Implementación de `isset()` y `empty()` para evitar el procesamiento de datos nulos o vacíos, y uso de `htmlspecialchars()` para prevenir inyecciones de código al mostrar resultados.
* **Integración PHP:** Inyección de contenido dinámico y refactorización de código (declaración de variables al inicio de cada archivo para mayor legibilidad).
* **Estructuras repetitivas y condicionales:** Uso de arreglos multidimensionales, ciclos `foreach` limpios (separando la lógica PHP de las etiquetas HTML) y bloques `if/else`.

## Nota de Desarrollo: Uso de Flexbox
Para mejorar la presentación visual y cumplir con las observaciones de diseño, se investigó e implementó de manera autodidacta (con asistencia de IA como tutor) el modelo de diseño **Flexbox de CSS**. Esto permitió:
* Alinear horizontalmente las imágenes ilustrativas junto a los encabezados principales (`<h2>`) de manera limpia y responsiva.
* Estructurar el pie de página institucional en tres columnas adaptables, logrando una distribución del espacio moderna y profesional.

## Estado
En desarrollo (Fase 2 - Formularios y procesamiento de datos).

## Historial de versiones
| Versión | Cambios principales |
|---------|---------------------|
| 0.3.0 | Implementación de formularios interactivos (GET y POST). Desarrollo de buscador en el catálogo de materiales y panel de registro de aportaciones. Integración de validaciones de seguridad (`empty`, `htmlspecialchars`). |
| 0.2.0 | Conversión de HTML a PHP. Integración de variables, arreglos, condicionales if/else y ciclos foreach en las 4 páginas. Ampliación de contenido informativo. |
| 0.1.0 | Creación de la estructura base HTML5 (4 páginas), configuración de carpetas de recursos y navegación estática. |