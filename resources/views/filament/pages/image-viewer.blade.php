<x-filament::page>
    @push('styles')
        <style>
            body {
                margin: 0;
                padding: 0;
            }

            h1 {
                font-size: 2.5em;
                text-align: center;
                margin-bottom: 20px;
            }

            /* Estilos de tabla */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                background-color: var(--table-bg);
                border-radius: 8px;
                box-shadow: var(--shadow);
            }

            table, th, td {
                border: 1px solid var(--border-color);
            }
            th {
                background-color: var(--header-bg);
            }
            th, td {
                padding: 12px;
                text-align: left;
            }

            tr:hover {
                background-color: var(--hover-bg);
            }

            /* Estilos de botones */
            .button-azul, .btn-generate {
                background-color: var(--primary-button);
                color: white;
                border: none;
                padding: 10px 20px;
                font-size: 1em;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
                transition: background-color 0.3s;
            }

            .button-azul:hover, .btn-generate:hover {
                background-color: var(--primary-button-hover);
            }

            /* Estilos del modal */
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

            /* Estilos del formulario */
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
            input[type="number"],
            textarea,
            input[type="file"] {
                width: 100%;
                padding: 8px;
                border: 1px solid var(--border-color);
                border-radius: 4px;
                background-color: var(--input-bg);
                color: var(--text-color);
            }

            /* Variables CSS para temas claro/oscuro */
            :root {
                --table-bg: #ffffff;
                --border-color: #ddd;
                --hover-bg: #f5f5f5;
                --primary-button: #007bff;
                --primary-button-hover: #0056b3;
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
                --modal-overlay: rgba(0, 0, 0, 0.6);
                --modal-bg: #1f2937;
                --text-color: #ffffff;
                --input-bg: #374151;
                --shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }

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

            .img {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                border: 2px solid var(--border-color);
            }

            .image-preview {
                text-align: center;
                height: 60%;
                width: auto;
            }
        </style>
    @endpush

    <div>
        <!-- Botón para abrir el formulario en modal -->
        <h1>Guias Registrados</h1>
        <button id="openModalBtn" class="btn-generate">Agregar Guia</button>
          <!-- Modal para el formulario-->
     
    <div id="formModal" class="modal">
        <div class="modal-content">

            <span class="close-btn" onclick="closeModal()">&times;</span>
            <form action="{{ url('admin/add-data') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre">

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos">

                <label for="telefono">Teléfono:</label>
                <input type="number" id="telefono" name="telefono">

                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion"></input>

                <label for="genero">Género:</label>
                <div>
                    <input type="radio" id="masculino" name="genero" value="masculino">
                    <label for="masculino">Masculino</label>
                </div>
                <div>
                    <input type="radio" id="femenino" name="genero" value="femenino">
                    <label for="femenino">Femenino</label>
                </div>
                <div>
                    <input type="radio" id="otro" name="genero" value="otro">
                    <label for="otro">Otro</label>
                </div>

                <label for="foto_guia">Foto Guía:</label>
                <input type="file" id="foto_guia" name="foto_guia" accept="image/*">

                <button type="submit" class="btn-generate">Agregar Datos</button>
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

                <label for="edit_nombre">Nombre:</label>
                <input type="text" id="edit_nombre" name="nombre">

                <label for="edit_apellidos">Apellidos:</label>
                <input type="text" id="edit_apellidos" name="apellidos">

                <label for="edit_telefono">Teléfono:</label>
                <input type="number" id="edit_telefono" name="telefono">

                <label for="edit_descripcion">Descripción:</label>
                <input type="text" id="edit_descripcion" name="descripcion">

                <label for="edit_genero">Género:</label>
                <input type="text" id="edit_genero" name="genero">

                <label for="edit_foto_guia">Foto Guía:</label>
                <input type="file" id="edit_foto_guia" name="foto_guia" accept="image/*" onchange="previewImage(event)">

                <div class="image-preview" id="imagePreview">
                    @if (isset($data['attributes']['foto_guia']['data']['attributes']['url']))
                        <img src="{{ 'https://backend-culturas.elalto.gob.bo'.$data['attributes']['foto_guia']['data']['attributes']['url'] }}"
                            alt="Imagen de la guía">
                    @endif
                </div>

                <button type="submit" class="button-azul">Actualizar Datos</button>
            </form>
        </div>
    </div>
    
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nombre y Apellido</th>
                    <th>Teléfono</th>
                    <th>Descripción</th>
                    <th>Género</th>
                    <th>Acciónes</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($data['data']) && is_array($data['data']))
                    @foreach ($data['data'] as $item)
                        @if (isset($item['attributes']['foto_guia']['data']['attributes']['url']))
                            <tr>
                                <td>
                                    <img class="img"
                                        src="{{ 'https://backend-culturas.elalto.gob.bo'.$item['attributes']['foto_guia']['data']['attributes']['url'] }}"
                                        alt="Image">
                                </td>
                                <td>{{ $item['attributes']['nombre'] }} {{ $item['attributes']['apellidos'] }}</td>
                                <td>{{ $item['attributes']['telefono'] }}</td>
                                <td>{{ $item['attributes']['descripcion'] }}</td>
                                <td>{{ $item['attributes']['genero'] }}</td>
                                <td>
                                    <a href="{{ url('/generate-pdf/' . $item['id']) }}" class="btn-generate">Generate PDF</a>
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
                        <td colspan="6">No hay datos disponibles.</td>
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
        document.getElementById("edit_nombre").value = data.nombre;
        document.getElementById("edit_apellidos").value = data.apellidos;
        document.getElementById("edit_descripcion").value = data.descripcion;
        document.getElementById("edit_telefono").value = data.telefono;
        document.getElementById("edit_genero").value = data.genero;
        
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = '';

        if (data.foto_guia && data.foto_guia.data && data.foto_guia.data.attributes) {
            const imgData = data.foto_guia.data.attributes;
            const img = document.createElement('img');
            img.src = 'https://backend-culturas.elalto.gob.bo' + imgData.url;
            img.alt = "Guia";
            img.style.maxWidth = '50%';
            imagePreview.appendChild(img);
        } else {
            const message = document.createElement('p');
            message.textContent = 'No hay imagen disponible.';
            imagePreview.appendChild(message);
        }

        document.getElementById("editForm").action = "{{ url('admin/editar') }}/" + id;
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
    {{-- Mantén el resto del código (modales, scripts, etc.) --}}
</x-filament::page> 