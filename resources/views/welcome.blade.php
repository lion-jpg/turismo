<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escritorio</title>
    <style>
    /* Estilo para asegurarse de que el contenedor ocupe toda la pantalla */
    html,
    body {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: Arial, sans-serif;
        /* Opcional: establece una fuente general */
    }

    .fullscreen-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
        /* Asegúrate de que la imagen esté detrás del contenido */
        box-shadow: inset 0 0 20px rgba(0, 0, 0, 0.5);
    }

    .fullscreen-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Ajusta la imagen para que cubra el contenedor sin deformarse */
        opacity: 0.9;
    }

    .content {
        position: relative;
        z-index: 1;
        /* Asegura que el contenido esté por encima de la imagen */
        color: white;
        /* Cambia el color del texto para que contraste con la imagen */
        text-align: center;
        /* Opcional: centra el contenido */
        padding: 20px;
        /* Opcional: agrega un poco de espacio alrededor del contenido */
    }

    .content img {
        position: relative;
        z-index: 2;
        /* Asegura que la imagen esté encima del fondo y contenido */
        max-width: 50%;
        /* Asegura que la imagen no se desborde */
        height: auto;
        /* Mantiene la proporción de la imagen */
    }

    nav {
        position: sticky;
        top: 0;
        display: flex;
        /* Utiliza flexbox para alinear los elementos */
        justify-content: space-between;
        /* Espacio entre los elementos */
        align-items: center;
        /* Alinea verticalmente los elementos en el centro */
        position: relative;
        z-index: 0;
        /* Asegúrate de que esté por encima de la imagen */
        background-color: white;
        opacity: 0.5;
        /* Aumenté un poco la opacidad */
        padding: 10px;
    }

    nav a {
        text-align: start;
        color: black;
        /* Color del texto del enlace */
        font-size: 24px;
        /* Tamaño de la fuente del enlace */
        text-decoration: none;
        /* Quita el subrayado del enlace */
        font-weight: bold;
        /* Negrita para el texto del enlace */
        z-index: 1;
    }

    nav a:hover {
        background: #000000;
        padding: 5px;
        border-radius: 10px;
        opacity: 1;
        color: white;
    }

    .imagen {
        border-radius: 10px;
        border: solid;
    }

    .logo {
        height: 45px;
        width: auto;
        
    }
    .conLog{
        z-index: 2;
    }

    .jacha-image {
        /* Estilos específicos para la imagen jacha */
        border-radius: 10px;
        border: solid;
        max-width: 20%;
        height: auto;
    }
    </style>
</head>

<body>
    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right">
            @auth
            <a href="{{ url('/home') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
            @else
            <a href="{{ route('login') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log
                in</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}"
                class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif
            @endauth
        </div>
        @endif
        <nav>
            <div class="conLog">
                <img class="logo" src="{{ asset('storage/logo.png') }}" alt="Descripción de la imagen">
            </div>
            <a href="/admin">Administración</a>
        </nav>
        <div class="fullscreen-image">
            <img class="w-full h-auto" src="{{ asset('storage/pai.jpg') }}" alt="Descripción de la imagen">
        </div>
        <div class="content">
            <h1 class="text-3xl font-bold underline">
                GAMEA El Alto
            </h1>

            <img class="jacha-image" src="{{ asset('storage/jacha.jpg') }}" alt="Descripción de la imagen">
        </div>
    </div>
</body>

</html>