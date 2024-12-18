<x-filament-panels::page>
    @push('styles')
        <style>
             body {
        /* font-family: Arial, sans-serif; */
        margin: 0;
        padding: 0 20px 0 20px;
        background-color: #f4f4f4;
    }

    h1 {
                font-size: 2.5em; /* Aumentar el tamaño del encabezado */
                text-align: center;
                margin-bottom: 20px; /* Espacio debajo del encabezado */
            }

    .container {
        margin-top: 20px;
        overflow-x: auto;
        /* Permite el desplazamiento horizontal si la tabla es ancha */
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

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

    /* Estilo del Modal */
    .modal {
        display: none;
        /* Oculta el modal por defecto */
        position: fixed;
        /* Fija el modal en la pantalla */
        z-index: 1;
        /* Asegura que el modal esté encima de otros elementos */
        left: 0;
        top: 0;
        width: 100%;
        /* Ancho completo */
        height: 100%;
        /* Alto completo */
        overflow: auto;
        /* Permite el desplazamiento si es necesario */
        background-color: rgba(0, 0, 0, 0.4);
        /* Fondo semitransparente */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        /* Centra el modal verticalmente */
        padding: 20px;
        border: 1px solid #888;
        width: 600px;
        /* Ancho del modal */
        max-width: 90%;
        /* Máximo ancho del modal */
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    /* Estilo para el formulario en el modal */
    form {
        display: flex;
        flex-direction: column;
        /* Disposición en columna */
        gap: 10px;
        /* Espacio entre los campos */
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="int"],
    textarea,
    input[type="file"] {
        width: 100%;
        /* Ancho completo */
        padding: 8px;
        /* Espaciado interior */
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .button-azul{
        background-color: #007bff;
        /* Color de fondo del botón */
        color: white;
        /* Texto blanco */
        border: none;
        padding: 10px;
        font-size: 1em;
        border-radius: 5px;
        cursor: pointer;
    }

    .button-azul:hover {
        background-color: #0056b3;
        /* Color de fondo al pasar el ratón */
        
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3); /* Aumenta el desplazamiento y la opacidad de la sombra */
    }
    button[type="submit"] {
        background-color: #007bff;
        /* Color de fondo del botón */
        color: white;
        /* Texto blanco */
        border: none;
        padding: 10px;
        font-size: 1em;
        border-radius: 5px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
        /* Color de fondo al pasar el ratón */
    }

    /* Estilo del botón de cerrar */
    .close-btn {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close-btn:hover,
    .close-btn:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }


    .img{
        width: 100px; 
        height: 60px;
        border-radius: 10%;
    }
        </style>
    @endpush

    <h1>Turismo Arquitectónico</h1>
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
    </script>
</x-filament-panels::page>
