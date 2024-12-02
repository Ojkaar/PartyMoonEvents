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
    <title>Panel de Administración - MoonPartyEvents</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    
    <!-- Estilo para el diseño -->
    <style>
        body {
            background: linear-gradient(to bottom right, #9d91ff, rgba(255, 255, 255, 0.7));
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .main-container {
            width: 100%;
            max-width: 900px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
            position: relative;
            z-index: 10; /* Asegúrate de que esté por encima de partículas */
            display: flex;
            flex-direction: column;
            align-items: center; /* Centra el contenido horizontalmente */
        }

        .logo-container {
            display: flex;
            justify-content: center; /* Centra horizontalmente */
            align-items: center;    /* Centra verticalmente */
            margin-bottom: 20px;    /* Espacio debajo del logo */
        }

        .logo {
            max-width: 100%;
            height: auto;
        }

        .button-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            z-index: 10; /* Asegúrate de que esté por encima de partículas */
        }

        .btn-admin {
            font-size: 1.1rem;
            padding: 10px 15px;
            background-color: #9d91ff;
            color: white;
            border: none;
            border-radius: 8px;
            text-align: center;
            transition: background-color 0.3s;
            flex: 1 1 100%; /* Toma todo el ancho en móviles */
        }

        .btn-admin:hover {
            background-color: #7e77cc;
            cursor: pointer; /* Asegúrate de que el cursor cambie en hover */
        }

        /* Fondo de partículas */
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1; /* Debajo del contenido principal */
        }
    </style>
</head>
<body>

<!-- Contenedor principal con logo adentro -->
<div class="container mt-5 main-container">
    <div class="logo-container">
        <a href="inicio.php">
            <img src="imagenes/logo.png" alt="Logo" class="logo">
        </a>
    </div>
    <h1 class="text-center">Bienvenido al Panel de Administración</h1>
    <p class="text-center text-muted">Gestiona los productos y administradores.</p>

    <div class="button-container">
        <!-- Ajuste de botones con href para asegurar clicabilidad -->
        <a href="admin_registro.php" class="btn-admin">Registrar Administrador</a>
        <a href="agregar.php" class="btn-admin">Agregar Producto</a>
        <a href="eliminar.php" class="btn-admin">Eliminar Producto</a>
    </div>
</div>

<!-- Partículas de fondo -->
<div id="particles-js"></div>

<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
    particlesJS.load('particles-js', 'particles.json');
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
