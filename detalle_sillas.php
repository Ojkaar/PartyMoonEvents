<?php
session_start();

// Verificar si el usuario está logueado
$usuarioLogueado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
$rolUsuario = isset($_SESSION['rol']) ? $_SESSION['rol'] : null; // Obtener el rol del usuario (si está logueado)

require_once('db.php');

// Verifica si se pasa el parámetro 'id'
// Verifica si se pasa el parámetro 'id'
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Consulta para obtener el artículo en la tabla 'inflables'
    $query_sillas = "SELECT * FROM sillas WHERE id = $id";
    $resultado_sillas = ObtenerRegistros($query_sillas);

   
    // Si no se encuentra el artículo en ninguna de las tablas
    if (
        empty($resultado_sillas)
    ) {
        die("No se encontró el detalle.");
    }
}
else {
    die("ID no especificado.");
}

// Determina qué resultado mostrar
if (!empty($resultado_sillas)) {
    $detalle = $resultado_sillas[0];
}
else {
    // If no details were found, display an error and stop execution
    die("No se encontró el detalle del artículo.");
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Artículo - MoonPartyEvents</title>
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

        header {
            width: 100%;
            background-color: #9d91ff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .main-container {
            width: 100%;
            max-width: 800px;
            z-index: 1;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .article-content {
            padding: 20px;
            text-align: center;
        }

        .article-image {
            width: 60%;
            height: auto;
            max-height: 550px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        h1, h2 {
            color: #333;
        }

        p {
            font-size: 1rem;
            color: #666;
        }

        footer {
            background-color: #9d91ff;
            color: white;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            position: relative;
            bottom: 0;
        }

        .btn-custom {
            background-color: #9d91ff;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            margin-top: 20px;
            text-decoration: none;
        }

        .btn-custom:hover {
            background-color: #7e7ad0;
        }
    </style>
</head>
<body>

<?php
include 'Navbar.php';
Navbar::render($usuarioLogueado, $rolUsuario);
?>



<div id="particles-js"></div>
<!-- Contenido principal -->
<div class="container mt-5 main-container">
    <div class="article-content">
        <h2><?= htmlspecialchars($detalle['nombre']) ?></h2>
        <img src="imagenes/<?= htmlspecialchars($detalle['url_imagen']) ?>" alt="<?= htmlspecialchars($detalle['nombre']) ?>" class="article-image">
        <p><?= htmlspecialchars($detalle['descripcion']) ?></p>

        <!-- Botón de reserva -->
        <a href="cotizaciones.php?id=<?= $detalle['id'] ?>" class="btn-custom">Cotizar</a>
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
            move: { enable: true, speed: 6, direction: "none", random: false, straight: false, out_mode: "out", bounce: false }
        },
        interactivity: {
            detect_on: "canvas",
            events: { onhover: { enable: true, mode: "repulse" }, onclick: { enable: true, mode: "push" }, resize: true }
        },
        retina_detect: true
    });
</script>

</body>
</html>
