<?php
session_start(); // Iniciar la sesión
require_once('db.php'); // Asegúrate de que la función ObtenerRegistros esté disponible

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];

    // Buscar el usuario por email en la tabla administradores
    $query_admin = "SELECT * FROM administradores WHERE email = '$email'";
    $resultado_admin = ObtenerRegistros($query_admin);

    // Buscar el usuario por email en la tabla usuarios
    $query_user = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado_user = ObtenerRegistros($query_user);

    // Verificar si el usuario es un administrador
    if (!empty($resultado_admin)) {
        $admin = $resultado_admin[0];

        // Verificar la contraseña
        if (password_verify($contraseña, $admin['contraseña'])) {
            // Almacenar información en la sesión para administrador
            $_SESSION['usuario'] = $admin['usuario'];
            $_SESSION['email'] = $admin['email'];
            $_SESSION['rol'] = 'admin'; // Guardar el rol como admin

            echo "<script>
                alert('Inicio de sesión exitoso. Bienvenido, " . $admin['usuario'] . "');
                window.location.href = 'inicio.php';
              </script>";
        } else {
            echo "<script>alert('Contraseña incorrecta.'); window.location.href = 'login.html';</script>";
        }
    }
    // Verificar si el usuario es un usuario normal
    elseif (!empty($resultado_user)) {
        $user = $resultado_user[0];

        // Verificar la contraseña
        if (password_verify($contraseña, $user['contraseña'])) {
            // Almacenar información en la sesión para usuario
            $_SESSION['usuario'] = $user['usuario'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['rol'] = 'user'; // Guardar el rol como usuario

            echo "<script>
                alert('Inicio de sesión exitoso. Bienvenido, " . $user['usuario'] . "');
                window.location.href = 'inicio.php';
              </script>";
        } else {
            echo "<script>alert('Contraseña incorrecta.'); window.location.href = 'login.html';</script>";
        }
    } else {
        echo "<script>alert('No se encontró una cuenta con ese correo.'); window.location.href = 'login.html';</script>";
    }
}
?>
