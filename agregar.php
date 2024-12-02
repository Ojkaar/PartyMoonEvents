<?php
session_start(); // Iniciar sesión

// Verificar si el usuario está logueado y si tiene el rol 'admin'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin o no está logueado, redirigir al inicio o a una página de error
    header('Location: inicio.php'); // Redirigir al inicio
    exit(); // Asegurarse de que no se sigue ejecutando el código
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Artículo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">

    <!-- Agregando la librería de Font Awesome para los íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        body {
            background: linear-gradient(to bottom right, #9d91ff, rgba(255, 255, 255, 0.7));
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden; /* Para ocultar el desbordamiento */
        }
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .btn-primary {
            background-color: #9d91ff;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 80px;
            height: auto;
        }
        .container {
            margin: auto; /* Centrar el contenedor */
            width: 100%; /* Ancho completo */
            max-width: 400px; /* Máximo ancho */
        }
        .btn-link {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 0;
        }
        .btn-link i {
            font-size: 24px;
            color: #343a40;
        }
    </style>
</head>
<body>
    <div id="particles-js"></div>
    <div class="container mt-4">
        <div class="form-container">
            <!-- Flecha de regreso -->
            <a href="admin_dashboard.php" class="btn btn-link">
                <i class="fa fa-arrow-left"></i> <!-- Ícono de la flecha -->
                <span class="sr-only">Regresar al Dashboard</span> <!-- Texto accesible solo para lectores de pantalla -->
            </a>

            <a href="inicio.php"><img src="imagenes/Logo.png" alt="Logo" class="logo"></a>
            <h2 class="text-center">Cargar Artículo</h2>
            <form action="cargar_articulo.php" method="POST" enctype="multipart/form-data" class="mt-4">
                <div class="form-group">
                    <label for="tabla">Seleccionar Tabla:</label>
                    <select class="form-control" id="tabla" name="tabla" required>
                        <option value="articulos">Artículos</option>
                        <option value="brincolines">Brincolines</option>
                        <option value="inflables">Inflables</option>
                        <option value="comidas">Comidas</option>
                        <option value="postres">Postres</option>
                        <option value="sillas">Sillas</option>
                        <option value="mesas">Mesas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre del Artículo:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group">
                    <label for="detalles">Detalles:</label>
                    <textarea class="form-control" id="detalles" name="detalles" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="imagen">Imagen:</label>
                    <input type="file" class="form-control-file" id="imagen" name="imagen" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Subir Artículo</button>
            </form>
        </div>
    </div>
    <script>
        particlesJS.load('particles-js', 'particles.json');
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
