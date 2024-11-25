<?php
session_start();

// Verificar si ya existe el carrito en la sesión
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = []; // Inicializar el carrito si no existe
}

// Función para agregar un producto al carrito
function agregarAlCarrito($producto_id, $nombre, $precio, $cantidad) {
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['producto_id'] == $producto_id) {
            $item['cantidad'] += $cantidad; // Si ya está en el carrito, solo aumenta la cantidad
            return;
        }
    }
    // Si no está en el carrito, agregarlo como nuevo producto
    $_SESSION['carrito'][] = [
        'producto_id' => $producto_id,
        'nombre' => $nombre,
        'precio' => $precio,
        'cantidad' => $cantidad
    ];
}

// Función para eliminar un producto del carrito
function eliminarDelCarrito($producto_id) {
    foreach ($_SESSION['carrito'] as $key => $item) {
        if ($item['producto_id'] == $producto_id) {
            unset($_SESSION['carrito'][$key]); // Eliminar el producto
            break;
        }
    }
}

// Función para actualizar la cantidad de un producto
function actualizarCantidad($producto_id, $cantidad) {
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['producto_id'] == $producto_id) {
            $item['cantidad'] = $cantidad; // Actualizar la cantidad
            return;
        }
    }
}

// Manejar acciones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'agregar':
                agregarAlCarrito($_POST['producto_id'], $_POST['nombre'], $_POST['precio'], $_POST['cantidad']);
                break;
            case 'eliminar':
                eliminarDelCarrito($_POST['producto_id']);
                break;
            case 'actualizar':
                actualizarCantidad($_POST['producto_id'], $_POST['cantidad']);
                break;
        }
    }
    header('Location: carrito.php'); // Redirigir para evitar reenvíos de formulario
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Carrito de Compras</h1>
        <?php if (!empty($_SESSION['carrito'])): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($_SESSION['carrito'] as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                            <td>$<?php echo number_format($item['precio'], 2); ?></td>
                            <td>
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="action" value="actualizar">
                                    <input type="hidden" name="producto_id" value="<?php echo $item['producto_id']; ?>">
                                    <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" class="form-control d-inline" style="width: 80px;">
                                    <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                                </form>
                            </td>
                            <td>$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                            <td>
                                <form method="POST" style="display:inline-block;">
                                    <input type="hidden" name="action" value="eliminar">
                                    <input type="hidden" name="producto_id" value="<?php echo $item['producto_id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php $total += $item['precio'] * $item['cantidad']; ?>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end">Total</td>
                        <td colspan="2">$<?php echo number_format($total, 2); ?></td>
                    </tr>
                </tfoot>
            </table>
        <?php else: ?>
            <p class="text-center">El carrito está vacío.</p>
        <?php endif; ?>
        <div class="text-center mt-4">
            <a href="tienda.php" class="btn btn-secondary">Volver a la Tienda</a>
        </div>
    </div>
</body>
</html>
