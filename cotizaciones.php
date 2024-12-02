<?php
session_start();


// Verificar si el usuario está logueado
$usuarioLogueado = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : null;
$rolUsuario = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;

require_once('db.php');
 

// Inicializar la variable de productos
$productos = array();

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

// Obtener la tabla seleccionada
$tablaSeleccionada = isset($_POST['tabla']) ? $_POST['tabla'] : null;

// Si se seleccionó una tabla, cargar los productos correspondientes
if ($tablaSeleccionada && array_key_exists($tablaSeleccionada, $tablas)) {
    $query = "SELECT * FROM $tablaSeleccionada";
    $productos = ObtenerRegistros($query);
} else {
    $productos = [];
    foreach ($tablas as $tabla => $nombre) {
        $query = "SELECT * FROM $tabla";
        $productosTemp = ObtenerRegistros($query);
        if (!empty($productosTemp)) {
            $productos = array_merge($productos, $productosTemp);
        }
    }
}

// Filtrar productos
$productos_filtrados = array_filter($productos, function ($producto) {
    return !empty($producto['nombre']);
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización - MoonPartyEvents</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .btn-fixed-bottom {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }

        body {
            padding-bottom: 70px;
        }

        .selected-products {
            border: 2px solid #ccc;
            padding: 15px;
            margin-top: 20px;
        }

        .selected-products ul {
            list-style-type: none;
            padding: 0;
        }

        .selected-products li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
        }

        .btn-add.disabled {
            pointer-events: none;
            opacity: 0.6;
        }
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
<div class="container mt-5">
    <h2>Productos para Cotización</h2>

    <!-- Selección de categoría -->
    <form action="" method="post" class="mb-4">
        <div class="form-group">
            <label for="tabla">Selecciona una categoría:</label>
            <select name="tabla" id="tabla" class="form-control">
                <option value="">Todos</option>
                <?php foreach ($tablas as $tabla => $nombre): ?>
                    <option value="<?= $tabla ?>" <?= ($tabla == $tablaSeleccionada) ? 'selected' : '' ?>><?= $nombre ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Nuevo campo para la fecha -->
        <div class="form-group">
            <label for="fecha">Fecha:</label>
            <input type="date" name="fecha" id="fecha" class="form-control">
        </div>

        <!-- Nuevo campo para la dirección -->
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>

    <div class="row">
        <!-- Lista de productos -->
        <div class="col-md-8">
            <ul class="list-group">
                <?php if (empty($productos_filtrados)): ?>
                    <div class="alert alert-warning">No se encontraron productos.</div>
                <?php else: ?>
                    <?php foreach ($productos_filtrados as $producto): ?>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-2">
                                    <img src="imagenes/<?= htmlspecialchars($producto['url_imagen']) ?>" alt="<?= htmlspecialchars($producto['nombre']) ?>" class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    <strong><?= htmlspecialchars($producto['nombre']) ?></strong>
                                    <p><?= htmlspecialchars($producto['descripcion']) ?></p>
                                </div>
                                <div class="col-md-4 text-right">
                                    <button type="button" class="btn btn-success btn-add" data-id="<?= $producto['id'] ?>" data-name="<?= htmlspecialchars($producto['nombre']) ?>">Agregar</button>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Productos seleccionados -->
        <div class="col-md-4">
            <div class="selected-products">
                <h4>Productos seleccionados</h4>
                <ul id="selectedProductsList"></ul>
            </div>
        </div>
    </div>

    <!-- Botón para enviar la cotización -->
    <button type="button" class="btn btn-primary btn-fixed-bottom" id="sendQuoteButton">Enviar Cotización</button>
</div>

<script>
    const selectedProducts = new Map();

    // Cargar productos seleccionados desde localStorage al iniciar la página
    document.addEventListener('DOMContentLoaded', () => {
        const storedProducts = JSON.parse(localStorage.getItem('selectedProducts')) || [];
        storedProducts.forEach(product => {
            selectedProducts.set(product.id, product.name);
        });
        updateSelectedProducts();

        // Cargar los datos del formulario (fecha y dirección)
        loadFormData();
    });

    // Guardar productos seleccionados en localStorage
    function saveSelectedProducts() {
        const productsArray = Array.from(selectedProducts).map(([id, name]) => ({ id, name }));
        localStorage.setItem('selectedProducts', JSON.stringify(productsArray));
    }

    // Añadir producto a la lista
    document.querySelectorAll('.btn-add').forEach(button => {
        const productId = button.dataset.id;
        if (selectedProducts.has(productId)) {
            button.classList.add('disabled');
            button.textContent = 'Agregado';
        }

        button.addEventListener('click', () => {
            const productName = button.dataset.name;

            if (!selectedProducts.has(productId)) {
                selectedProducts.set(productId, productName);
                saveSelectedProducts();
                updateSelectedProducts();
                button.classList.add('disabled');
                button.textContent = 'Agregado';
            }
        });
    });

    // Eliminar producto de la lista
    function removeProduct(productId) {
        selectedProducts.delete(productId);
        saveSelectedProducts();
        updateSelectedProducts();

        // Restablecer el estado del botón asociado al producto eliminado
        const button = document.querySelector(`.btn-add[data-id='${productId}']`);
        if (button) {
            button.classList.remove('disabled');
            button.textContent = 'Agregar';
        }
    }

    // Actualizar la lista de productos seleccionados
    function updateSelectedProducts() {
        const selectedProductsList = document.getElementById('selectedProductsList');
        selectedProductsList.innerHTML = '';

        selectedProducts.forEach((name, id) => {
            const li = document.createElement('li');
            li.innerHTML = `
                ${name} 
                <button class="btn btn-danger btn-sm" onclick="removeProduct('${id}')">Eliminar</button>
            `;
            selectedProductsList.appendChild(li);
        });
    }

    // Enviar cotización
    // Enviar cotización
document.getElementById('sendQuoteButton').addEventListener('click', () => {
    const productIds = Array.from(selectedProducts.keys());
    const fecha = document.getElementById('fecha').value;
    const direccion = document.getElementById('direccion').value;

    if (productIds.length === 0) {
        alert('No has seleccionado productos.');
        return;
    }

    if (!fecha || !direccion) {
        alert('Por favor, ingresa una fecha y dirección.');
        return;
    }

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'enviar_cotizacion.php';

    // Agregar productos seleccionados
    productIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'productos[]';
        input.value = id;
        form.appendChild(input);
    });

    // Agregar la fecha y dirección al formulario
    const fechaInput = document.createElement('input');
    fechaInput.type = 'hidden';
    fechaInput.name = 'fecha';
    fechaInput.value = fecha;
    form.appendChild(fechaInput);

    const direccionInput = document.createElement('input');
    direccionInput.type = 'hidden';
    direccionInput.name = 'direccion';
    direccionInput.value = direccion;
    form.appendChild(direccionInput);

    document.body.appendChild(form);
    form.submit();

    // Limpiar los datos de localStorage después de enviar la cotización
    localStorage.removeItem('selectedProducts');
    localStorage.removeItem('fecha');
    localStorage.removeItem('direccion');
});


    // Guardar la fecha y dirección en localStorage
    function saveFormData() {
        const fecha = document.getElementById('fecha').value;
        const direccion = document.getElementById('direccion').value;
        localStorage.setItem('fecha', fecha);
        localStorage.setItem('direccion', direccion);
    }

    // Cargar la fecha y dirección desde localStorage
    function loadFormData() {
        const fecha = localStorage.getItem('fecha');
        const direccion = localStorage.getItem('direccion');
        if (fecha) document.getElementById('fecha').value = fecha;
        if (direccion) document.getElementById('direccion').value = direccion;
    }

    // Llamar a la función de carga al hacer submit
    document.querySelector('form').addEventListener('submit', () => {
        saveFormData();
    });

    document.addEventListener('DOMContentLoaded', () => {
    // Obtener el campo de fecha
    const fechaInput = document.getElementById('fecha');

    // Obtener la fecha actual
    const hoy = new Date();

    // Calcular la fecha mínima (10 días adelante)
    const fechaMinima = new Date(hoy);
    fechaMinima.setDate(hoy.getDate() + 10);

    // Formatear la fecha en formato YYYY-MM-DD
    const formatoFecha = fechaMinima.toISOString().split('T')[0];

    // Asignar la fecha mínima al campo
    fechaInput.min = formatoFecha;
});

</script>
<!-- Incluye jQuery (si es necesario para tu versión de Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<!-- Incluye el script de Bootstrap -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

</body>
</html>
