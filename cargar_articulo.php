<?php

class Articulo {
    private $conexion;
    private $tabla;

    // Constructor para inicializar la conexión y la tabla
    public function __construct($conexion, $tabla) {
        $this->conexion = $conexion;
        $this->tabla = $tabla; // Establecer la tabla dinámicamente
    }

    // Método para cargar la imagen en el servidor
    public function cargarImagen($imagen) {
        // Directorio donde se guardarán las imágenes
        $directorioDestino = 'imagenes/';
        $nombreImagen = time() . '-' . basename($imagen['name']);
        $rutaDestino = $directorioDestino . $nombreImagen;

        // Validar el tipo de archivo
        $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($ext), $tiposPermitidos)) {
            return "Error: Tipo de archivo no permitido.";
        }

        // Validar el tamaño del archivo (por ejemplo, máximo 2MB)
        if ($imagen['size'] > 2 * 1024 * 1024) {
            return "Error: El archivo es demasiado grande.";
        }

        // Verificar si el archivo se puede mover al directorio destino
        if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
            return $nombreImagen;
        } else {
            return "Error: No se pudo subir la imagen.";
        }
    }

    // Método para insertar un artículo en la base de datos
    public function insertarArticulo($nombre, $detalles, $imagen) {
        // Cargar la imagen
        $urlImagen = $this->cargarImagen($imagen);
        
        if (strpos($urlImagen, "Error") === false) {
            // Preparar la consulta SQL para insertar el artículo
            $query = "INSERT INTO " . $this->tabla . " (nombre, descripcion, url_imagen) 
                      VALUES (?, ?, ?)";
            
            // Preparar la sentencia
            $stmt = $this->conexion->prepare($query);
            $stmt->bind_param("sss", $nombre, $detalles, $urlImagen);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } else {
            return $urlImagen; // Devolver mensaje de error si ocurrió al cargar la imagen
        }
    }
}

// Conectar a la base de datos
$conexion = new mysqli("localhost", "u832510933_MoonDB", "!PartyMoonDB12", "u832510933_PartyMoonDB");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recuperar la tabla seleccionada del formulario
$tablaSeleccionada = $_POST['tabla']; // Esto viene del formulario (campo select)

// Validar que la tabla seleccionada sea válida
$tablasPermitidas = ['articulos', 'brincolines', 'comidas', 'inflables', 'postres', 'sillas', 'mesas'];
if (!in_array($tablaSeleccionada, $tablasPermitidas)) {
    die("Error: Tabla no permitida.");
}

// Crear instancia de la clase Articulo con la tabla seleccionada
$articulo = new Articulo($conexion, $tablaSeleccionada);

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar los datos del formulario
    $nombre = $_POST['nombre'];
    $detalles = $_POST['detalles'];
    $imagen = $_FILES['imagen']; // La imagen viene del formulario

    // Insertar el artículo en la base de datos
    $resultado = $articulo->insertarArticulo($nombre, $detalles, $imagen);

    if ($resultado === true) {
        echo "<script>alert('Articulo insertado correctamente.'); window.location.href = 'inicio.php'</script>";
    } else {
        echo $resultado; // Mostrar el error si ocurrió alguno
    }
}

?>
