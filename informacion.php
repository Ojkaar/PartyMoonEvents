<?php
session_start();
require_once('db.php');
$usuarioLogueado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
$rolUsuario = isset($_SESSION['rol']) ? $_SESSION['rol'] : null; // Obtener el rol del usuario (si está logueado)
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a MoonPartyEvents</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    <style>
        /* Estilos del cuerpo y el fondo */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .welcome-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 20px auto; /* Centra el contenedor */
            z-index: 1;
        }
        .informacion {
            display: flex;
            flex-wrap: wrap; /* Permite que los elementos se envuelvan en múltiples filas */
            justify-content: center; /* Centra los elementos en la fila */
            max-width: 800px; /* Ajusta el ancho máximo */
            margin: 20px auto; /* Centra el contenedor */
        }
        .section {
            background-color: white; /* Fondo blanco */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: calc(50% - 40px); /* 50% de ancho menos márgenes */
            margin: 10px; /* Espacio entre secciones */
            text-align: left;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 140px;
            height: auto;
        }
        .btn-primary {
            background-color: #9d91ff;
        }
        .scroll-button {
            margin-top: 20px;
            background-color: #ffcc00;
            color: black;
        }
        .section-header {
            text-align: center;
            margin: 20px 0;
            color: #333;
            font-size: 2rem;
            font-weight: bold;
        }
        footer {
            background-color: #6f42c1;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        body {
            background: linear-gradient(to bottom right, #9d91ff, rgba(255, 255, 255, 0.7));
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }
        h1 {
            font-family: 'Pacifico', cursive; /* Cambiar la fuente del encabezado */
            color: #ff4081; /* Color del texto */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Sombra para mayor efecto */
        }
     

        @media (max-width: 600px) {
            .section {
                width: 100%; /* En pantallas pequeñas, las secciones ocupan todo el ancho */
            }
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>

     
                     <?php
include 'Navbar.php';

// Supongamos que ya tienes $usuarioLogueado y $rolUsuario configurados
Navbar::render($usuarioLogueado, $rolUsuario);
?>

 

   <div class="section">
    <h2>¿Quiénes Somos?</h2>
    <p>
        En <strong>MoonPartyEvents</strong>, somos un equipo comprometido con la creación de experiencias únicas y memorables. 
        Nuestra pasión por los eventos nos impulsa a transformar cada celebración en un momento inolvidable. 
        Con años de experiencia en la organización de fiestas y eventos, estamos dedicados a brindar un servicio excepcional 
        que refleje tu estilo y supere tus expectativas.
    </p>
    <h3>Misión</h3>
    <p>
        Nuestra misión es ofrecer soluciones integrales y personalizadas para cada tipo de evento, asegurándonos de que 
        nuestros clientes vivan momentos mágicos mientras nosotros nos encargamos de todos los detalles.
    </p>
    <h3>Visión</h3>
    <p>
        Ser la empresa líder en organización de eventos en el área metropolitana de Monterrey y más allá, reconocida por 
        nuestra innovación, creatividad y excelencia en el servicio.
    </p>
    <h3>Valores</h3>
    <ul>
        <li><strong>Compromiso:</strong> Ponemos todo nuestro esfuerzo y dedicación en cada proyecto.</li>
        <li><strong>Calidad:</strong> Garantizamos el más alto nivel de servicio y productos.</li>
        <li><strong>Innovación:</strong> Nos reinventamos constantemente para ofrecer ideas frescas y originales.</li>
        <li><strong>Trabajo en equipo:</strong> Creemos que la colaboración es clave para el éxito.</li>
        <li><strong>Orientación al cliente:</strong> Escuchamos tus necesidades y adaptamos nuestros servicios para cumplir tus sueños.</li>
    </ul>
    <h3>¿Qué nos hace diferentes?</h3>
    <p>
        En MoonPartyEvents, nos destacamos por nuestra atención al detalle, creatividad y la capacidad de adaptarnos a las 
        últimas tendencias en eventos. Ya sea una fiesta infantil, una boda, un evento corporativo o una celebración especial, 
        estamos aquí para hacer realidad tus ideas.
    </p>
    <p>
        ¡Déjanos encargarnos de todo y disfruta del momento! 
    </p>
</div>


    <div class="section">
        <h2>¡Haz tu evento inolvidable!</h2>
        <p>
            Si necesitas una experiencia más personalizada, estamos aquí para ayudarte. Contáctanos vía WhatsApp (8122219085) y crearemos juntos el evento perfecto.
        </p>
        <a href="contacto.php" target="_blank" class="btn btn-success">Contáctanos vía WhatsApp</a>
    </div>

    <script>
        // Configuración de particles.js
        particlesJS("particles-js", {
            particles: {
                number: { value: 50, density: { enable: true, value_area: 800 } },
                color: { value: "#ffcc00" },
                shape: {
                    type: ["circle", "edge"],
                    stroke: { width: 0, color: "#000" },
                    polygon: { nb_sides: 5 },
                },
                opacity: { value: 0.5, random: false, anim: { enable: false } },
                size: { value: 20, random: true, anim: { enable: false } },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#ffffff",
                    opacity: 0.4,
                    width: 1,
                },
                move: {
                    enable: true,
                    speed: 6,
                    direction: "none",
                    random: false,
                    straight: false,
                    bounce: false,
                    attract: { enable: false, rotateX: 600, rotateY: 1200 },
                },
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: { enable: true, mode: "grab" },
                    onclick: { enable: true, mode: "push" },
                    resize: true,
                },
                modes: {
                    grab: { distance: 140, line_linked: { opacity: 1 } },
                    bubble: { distance: 400, size: 40, duration: 2, opacity: 8, speed: 3 },
                    repulse: { distance: 200, duration: 1 },
                    push: { particles_nb: 4 },
                    remove: { particles_nb: 2 },
                },
            },
            retina_detect: true,
        });
    </script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
