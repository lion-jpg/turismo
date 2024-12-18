<x-filament-panels::page>
    @push('styles')
        <style>
            /* Estilos de tabla */
            .container {
                margin-top: 20px;
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                background-color: white;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }

            th, td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }

            tr:hover {
                background-color: #f1f1f1;
            }

            /* Estilos del Modal */
            .modal {
                display: none;
                position: fixed;
                z-index: 999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 10% auto;
                padding: 20px;
                border-radius: 8px;
                width: 600px;
                max-width: 90%;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            /* Estilos de formulario */
            form {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            label {
                font-weight: bold;
            }

            input[type="text"],
            textarea,
            input[type="file"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
            }

            /* Botones */
            .button-azul, .btn-generate {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 8px 12px;
                font-size: 0.875rem;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                max-width: 150px;
                width: auto;
                text-align: center;
                margin: 8px 0;
            }

            .button-azul:hover, .btn-generate:hover {
                background-color: #0056b3;
            }

            /* Botón cerrar modal */
            .close-btn {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
            }

            .close-btn:hover {
                color: black;
            }

            /* Imagen en tabla */
            .img {
                width: 100px;
                height: 60px;
                border-radius: 10%;
                object-fit: cover;
            }

            /* Preview de imagen */
            .image-preview img {
                max-width: 50%;
                margin-top: 10px;
            }

            h1 {
                font-size: 2.5em; /* Aumentar el tamaño del encabezado */
                text-align: center;
                margin-bottom: 20px; /* Espacio debajo del encabezado */
            }
        </style>
    @endpush

    <!-- Botón para abrir modal -->
    
    <h1>Turismo Deportivo</h1>
    <button id="openModalBtn" class="btn-generate">Agregar Contenido</button>

    <!-- Modal para agregar -->
    <div id="formModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <form action="{{ url('admin/d_post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" required>

                <label for="ubicacion">Ubicacion:</label>
                <input type="text" id="ubicacion" name="ubicacion" required>

                <label for="descri">Descripción:</label>
                <textarea id="descri" name="descri" required></textarea>

                <label for="foto_dep">Fotografia:</label>
                <input type="file" id="foto_dep" name="foto_dep" accept="image/*" required>

                <button type="submit" class="button-azul">Agregar Contenido</button>
            </form>
        </div>
    </div>

    <!-- Modal para Editar -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeEditModal()">&times;</span>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <label for="edit_titulo">Título:</label>
                <input type="text" id="edit_titulo" name="titulo" required>

                <label for="edit_descri">Descripción:</label>
                <textarea id="edit_descri" name="descri" required></textarea>

                <label for="edit_ubicacion">Ubicación:</label>
                <input type="text" id="edit_ubicacion" name="ubicacion" required>

                <label for="edit_foto_dep">Fotografía:</label>
                <input type="file" id="edit_foto_dep" name="foto_dep" accept="image/*">

                <div class="image-preview" id="imagePreview"></div>

                <button type="submit" class="button-azul">Actualizar Contenido</button>
            </form>
        </div>
    </div>

    <!-- Tabla de contenido -->
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Fotografía</th>
                    <th>Título</th>
                    <th>Ubicación</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data['data']) && is_array($data['data']))
                    @foreach ($data['data'] as $item)
                        @if (isset($item['attributes']['foto_dep']['data']['attributes']['url']))
                            <tr>
                                <td>
                                    <img class="img"
                                        src="{{ 'https://backend-culturas.elalto.gob.bo'.$item['attributes']['foto_dep']['data']['attributes']['url'] }}"
                                        alt="Deporte">
                                </td>
                                <td>{{ $item['attributes']['titulo'] }}</td>
                                <td>{{ $item['attributes']['ubicacion'] }}</td>
                                <td>{{ $item['attributes']['descri'] }}</td>
                                <td>
                                    <button class="button-azul"
                                        onclick="openEditModal({{ json_encode($item['attributes']) }}, {{ $item['id'] }})">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="5">No se encontraron datos.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script>
        // Funciones del modal
        const modal = document.getElementById("formModal");
        const editModal = document.getElementById("editModal");
        const openModalBtn = document.getElementById("openModalBtn");

        openModalBtn.onclick = function() {
            modal.style.display = "block";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        function closeEditModal() {
            editModal.style.display = "none";
        }

        function openEditModal(data, id) {
            document.getElementById("edit_titulo").value = data.titulo;
            document.getElementById("edit_descri").value = data.descri;
            document.getElementById("edit_ubicacion").value = data.ubicacion;

            const imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = '';

            if (data.foto_dep && data.foto_dep.data && data.foto_dep.data.attributes.url) {
                const img = document.createElement('img');
                img.src = 'https://backend-culturas.elalto.gob.bo' + data.foto_dep.data.attributes.url;
                img.alt = "Deportes";
                imagePreview.appendChild(img);
            }

            document.getElementById("editForm").action = "{{ url('admin/d_post') }}/" + id;
            editModal.style.display = "block";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            } else if (event.target == editModal) {
                closeEditModal();
            }
        }
    </script>
</x-filament-panels::page>
