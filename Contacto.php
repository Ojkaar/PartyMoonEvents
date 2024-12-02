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
    <title>Contáctanos por WhatsApp</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(to bottom right, #9d91ff, rgba(255, 255, 255, 0.7));
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            position: relative;
            overflow: hidden;
            margin: 0;
        }
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .contact-container {
            margin-top: 100px; /* Espacio para que la navbar no tape el formulario */
        }
        .contact-card {
            border: 2px solid #9d91ff;
            border-radius: 8px;
            padding: 20px;
            background-color: white;
            z-index: 1;
        }
        .contact-card h2 {
            color: #9d91ff;
            text-align: center;
        }
        .contact-card button {
            background-color: #25D366;
            border: none;
            color: white;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .contact-card button:hover {
            background-color: #1ebc57;
        }
     
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php
    include 'Navbar.php';
    Navbar::render($usuarioLogueado, $rolUsuario);
    ?>

    <!-- Partículas -->
    <div id="particles-js"></div>

    <!-- Contenedor del formulario de contacto -->
    <div class="container contact-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="contact-card">
                    <h2>Contáctanos por WhatsApp</h2>
                    <form id="contactForm">
                        <div class="form-group">
                            <label for="nombre">Tu nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="mensaje">Tu mensaje:</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje" required></textarea>
                        </div>
                        <button type="button" id="sendBtn">Enviar WhatsApp</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap y Particles.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
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
                    repulse: { distance: 200, duration: 0.4 },
                    push: { particles_nb: 4 },
                    remove: { particles_nb: 2 },
                },
            },
            retina_detect: true,
        });

        document.getElementById('sendBtn').addEventListener('click', function() {
            var nombre = document.getElementById('nombre').value;
            var mensaje = document.getElementById('mensaje').value;
            var telefono = '8122219085';

            if (nombre && mensaje) {
                var url = `https://wa.me/${telefono}?text=Hola, soy ${nombre}, ${mensaje}`;
                window.open(url, '_blank');
            } else {
                alert('Por favor, completa ambos campos antes de enviar el mensaje.');
            }
        });
    </script>
</body>
</html>
