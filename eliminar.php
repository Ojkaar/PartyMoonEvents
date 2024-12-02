<?php

session_start(); // Iniciar sesión

// Verificar si el usuario está logueado y si tiene el rol 'admin'
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    // Si no es admin o no está logueado, redirigir al inicio o a una página de error
    header('Location: inicio.php'); // Redirigir al inicio
    exit(); // Asegurarse de que no se sigue ejecutando el código
}

class Articulo {
    private $conexion;
    private $tabla = 'articulos';

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function eliminarImagen($nombreImagen) {
        $rutaImagen = 'imagenes/' . $nombreImagen;
        if (file_exists($rutaImagen)) {
            return unlink($rutaImagen);
        }
        return false;
    }

    public function eliminarArticulo($id, $tabla) {
        // Selecciona la tabla correcta
        $query = "SELECT url_imagen FROM " . $tabla . " WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $articulo = $result->fetch_assoc();
            $nombreImagen = $articulo['url_imagen'];

            $this->eliminarImagen($nombreImagen);

            $query = "DELETE FROM " . $tabla . " WHERE id = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }

    public function buscarArticulos($termino = '', $tabla = 'articulos') {
        $query = "SELECT * FROM " . $tabla;
        if (!empty($termino)) {
            $query .= " WHERE nombre LIKE ?";
        }
        $stmt = $this->conexion->prepare($query);

        if (!empty($termino)) {
            $termino = "%" . $termino . "%";
            $stmt->bind_param("s", $termino);
        }

        $stmt->execute();
        return $stmt->get_result();
    }
}

$conexion = new mysqli("localhost", "root", "", "rentafiestasdb");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

$articulo = new Articulo($conexion);

$terminoBusqueda = isset($_GET['buscar']) ? $_GET['buscar'] : '';
$tablaSeleccionada = isset($_GET['tabla']) ? $_GET['tabla'] : 'articulos'; // Tabla seleccionada
$resultados = $articulo->buscarArticulos($terminoBusqueda, $tablaSeleccionada);

if (isset($_GET['id'])) {
    $idArticulo = $_GET['id'];
    $resultado = $articulo->eliminarArticulo($idArticulo, $tablaSeleccionada);

    if ($resultado) {
        header("Location: eliminar.php?status=success&tabla=" . $tablaSeleccionada);
        exit();
    } else {
        header("Location: eliminar.php?status=error&tabla=" . $tablaSeleccionada);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Artículos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
    <link rel="icon" href="imagenes/favicon.ico" type="image/x-icon">
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
            overflow: hidden;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .container {
            margin: auto;
            width: 100%;
            max-width: 900px;
            overflow-y: auto;
            max-height: 90vh;
        }

        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        h2 {
            text-align: center;
            color: #343a40;
            margin-bottom: 20px;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .logo-container {
            text-align: center;
        }

        .btn-link {
            position: absolute;
            top: 20px;
            left: 20px;
            padding: 0; /* Elimina el padding para ajustarse al tamaño del ícono */
        }

        .btn-link i {
            font-size: 24px;
            color: #343a40;
        }

        .btn-link span {
            display: none; /* Oculta el texto */
        }
    </style>
</head>
<body>
<div id="particles-js"></div>
<div class="container">
    <div class="form-container">
        <div class="logo-container">
            <a href="inicio.php" class="logo">
                <img src="imagenes/logo.png" alt="Logo" width="100">
            </a>
        </div>
        <a href="admin_dashboard.php" class="btn btn-link">
            <i class="fa fa-arrow-left"></i> <!-- Solo se muestra el ícono -->
            <span class="sr-only">Regresar</span> <!-- Texto accesible solo para lectores de pantalla -->
        </a>
        <h2>Gestionar Artículos</h2>

        <!-- Formulario para seleccionar tabla -->
        <form method="GET" class="form-inline mb-3">
            <select name="tabla" class="form-control mr-2">
                <option value="articulos" <?= $tablaSeleccionada == 'articulos' ? 'selected' : '' ?>>Artículos</option>
                <option value="inflables" <?= $tablaSeleccionada == 'inflables' ? 'selected' : '' ?>>Inflables</option>
                <option value="brincolines" <?= $tablaSeleccionada == 'brincolines' ? 'selected' : '' ?>>Brincolines</option>
                <option value="comidas" <?= $tablaSeleccionada == 'comidas' ? 'selected' : '' ?>>Comidas</option>
                <option value="postres" <?= $tablaSeleccionada == 'postres' ? 'selected' : '' ?>>Postres</option>
                <option value="sillas" <?= $tablaSeleccionada == 'sillas' ? 'selected' : '' ?>>Sillas</option>
                <option value="mesas" <?= $tablaSeleccionada == 'mesas' ? 'selected' : '' ?>>Mesas</option>
                <!-- Agregar más opciones si es necesario -->
            </select>
            <input type="text" name="buscar" class="form-control mr-2" placeholder="Buscar artículo" value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Imagen</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($resultados) && $resultados->num_rows > 0): ?>
                <?php foreach ($resultados as $articulo): ?>
                    <tr>
                        <td><?= $articulo['id'] ?></td>
                        <td><?= $articulo['nombre'] ?></td>
                        <td><img src="imagenes/<?= $articulo['url_imagen'] ?>" alt="Imagen" width="50"></td>
                        <td>
                            <a href="eliminar.php?id=<?= $articulo['id'] ?>&tabla=<?= $tablaSeleccionada ?>" class="btn btn-danger">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No se encontraron artículos.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    particlesJS.load('particles-js', 'particles.json');
</script>
</body>
</html>
