<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Libros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Lista de Libros</h1>
        <a href="/" class="btn btn-secondary mb-3">Volver al Inicio</a>
        <button class="btn btn-success mb-3" id="btnAgregarLibro">Agregar Libro</button>
        <table class="table table-striped" id="tableLibros">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($libros) && is_array($libros)): ?>
                    <?php foreach ($libros as $libro) : ?>
                        <tr data-id="<?php echo $libro->id; ?>">
                            <td><?php echo $libro->id; ?></td>
                            <td><?php echo $libro->titulo; ?></td>
                            <td><?php echo $libro->autor->nombre . ' ' . $libro->autor->apellido; ?></td>
                            <td>
                                <button class="btn btn-warning btnEditarLibro" data-id="<?php echo $libro->id; ?>">Editar</button>
                                <button class="btn btn-danger btnEliminarLibro" data-id="<?php echo $libro->id; ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No se encontraron libros.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for adding or editing book -->
    <div class="modal fade" id="libroModal" tabindex="-1" aria-labelledby="libroModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="libroModalLabel">Agregar Libro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="libroForm">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="autorId" class="form-label">Autor</label>
                            <select class="form-control" id="autorId" required>
                                <?php foreach ($autores as $autor): ?>
                                    <option value="<?php echo $autor->id; ?>"><?php echo $autor->nombre . ' ' . $autor->apellido; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" id="libroId">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('btnAgregarLibro').addEventListener('click', function() {
            document.getElementById('libroModalLabel').textContent = 'Agregar Libro';
            document.getElementById('libroForm').reset();
            document.getElementById('libroId').value = '';
            new bootstrap.Modal(document.getElementById('libroModal')).show();
        });

        function setupEditLibroButtons() {
            document.querySelectorAll('.btnEditarLibro').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    axios.get(`/libros/${id}`).then(response => {
                        const libro = response.data;
                        document.getElementById('libroId').value = libro.id;
                        document.getElementById('titulo').value = libro.titulo;
                        document.getElementById('autorId').value = libro.autor_id;
                        document.getElementById('libroModalLabel').textContent = 'Editar Libro';
                        new bootstrap.Modal(document.getElementById('libroModal')).show();
                    });
                });
            });
        }

        function setupDeleteLibroButtons() {
            document.querySelectorAll('.btnEliminarLibro').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    axios.delete(`/libros/${id}`).then(response => {
                        if (response.data.status) {
                            this.closest('tr').remove();
                        } else {
                            alert('Error al eliminar');
                        }
                    });
                });
            });
        }

        setupEditLibroButtons();
        setupDeleteLibroButtons();

        document.getElementById('libroForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const id = document.getElementById('libroId').value;
            const titulo = document.getElementById('titulo').value;
            const autorId = document.getElementById('autorId').value;
            const data = { titulo, autor_id: autorId };

            if (id) {
                axios.put(`/libros`, { id, ...data }).then(response => {
                    if (response.data) {
                        const row = document.querySelector(`tr[data-id='${id}']`);
                        row.querySelector('td:nth-child(2)').textContent = titulo;
                        row.querySelector('td:nth-child(3)').textContent = response.data.autor.nombre + ' ' + response.data.autor.apellido;
                    }
                    new bootstrap.Modal(document.getElementById('libroModal')).hide();
                });
            } else {
                axios.post(`/libros`, data).then(response => {
                    const libro = response.data;
                    const tableBody = document.querySelector('#tableLibros tbody');
                    const newRow = document.createElement('tr');
                    newRow.dataset.id = libro.id;
                    newRow.innerHTML = `
                        <td>${libro.id}</td>
                        <td>${libro.titulo}</td>
                        <td>${libro.autor.nombre} ${libro.autor.apellido}</td>
                        <td>
                            <button class="btn btn-warning btnEditarLibro" data-id="${libro.id}">Editar</button>
                            <button class="btn btn-danger btnEliminarLibro" data-id="${libro.id}">Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(newRow);
                    setupEditLibroButtons();
                    setupDeleteLibroButtons();
                    new bootstrap.Modal(document.getElementById('libroModal')).hide();
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>

