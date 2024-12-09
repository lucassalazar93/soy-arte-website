<?php
// Iniciar la sesión para manejar el carrito
session_start();

// Inicializar el carrito en la sesión si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Función para agregar un producto al carrito
function agregarAlCarrito($producto_id, $nombre, $precio, $cantidad) {
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['producto_id'] == $producto_id) {
            $item['cantidad'] += $cantidad; // Incrementar la cantidad si ya está en el carrito
            return;
        }
    }
    // Agregar un nuevo producto al carrito
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
            unset($_SESSION['carrito'][$key]); // Eliminar el producto encontrado
            break;
        }
    }
}

// Función para actualizar la cantidad de un producto en el carrito
function actualizarCantidad($producto_id, $cantidad) {
    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['producto_id'] == $producto_id) {
            $item['cantidad'] = max(1, $cantidad); // Asegurar que la cantidad sea al menos 1
            return;
        }
    }
}

// Manejar las acciones del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'agregar': // Acción para agregar un producto al carrito
            agregarAlCarrito(
                $_POST['producto_id'],
                $_POST['nombre'],
                $_POST['precio'],
                $_POST['cantidad']
            );
            break;
        case 'eliminar': // Acción para eliminar un producto
            eliminarDelCarrito($_POST['producto_id']);
            break;
        case 'actualizar': // Acción para actualizar la cantidad
            actualizarCantidad($_POST['producto_id'], $_POST['cantidad']);
            break;
    }

    // Redirigir para evitar que el formulario se reenvíe al recargar la página
    header('Location: carrito.php');
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
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Hoja de estilos personalizada -->
    <link href="css/carrito.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h2 class="mb-0"><i class="fas fa-shopping-cart"></i> Carrito de Compras</h2>
            </div>
            <div class="card-body">
                <!-- Mostrar el contenido del carrito -->
                <?php if (!empty($_SESSION['carrito'])): ?>
                    <table class="table table-hover">
                        <thead class="table-dark">
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
                                    <td class="align-middle"><?php echo htmlspecialchars($item['nombre']); ?></td>
                                    <td class="align-middle">$<?php echo number_format($item['precio'], 2); ?></td>
                                    <td class="align-middle">
                                        <!-- Formulario para actualizar la cantidad -->
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="actualizar">
                                            <input type="hidden" name="producto_id" value="<?php echo $item['producto_id']; ?>">
                                            <input type="number" name="cantidad" value="<?php echo $item['cantidad']; ?>" min="1" class="form-control d-inline w-25">
                                            <button type="submit" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="align-middle">$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                                    <td class="align-middle">
                                        <!-- Formulario para eliminar un producto -->
                                        <form method="POST" class="d-inline">
                                            <input type="hidden" name="action" value="eliminar">
                                            <input type="hidden" name="producto_id" value="<?php echo $item['producto_id']; ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php $total += $item['precio'] * $item['cantidad']; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td colspan="2" class="fw-bold">$<?php echo number_format($total, 2); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <!-- Mensaje cuando el carrito está vacío -->
                    <div class="alert alert-warning text-center" role="alert">
                        <i class="fas fa-info-circle"></i> El carrito está vacío.
                    </div>
                <?php endif; ?>

                <!-- Botón para volver a la tienda -->
                <div class="text-center mt-4">
                    <a href="tienda.php" class="btn btn-secondary">
                        <i class="fas fa-store"></i> Volver a la Tienda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
