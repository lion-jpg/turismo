<x-filament-panels::page>
@push('styles')
        <style>
           body {
        /* font-family: Arial, sans-serif; */
        margin: 0;
        padding: 0;
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

    .btn-generate {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 20px;
        font-size: 1em;
        color: white;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-generate:hover {
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
        background-color: var(--modal-bg);
        color: var(--text-color);
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
        border: 1px solid var(--border-color);
        border-radius: 4px;
        background-color: var(--input-bg);
        color: var(--text-color);
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
        /* Color de fondo al pasar el ratón */
        .button-rojo {
                background-color: #ed0505; /* Nuevo color de fondo (rojo claro) */
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
                transition: background-color 0.3s; /* Añadido efecto de transición */
            }

            .button-rojo:hover {
                background-color: #ad0303; /* Color más oscuro al pasar el ratón */
            }
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
        /* Aumenta el desplazamiento y la opacidad de la sombra */
    

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

    /* Estilo de la barra de navegación */
    

   
    .img {
        width: 100px;
        height: 60px;
        border-radius: 10%;
    }
    .image-preview{
        text-align: center;
        height: 60%;
        width: auto;
    }

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
    <h1>Turismo Natural</h1>
 
    <button id="openModalBtn" class="btn-generate">Agregar Contenido</button>
     <!-- Modal para el formulario  -->
     <div id="formModal" class="modal">
        <div class="modal-content">
            <!-- Mensajes de éxito y error -->

            <span class="close-btn" onclick="closeModal()">&times;</span>
            <form action="{{ url('admin/t_post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo">

                <label for="descrip">Descripción:</label>
                <input type="text" id="descrip" name="descrip"></input>

                <label for="foto_tran">Fotografia:</label>
                <input type="file" id="foto_tran" name="foto_tran" accept="image/*">

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

                <label for="edit_foto_tran">Fotografía:</label>
                <input type="file" id="edit_foto_tran" name="foto_tran" accept="image/*" onchange="previewImage(event)">

                <div class="image-preview" id="imagePreview">
                    @if (isset($data['attributes']['foto_tran']['data']['attributes']['url']))

                    <img src="{{ 'https://backend-culturas.elalto.gob.bo'.$data['attributes']['foto_tran']['data']['attributes']['url'] }}"
                        alt="transporte">
                    @endif
                </div>
                <button  class="button-azul" type="submit">Actualizar Contenido</button>
            </form>
        </div>
    </div>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Fotografía</th>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($data['data']) && is_array($data['data']))
                <!-- <pre>{{ print_r($data['data'], true) }}</pre> -->
                @foreach ($data['data'] as $item)
                @if (isset($item['attributes']['foto_tran']['data']['attributes']['url']))

                <tr>
                    <td>
                        <img class="img"
                            src="{{ 'https://backend-culturas.elalto.gob.bo'.$item['attributes']['foto_tran']['data']['attributes']['url'] }}"
                            alt="Image">
                    </td>
                    <td>{{ $item['attributes']['titulo'] }}</td>
                    <td>{{ $item['attributes']['descrip'] }}</td>

                    <td>
                        <button class="button-azul"
                            onclick="openEditModal({{ json_encode($item['attributes']) }}, {{ $item['id'] }})">Editar</button>
                            <form action="{{ url('admin/t_delete', $item['id']) }}" method="POST" style="display:inline;">
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
    // Obtener el modal de creacion
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
        // Aquí puedes agregar lógica para cargar la imagen si es necesario
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = ''; // Limpiar el contenedor de previsualización

        if (data.foto_tran && data.foto_tran.data && data.foto_tran.data.attributes.url) {
            const img = document.createElement('img');
            img.src = 'https://backend-culturas.elalto.gob.bo' + data.foto_tran.data.attributes.url;
            img.alt = "Transporte";
            img.style.maxWidth = '50%'; // Asegúrate de que la imagen no exceda el contenedor
            imagePreview.appendChild(img);
        }
        // Configurar la acción del formulario de edición
        document.getElementById("editForm").action = "{{ url('admin/t_post') }}/" +
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
        }
    }

    // Detectar cambios en el modo oscuro
    if (window.matchMedia) {
        // Comprobar si el modo oscuro está activo
        const darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        
        const handleDarkModeChange = (e) => {
            if (e.matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        };

        // Escuchar cambios en el modo oscuro
        darkModeMediaQuery.addListener(handleDarkModeChange);
        
        // Aplicar el modo inicial
        handleDarkModeChange(darkModeMediaQuery);
    }
    </script>
</x-filament-panels::page>
