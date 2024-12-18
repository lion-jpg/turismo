<x-filament::page>
    @push('styles')
        <style>
            /* Estilos básicos */
            body {
                /* font-family: Arial, sans-serif; */
                margin: 0;
                padding: 0 20px;
                background-color: #f4f4f4;
            }

            h1 {
                font-size: 2.5em; /* Aumentar el tamaño del encabezado */
                text-align: center;
                margin-bottom: 20px; /* Espacio debajo del encabezado */
            }

            /* Estilos de tabla */
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            table, th, td {
                border: 1px solid #ddd;
            }

            th, td {
                padding: 12px;
                text-align: left;
            }

            tr:hover {
                background-color: #e6e6e6;
            }

            /* Estilos de botones */
            .button-azul, .btn-generate {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 10px 20px;
                font-size: 1em;
                border-radius: 5px;
                cursor: pointer;
                text-decoration: none;
                display: inline-block;
            }

            .button-azul:hover, .btn-generate:hover {
                background-color: #0056b3;
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
                background-color: rgba(0, 0, 0, 0.4);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 10% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 600px;
                max-width: 90%;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            /* Estilos del formulario */
            form {
                display: flex;
                flex-direction: column;
                gap: 10px;
            }

            label {
                font-weight: bold;
            }

            input[type="text"],
            input[type="number"],
            textarea,
            input[type="file"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 4px;
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

            /* Estilos de imagen */
            .img {
                width: 60px;
                height: 60px;
                border-radius: 50%;
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
                <input type="text" id="edit_nombre" name="nombre" value="nombre">

                <label for="edit_apellidos">Apellidos:</label>
                <input type="text" id="edit_apellidos" name="apellidos" value="apellidos">

                <label for="edit_telefono">Teléfono:</label>
                <input type="number" id="edit_telefono" name="telefono" value="telefono">

                <label for="edit_descripcion">Descripción:</label>
                <input type="text" id="edit_descripcion" name="descripcion" value="descripcion">

                <label for="edit_genero">Genero:</label>
                <input type="text" id="edit_genero" name="genero" value="genero">

                <label for="edit_foto_guia">Foto Guía:</label>
                <input type="file" id="edit_foto_guia" name="foto_guia" accept="image/*" onchange="previewImage(event)">

                <div class="image-preview" id="imagePreview">
                    @if (isset($user['attributes']['foto_guia']['data'][0]['attributes']['url']))
                    <img src="{{ 'https://backend-culturas.elalto.gob.bo' . $user['attributes']['foto_guia']['data'][0]['attributes']['url'] }}"
                        alt="Imagen de la guía">
                    @endif
                </div>

                <button type="submit">Actualizar Datos</button>
            </form>
        </div>
    </div>
    
    <div class="conT">
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
                        @if (isset($item['attributes']['foto_guia']['data'][0]['attributes']['url']))
                            <tr>
                                <td><img class="img"
                                        src="{{ 'https://backend-culturas.elalto.gob.bo'.$item['attributes']['foto_guia']['data'][0]['attributes']['url'] }}"
                                        alt="Image"></td>
                                <td>{{ $item['attributes']['nombre'] }} {{ $item['attributes']['apellidos'] }}</td>
                                <td>{{ $item['attributes']['telefono'] }}</td>
                                <td>{{ $item['attributes']['descripcion'] }}</td>
                                <td>{{ $item['attributes']['genero'] }}</td>
                                <td><a href="{{ url('/generate-pdf/' . $item['id']) }}" class="btn-generate">Generate PDF</a>
                                    <button class="button-azul"
                                        onclick="openEditModal({{ json_encode($item['attributes']) }}, {{ $item['id'] }})">Editar</button>
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
        // Aquí puedes agregar lógica para cargar la imagen si es necesario
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = ''; // Limpiar el contenedor de previsualización

        if (data.foto_guia && data.foto_guia.data && data.foto_guia.data.length > 0) {
            const imgData = data.foto_guia.data[0].attributes;
            const img = document.createElement('img');
            img.src = 'https://backend-culturas.elalto.gob.bo' + imgData.url;
            img.alt = "Guia";
            img.style.maxWidth = '50%'; // Asegúrate de que la imagen no exceda el contenedor
            img.style.alin
            imagePreview.appendChild(img);
        } else {
            const message = document.createElement('p');
            message.textContent = 'No hay imagen disponible.';
            imagePreview.appendChild(message);
        }
        // Configurar la acción del formulario de edición
        document.getElementById("editForm").action = "{{ url('admin/editar') }}/" +
            id; // Asegúrate de que el ID esté disponible

        editModal.style.display = "block";
    }
    // Función para cerrar el modal de edici��n
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
    </script>
    {{-- Mantén el resto del código (modales, scripts, etc.) --}}
</x-filament::page> 