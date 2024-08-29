<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Autores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Lista de Autores</h1>
        <a href="/" class="btn btn-secondary mb-3">Volver al Inicio</a>
        <button class="btn btn-success mb-3" id="btnAgregar">Agregar Autor</button>
    
        <table class="table table-striped" id="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($autores) && is_array($autores)): ?>
                    <?php foreach ($autores as $autor) : ?>
                        <tr data-id="<?php echo $autor->id; ?>">
                            <td><?php echo $autor->id; ?></td>
                            <td><?php echo $autor->nombre; ?></td>
                            <td><?php echo $autor->apellido; ?></td>
                            <td>
                                <button class="btn btn-warning btnEditar" data-id="<?php echo $autor->id; ?>">Editar</button>
                                <button class="btn btn-danger btnEliminar" data-id="<?php echo $autor->id; ?>">Eliminar</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No se encontraron autores.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal for adding or editing author -->
    <div class="modal fade" id="authorModal" tabindex="-1" aria-labelledby="authorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="authorModalLabel">Agregar Autor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="authorForm">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" required>
                        </div>
                        <input type="hidden" id="authorId">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('btnAgregar').addEventListener('click', function() {
            document.getElementById('authorModalLabel').textContent = 'Agregar Autor';
            document.getElementById('authorForm').reset();
            document.getElementById('authorId').value = '';
            new bootstrap.Modal(document.getElementById('authorModal')).show();
        });

        function setupEditButtons() {
            document.querySelectorAll('.btnEditar').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    axios.get(`/autores/${id}`).then(response => {
                        const autor = response.data;
                        document.getElementById('authorId').value = autor.id;
                        document.getElementById('nombre').value = autor.nombre;
                        document.getElementById('apellido').value = autor.apellido;
                        document.getElementById('authorModalLabel').textContent = 'Editar Autor';
                        new bootstrap.Modal(document.getElementById('authorModal')).show();
                    });
                });
            });
        }

        function setupDeleteButtons() {
            document.querySelectorAll('.btnEliminar').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    axios.delete(`/autores/${id}`).then(response => {
                        if (response.data.status) {
                            this.closest('tr').remove();
                        } else {
                            alert('Error al eliminar');
                        }
                    });
                });
            });
        }

        setupEditButtons();
        setupDeleteButtons();

        document.getElementById('authorForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const id = document.getElementById('authorId').value;
            const nombre = document.getElementById('nombre').value;
            const apellido = document.getElementById('apellido').value;
            const data = { nombre, apellido };

            if (id) {
                axios.put(`/autores`, { id, ...data }).then(response => {
                    if (response.data) {
                        const row = document.querySelector(`tr[data-id='${id}']`);
                        row.querySelector('td:nth-child(2)').textContent = nombre;
                        row.querySelector('td:nth-child(3)').textContent = apellido;
                    }
                    new bootstrap.Modal(document.getElementById('authorModal')).hide();
                });
            } else {
                axios.post(`/autores`, data).then(response => {
                    const autor = response.data;
                    const tableBody = document.querySelector('#table tbody');
                    const newRow = document.createElement('tr');
                    newRow.dataset.id = autor.id;
                    newRow.innerHTML = `
                        <td>${autor.id}</td>
                        <td>${autor.nombre}</td>
                        <td>${autor.apellido}</td>
                        <td>
                            <button class="btn btn-warning btnEditar" data-id="${autor.id}">Editar</button>
                            <button class="btn btn-danger btnEliminar" data-id="${autor.id}">Eliminar</button>
                        </td>
                    `;
                    tableBody.appendChild(newRow);
                    setupEditButtons();
                    setupDeleteButtons();
                    new bootstrap.Modal(document.getElementById('authorModal')).hide();
                });
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
