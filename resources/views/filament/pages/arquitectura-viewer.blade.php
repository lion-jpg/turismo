<x-filament-panels::page>
    @push('styles')
        <style>
            /* body {
                margin: 0;
                padding: 0 20px 0 20px;
            } */

            .filament-main h1,
            h1 {
                font-size: 2.5em;
                text-align: center;
                margin-bottom: 20px;
                color: var(--text-color);
            }

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

            /* Estilo del Modal */
            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: var(--modal-overlay);
            }

            .modal-content {
                background-color: var(--modal-bg);
                color: var(--text-color);
                margin: 10% auto;
                padding: 20px;
                border: 1px solid var(--border-color);
                width: 600px;
                max-width: 90%;
                border-radius: 8px;
                box-shadow: var(--shadow);
            }

            .close-btn {
                color: var(--text-color);
                opacity: 0.7;
                float: right;
                font-size: 28px;
                font-weight: bold;
                transition: opacity 0.3s;
            }

            .close-btn:hover {
                opacity: 1;
                cursor: pointer;
            }

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
            input[type="int"],
            textarea,
            input[type="file"] {
                width: 100%;
                padding: 8px;
                border: 1px solid var(--border-color);
                border-radius: 4px;
                background-color: var(--input-bg);
                color: var(--text-color);
            }

            .img {
                width: 100px;
                height: 60px;
                border-radius: 10%;
                border: 2px solid var(--border-color);
            }

            /* Variables CSS para temas claro/oscuro */
            :root {
                --table-bg: #ffffff;
                --border-color: #ddd;
                --hover-bg: #f5f5f5;
                --header-bg: #f4f4f4;
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

    <h1 class="filament-header-heading">Turismo Cultural</h1>
    <button id="openModalBtn" class="btn-generate">Agregar Contenido</button>

    <!-- Modal para el formulario  -->
    <div id="formModal" class="modal">
        <div class="modal-content">
            <!-- Mensajes de éxito y error -->

            <span class="close-btn" onclick="closeModal()">&times;</span>
            <form action="{{ url('admin/a_post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo">

                <label for="ubicacion">Ubicacion:</label>
                <input type="text" id="ubicacion" name="ubicacion">

                <label for="descrip">Descripción:</label>
                <input type="text" id="descrip" name="descrip"></input>

                <label for="foto_arq">Fotografia:</label>
                <input type="file" id="foto_arq" name="foto_arq" accept="image/*">

                <button type="submit" class="btn-generate">Agregar Contenido</button>
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
                <input type="text" id="edit_titulo" name="titulo">

                <label for="edit_descrip">Descripción:</label>
                <input type="text" id="edit_descrip" name="descrip">

                <label for="edit_ubicacion">Ubicación:</label>
                <input type="text" id="edit_ubicacion" name="ubicacion">

                <label for="edit_foto_arq">Fotografía:</label>
                <input type="file" id="edit_foto_arq" name="foto_arq" accept="image/*" onchange="previewImage(event)">

                <div class="image-preview" id="imagePreview">
                    @if (isset($data['attributes']['foto_arq']['data']['attributes']['url']))

                    <img src="{{ 'https://backend-culturas.elalto.gob.bo'.$data['attributes']['foto_arq']['data']['attributes']['url'] }}"
                        alt="transporte">
                    @endif
                </div>
                <button class="button-azul" type="submit">Actualizar Contenido</button>
            </form>
        </div>
    </div>
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
                
                <!-- <pre>{{ print_r($data['data'], true) }}</pre> -->
                    @foreach ($data['data'] as $item)
                        @if (isset($item['attributes']['foto_arq']['data']['attributes']['url']))
                            <tr>
                                <td>
                                    <img class="img" src="{{ 'https://backend-culturas.elalto.gob.bo'.$item['attributes']['foto_arq']['data']['attributes']['url'] }}" alt="Image" >
                                </td>
                                <td>{{ $item['attributes']['titulo'] }}</td>
                                <td>{{ $item['attributes']['ubicacion'] }}</td>
                                <td>{{ $item['attributes']['descrip'] }}</td>
                                <td>
                                <button class="button-azul"
                                    onclick="openEditModal({{ json_encode($item['attributes']) }}, {{ $item['id'] }})">Editar</button>
                                    <form action="{{ url('admin/a_delete', $item['id']) }}" method="POST" style="display:inline;">
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
                        <td colspan="4">No data found.</td>
                    </tr>
                @endif 
            </tbody>
        </table>
    </div>
    <script>
    // Obtener el modal
    var modal = document.getElementById("formModal");

    // Obtener el modal de edición
    var editModal = document.getElementById("editModal");

    // Obtener el botón que abre el modal
    var openModalBtn = document.getElementById("openModalBtn");

    // Obtener el elemento que cierra el modal
    var closeBtn = document.getElementsByClassName("close-btn")[0];

    // Cuando el usuario hace clic en el botón, abre el modal
    openModalBtn.onclick = function() {
        modal.style.display = "block";
    }

    // Cuando el usuario hace clic en el botón de cerrar (x), cierra el modal
    closeBtn.onclick = function() {
        modal.style.display = "none";
    }

    // Cuando el usuario hace clic fuera del modal, cierra el modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    function openEditModal(data, id) {
        document.getElementById("edit_titulo").value = data.titulo;
        document.getElementById("edit_descrip").value = data.descrip;
        document.getElementById("edit_ubicacion").value = data.ubicacion;
        // Aquí puedes agregar lógica para cargar la imagen si es necesario
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = ''; // Limpiar el contenedor de previsualización

        if (data.foto_arq && data.foto_arq.data && data.foto_arq.data.attributes.url) {
            const img = document.createElement('img');
            img.src = 'https://backend-culturas.elalto.gob.bo' + data.foto_arq.data.attributes.url;
            img.alt = "Arquitecturas";
            img.style.maxWidth = '50%'; // Asegúrate de que la imagen no exceda el contenedor
            imagePreview.appendChild(img);
        }
        // Configurar la acción del formulario de edición
        document.getElementById("editForm").action = "{{ url('admin/a_post') }}/" +
        id; // Asegúrate de que el ID esté disponible

        editModal.style.display = "block";
    }
    // Función para cerrar el modal de edición
    function closeEditModal() {
        editModal.style.display = "none";
    }
    // Cerrar modal al hacer clic fuera
    window.onclick = function(event) {
        if (event.target == modal) {
            closeModal();
        } else if (event.target == editModal) {
            closeEditModal();
        }}

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
