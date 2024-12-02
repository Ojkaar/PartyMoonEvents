<?php
session_start();
session_destroy(); // Destruir la sesión actual
header("Location: inicio.php"); // Redirigir a la página principal
exit();
?>
