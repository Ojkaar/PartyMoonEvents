<?php
session_start();
require_once('db.php');

// Verificar si el usuario está logueado
$usuarioLogueado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
$rolUsuario = isset($_SESSION['rol']) ? $_SESSION['rol'] : null; // Obtener el rol del usuario (si está logueado)

// Consulta para obtener artículos de la categoría de inflables
$query_brincolines = "SELECT id, nombre, url_imagen FROM brincolines";
$resultado = ObtenerRegistros($query_brincolines);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renta de Inflables - MoonPartyEvents</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(to bottom right, #9d91ff, rgba(255, 255, 255, 0.7));
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .main-container {
            width: 100%;
            max-width: 1200px;
            z-index: 1;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .main-content {
            padding: 20px;
            text-align: center;
        }

        .category-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            transition: transform 0.3s ease-in-out;
        }

        .card {
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            padding: 15px;
            background: linear-gradient(135deg, #ffffff 30%, #f2f2f2);
            text-align: center;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: bold;
            color: #333;
        }

        footer {
            background-color: #9d91ff;
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
        }

        .section-header {
            font-size: 2rem;
            color: #5a5a5a;
            margin-bottom: 30px;
            font-weight: bold;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

<div id="particles-js"></div>

<?php
include 'Navbar.php';
Navbar::render($usuarioLogueado, $rolUsuario);
?>


<!-- Contenido principal -->
<div class="container mt-5 main-container">
    <div class="main-content">
        <h1 class="section-header">Renta de Brincolines</h1>
        <p class="text-center text-muted">¡Elige entre nuestros brincolines más divertidos para que tu fiesta sea todo un éxito!</p>

        <!-- Sección de categorías -->
        <div class="row">
            <?php foreach ($resultado as $articulo): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <a href="#" onclick="checkLogin(<?= $usuarioLogueado ? "'" . htmlspecialchars($articulo['id']) . "'" : "null" ?>)">
                            <img src="imagenes/<?= htmlspecialchars($articulo['url_imagen']) ?>" class="card-img-top category-image" alt="<?= htmlspecialchars($articulo['nombre']) ?>">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($articulo['nombre']) ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<footer class="text-center mt-5">
    <p>&copy; 2024 MoonPartyEvents. Todos los derechos reservados.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Incluir Particles.js -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script>
    // Configuración de Particles.js
    particlesJS('particles-js', {
        particles: {
            number: { value: 80, density: { enable: true, value_area: 800 } },
            color: { value: "#ffffff" },
            shape: { type: "circle", stroke: { width: 0, color: "#000000" }, polygon: { nb_sides: 5 } },
            opacity: { value: 0.5, random: false, anim: { enable: true, speed: 1, opacity_min: 0.1, sync: false } },
            size: { value: 5, random: true, anim: { enable: true, speed: 40, size_min: 0.1, sync: false } },
            line_linked: { enable: true, distance: 150, color: "#ffffff", opacity: 0.4, width: 1 },
            move: { enable: true, speed: 6, direction: "none", random: false, straight: false, out_mode: "out", bounce: false, attract: { enable: false, rotateX: 600, rotateY: 1200 } }
        },
        interactivity: {
            detect_on: "canvas",
            events: { onhover: { enable: true, mode: "grab" }, onclick: { enable: true, mode: "push" }, resize: true },
            modes: { grab: { distance: 140, line_linked: { opacity: 1 } }, bubble: { distance: 400, size: 40, duration: 2, opacity: 8, speed: 3 }, repulse: { distance: 200, duration: 0.4 }, push: { particles_nb: 4 }, remove: { particles_nb: 2 } }
        },
        retina_detect: true
    });

    // Función para manejar clic en la imagen
    function checkLogin(id) {
        if (id === null) {
            alert("Debes iniciar sesión para ver los detalles.");
        } else {
            window.location.href = 'detalle_brincolines.php?id=' + id;
        }
    }
</script>
</body>
</html>
