# Proyecto de Gestión de Libros y Autores

## Descripción
Este proyecto es una aplicación web para gestionar libros y autores utilizando el patrón de diseño MVC con PHP y MySQL. 

## Tecnologías Utilizadas
- **PHP**: Para la lógica del servidor y el manejo de datos.
- **MySQL**: Para la base de datos.
- **Axios**: Para realizar peticiones AJAX.
- **Bootstrap**: Para el diseño de la interfaz.
- **Apache**: Servidor web (en el entorno XAMPP).

- Documentación
Funcionamiento del Router
El archivo router.php se encarga de dirigir las solicitudes a los controladores adecuados. Utiliza un sistema de rutas basado en la URL para determinar qué controlador y método deben manejar la solicitud.

Uso de Axios para las Peticiones
Axios es una biblioteca para hacer solicitudes HTTP desde el navegador. En este proyecto, se utiliza para enviar datos y recibir respuestas del servidor sin recargar la página. Las solicitudes se realizan en los archivos de vista correspondientes.

Estructura del Proyecto
/controllers: Contiene los controladores que manejan la lógica de la aplicación.
/models: Contiene las clases que interactúan con la base de datos.
/views: Contiene las vistas que se muestran al usuario.
router.php: Configura las rutas y dirige las solicitudes a los controladores.
