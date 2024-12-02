<?php

$usuarioLogueado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;


// Incluir la conexión y las funciones
require_once('db.php');  // Asegúrate de que la ruta sea correcta

if (isset($_POST['productos']) && !empty($_POST['productos'])) {
    // Obtener los IDs de los productos seleccionados
    $productos_seleccionados = $_POST['productos'];

    // Obtener la fecha y la dirección del formulario
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
    $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : '';

    // Crear un array con los nombres de los productos seleccionados
    $productos_nombres = [];

    // Definir las tablas disponibles para la selección
    $tablas = [
        'articulos' => 'Artículos',
        'inflables' => 'Inflables',
        'brincolines' => 'Brincolines',
        'comidas' => 'Comidas',
        'postres' => 'Postres',
        'sillas' => 'Sillas',
        'mesas' => 'Mesas'
    ];

    // Recorrer los productos seleccionados
    foreach ($productos_seleccionados as $id_producto) {
        // Determinar de qué tabla proviene el producto
        $tabla = null;
        foreach ($tablas as $nombre_tabla => $nombre) {
            $query = "SELECT id FROM $nombre_tabla WHERE id = " . (int)$id_producto;
            $producto = ObtenerRegistros($query);
            
            // Si el producto existe en la tabla, guardamos la tabla
            if (!empty($producto)) {
                $tabla = $nombre_tabla;
                break;  // Ya encontramos la tabla, no necesitamos seguir buscando
            }
        }

        // Si el producto fue encontrado en alguna tabla
        if ($tabla) {
            // Obtener el nombre del producto
            $query = "SELECT nombre FROM $tabla WHERE id = " . (int)$id_producto;
            $producto = ObtenerRegistros($query);
            
            if (!empty($producto)) {
                $nombre = $producto[0]['nombre'];
                // Añadir el nombre del producto al array de nombres
                $productos_nombres[] = $nombre;
            }
        }
    }

   // Crear el mensaje con los productos separados por comas
if (!empty($productos_nombres)) {
    // Crear una lista ordenada de productos
    $mensaje = "Quiero la cotización de los siguientes productos:\n\n";
    foreach ($productos_nombres as $index => $producto) {
        $mensaje .= ($index + 1) . ". " . $producto . "\n";
    }

    // Añadir la fecha y la dirección al mensaje, si están disponibles
    if (!empty($fecha)) {
        $mensaje .= "\nFecha requerida: $fecha";
    }
    if (!empty($direccion)) {
        $mensaje .= "\nDirección: $direccion";
    }
} else {
    $mensaje = "No se seleccionaron productos válidos.";
}


    // Codificar el mensaje para el enlace de WhatsApp
    $mensaje_codificado = urlencode($mensaje);

    // Número de WhatsApp al que se enviará la cotización (puedes poner tu número aquí)
    $whatsapp_number = '8122219085'; // Cambia esto por tu número de WhatsApp

    // Crear el enlace para WhatsApp
    $whatsapp_link = "https://wa.me/$whatsapp_number?text=$mensaje_codificado";

    // Redirigir al usuario a WhatsApp
    header("Location: $whatsapp_link");
    exit();
} else {
    echo "No se seleccionaron productos.";
}
?>
