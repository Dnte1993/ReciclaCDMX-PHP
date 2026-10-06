# ReciclaCDMX
Segunda versión del portal ReciclaCDMX, integrando generación de contenido dinámico mediante PHP para la materia de Programación Web.

## Versión
0.2.0

## Tecnologías
* HTML5 y CSS3 (Estructura, paleta institucional CDMX y estilos visuales)
* PHP 8.2 (Lógica y contenido dinámico)

## Requisitos
* Un entorno de servidor local como XAMPP o Apache.
* Un navegador web actualizado.

## Ejecución
1. Extraer el contenido del archivo .zip en la carpeta pública del servidor local (ej. `C:\xampp\htdocs\`).
2. Iniciar el servicio de Apache desde el panel de control.
3. Abrir el navegador e ingresar a la ruta local (ej. `localhost/Tarea2/index.php`).
4. Navegar entre las diferentes secciones utilizando el menú principal.

## Estructura
* `css/`: Contiene la hoja de estilos (`style.css`).
* `img/`: Carpeta para recursos gráficos (imágenes ilustrativas integradas en cada sección).
* `index.php`: Página principal con mensaje de bienvenida dinámico e imagen alineada.
* `informacion.php`: Sección con listado dinámico de materiales reciclables y aviso de impacto ambiental.
* `detalle.php`: Detalle de preparación de materiales generado con ciclos y beneficios agregados.
* `contacto.php`: Sección de atención ciudadana con validación de horarios y preguntas frecuentes.
* `README.md`: Documentación actualizada de la versión.

## Funcionalidades actuales y Cumplimiento de Rúbrica
* **Integración PHP:** Inyección de contenido dinámico mediante variables en todas las secciones.
* **Estructuras repetitivas:** Uso de múltiples arreglos (mínimo 4 elementos cada uno) y ciclos `foreach` para la generación de listas, instrucciones, beneficios y FAQs.
* **Estructuras condicionales:** Validaciones lógicas mediante `if/else` para mostrar información variante (estados de servicio, campañas especiales y mensajes de usuario).
* **Navegación y Estructura:** Enlaces funcionales entre archivos con extensión `.php`.
* **Ampliación de Contenido:** Estructura robusta con 2 y 3 bloques de contenido detallado por página, sin contar encabezado ni pie de página.
* **Recursos Visuales:** Integración de imágenes con rutas relativas y diseño fluido (Flexbox) 
## Nota de Desarrollo: Uso de Flexbox
Para mejorar la presentación visual y cumplir con las observaciones de diseño, se investigó e implementó de manera autodidacta (con asistencia de IA como tutor) el modelo de diseño **Flexbox de CSS**. Esto permitió:
* Alinear horizontalmente las imágenes ilustrativas junto a los encabezados principales (`<h2>`) de manera limpia y responsiva.
* Estructurar el pie de página institucional en tres columnas adaptables, logrando una distribución del espacio moderna y profesional.
## Estado
En desarrollo (Fase 1 - Integración Inicial de PHP).

## Historial de versiones
| Versión | Cambios principales |
|---------|---------------------|
| 0.2.0 | Conversión de HTML a PHP para Programación Web. Integración de variables, arreglos, condicionales if/else y ciclos foreach en las 4 páginas. Ampliación general de contenido informativo y adición de recursos visuales estilizados. |
| 0.1.0 | Creación de la estructura base HTML5 (4 páginas), configuración de carpetas de recursos y navegación estática. |