<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rotación 3D</title>
    <style>
        /* Asegúrate de que el contenedor esté centrado */
        .container {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Ajusta la altura si es necesario */
            background-color: #f0f0f0; /* Color de fondo opcional */
            perspective: 1000px; /* Agrega perspectiva para el efecto 3D */
        }
        
        /* Estilo para la imagen */
        .images {
            width: 300px; /* Ajusta el tamaño según sea necesario */
            height: auto; /* Mantiene la proporción */
            animation: rotate 5s linear infinite; /* Aplica la animación */
            transform-style: preserve-3d; /* Necesario para mantener el efecto 3D */
        }
        .text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Centra el texto */
            color: white; /* Color del texto, ajusta según sea necesario */
            font-size: 24px; /* Tamaño del texto */
            font-weight: bold; /* Opcional, para hacer el texto más destacado */
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7); /* Opcional, para mejorar la legibilidad del texto */
        }
        
        /* Definición de la animación */
        @keyframes rotate {
            from {
                transform: rotateX(0deg) rotateY(0deg) rotateZ(0deg); /* Comienza sin rotación */
            }
            to {
                transform:  rotateY(360deg); /* Rota en todos los ejes */
            }
        }
    </style>
</head>
<body>
    <div class="container">
       <div class="caja">
       <h1 class="text">Dificultades Tecnicas</h1>
       </div>
        
        <img class="images" src="{{ asset('storage/error.png') }}" alt="Descripción de la imagen">
    </div>
</body>
</html>
