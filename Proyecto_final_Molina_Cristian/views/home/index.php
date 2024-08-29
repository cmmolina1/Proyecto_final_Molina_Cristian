<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Biblioteca ESPE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Biblioteca ESPE</h1>
        <p><strong>Integrantes del Grupo:</strong> Cristian Molina</p>
        <p>Esta aplicación web fue creada para la gestión de libros y autores en la biblioteca de ESPE.</p>
        <h2 class="mt-4 mb-3">Funcionalidades:</h2>
        <ul>
            <li>Gestión de libros: Agregar, editar y eliminar libros</li>
            <li>Gestión de autores: Agregar, editar y eliminar autores</li>
        </ul>
        <p class="mt-4">Seleccione una opción:</p>
        <a href="<?php echo $base; ?>/libros" class="btn btn-primary me-2">Gestión de Libros</a>
        <a href="<?php echo $base; ?>/autores" class="btn btn-primary">Gestión de Autores</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
