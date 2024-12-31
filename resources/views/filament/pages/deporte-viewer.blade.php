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
                background-color: var(--table-bg);
                box-shadow: var(--shadow);
                border-radius: 8px;
            }

            th, td {
                padding: 10px;
                text-align: left;
                border-bottom: 1px solid var(--border-color);
            }
            th {
                background-color: var(--header-bg);
            }
            tr:hover {
                background-color: var(--hover-bg);
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
                background-color: var(--modal-overlay);
            }

            .modal-content {
                background-color: var(--modal-bg);
                color: var(--text-color);
                margin: 10% auto;
                padding: 20px;
                border-radius: 8px;
                width: 600px;
                max-width: 90%;
                box-shadow: var(--shadow);
                border: 1px solid var(--border-color);
            }

            /* Estilos de formulario */
            form {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            label {
                font-weight: bold;
                color: var(--text-color);
            }

            input[type="text"],
            textarea,
            input[type="file"] {
                width: 100%;
                padding: 8px;
                border: 1px solid var(--border-color);
                border-radius: 4px;
                background-color: var(--input-bg);
                color: var(--text-color);
            }

            /* Botones */
            .button-azul, .btn-generate {
                background-color: var(--primary-button);
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
                transition: background-color 0.3s;
            }

            .button-azul:hover, .btn-generate:hover {
                background-color: var(--primary-button-hover);
            }

            .button-rojo {
                background-color: var(--danger-button);
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
                transition: background-color 0.3s;
            }

            .button-rojo:hover {
                background-color: var(--danger-button-hover);
            }

            /* Botón cerrar modal */
            .close-btn {
                color: var(--text-color);
                opacity: 0.7;
                float: right;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
                transition: opacity 0.3s;
            }

            .close-btn:hover {
                opacity: 1;
            }

            /* Imagen en tabla */
            .img {
                width: 100px;
                height: 60px;
                border-radius: 10%;
                object-fit: cover;
                border: 2px solid var(--border-color);
            }

            /* Preview de imagen */
            .image-preview img {
                max-width: 50%;
                margin-top: 10px;
                border: 2px solid var(--border-color);
            }

            h1 {
                font-size: 2.5em;
                text-align: center;
                margin-bottom: 20px;
                color: var(--text-color);
            }

            /* Variables CSS para temas claro/oscuro */
            :root {
                --table-bg: #ffffff;
                --border-color: #ddd;
                --hover-bg: #f5f5f5;
                --primary-button: #007bff;
                --primary-button-hover: #0056b3;
                --danger-button: #ed0505;
                --danger-button-hover: #ad0303;
                --modal-overlay: rgba(0, 0, 0, 0.4);
                --modal-bg: #ffffff;
                --text-color: #000000;
                --input-bg: #ffffff;
                --shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .dark {
                --table-bg: #1f2937;
                --border-color: #374151;
                --hover-bg: #2d3748;
                --header-bg: #111827;
                --primary-button: #3b82f6;
                --primary-button-hover: #2563eb;
                --danger-button: #ef4444;
                --danger-button-hover: #dc2626;
                --modal-overlay: rgba(0, 0, 0, 0.6);
                --modal-bg: #1f2937;
                --text-color: #ffffff;
                --input-bg: #374151;
                --shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }
        </style>
    @endpush

    <!-- Botón para abrir modal -->
    
    <h1>Turismo Aventura</h1>
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
                                    <form action="{{ url('admin/d_delete', $item['id']) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button-rojo" onclick="return confirm('¿Estás seguro de que deseas eliminar este contenido?');">Eliminar</button>
                                    </form>
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

        // Detectar cambios en el modo oscuro
        if (window.matchMedia) {
            const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            
            const handleDarkModeChange = (e) => {
                if (e.matches) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            };

            darkModeMediaQuery.addListener(handleDarkModeChange);
            handleDarkModeChange(darkModeMediaQuery);
        }

        // Sincronizar con el tema de Filament
        document.addEventListener('DOMContentLoaded', function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.add('dark');
            }
        });
    </script>
</x-filament-panels::page>
