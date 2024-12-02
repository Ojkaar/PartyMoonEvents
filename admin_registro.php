<?php

session_start(); // Iniciar sesión

// Verificar si el usuario está logueado y si tiene el rol 'admin'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin o no está logueado, redirigir al inicio o a una página de error
    header('Location: inicio.php'); // Redirigir al inicio
    exit(); // Asegurarse de que no se sigue ejecutando el código
}

$conexion = new mysqli("localhost", "root", "", "rentafiestasdb");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $usuario = $_POST['usuario'];

    // Encriptar la contraseña usando bcrypt
    $contraseña_encriptada = password_hash($contraseña, PASSWORD_BCRYPT);

    // Insertar el administrador en la base de datos
    $query = "INSERT INTO administradores (email, contraseña, usuario) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sss", $email, $contraseña_encriptada, $usuario);

    if ($stmt->execute()) {
        echo "Administrador registrado con éxito.";
    } else {
        echo "Error al registrar administrador: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Administrador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .main-container {
            width: 100%;
            max-width: 600px;
            z-index: 1;
            padding: 20px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .form-control {
            margin-bottom: 15px;
            border-radius: 8px;
        }

        .btn-custom {
            background-color: #9d91ff;
            color: white;
            border-radius: 8px;
            padding: 10px;
            font-size: 1rem;
            width: 100%;
        }

        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 80px;
        }

        .btn-link {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 0;
        }

        .btn-link i {
            font-size: 20px;
            color: #343a40;
        }

        .btn-link span {
            display: none;
        }
    </style>
</head>
<body>

<div id="particles-js"></div>

<div class="container mt-4 main-container">
    <div class="text-center">
        <a href="admin_dashboard.php" class="btn btn-link">
            <i class="fa fa-arrow-left"></i>
            <span class="sr-only">Regresar</span>
        </a>

        <a href="inicio.php"><img src="imagenes/Logo.png" alt="Logo" class="logo"></a>

        <h1 class="section-header">Registrar Administrador</h1>
        <form method="POST">

            <label for="usuario" class="form-label">Usuario:</label>
            <input type="text" id="usuario" name="usuario" class="form-control" required>

            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>

            <label for="contraseña" class="form-label">Contraseña:</label>
            <input type="password" id="contraseña" name="contraseña" class="form-control" required>

            <button type="submit" class="btn btn-custom mt-3">Registrar Administrador</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
    particlesJS.load('particles-js', 'particles.json');
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
