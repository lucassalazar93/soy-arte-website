<?php
// Iniciar la sesión para verificar si el usuario está autenticado
session_start();

// Verificar si el usuario no está autenticado; si no, redirigir al login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Incluir la configuración para conectar con la base de datos
require 'config.php';

// Habilitar depuración temporal para revisar datos enviados por el formulario (desactivar en producción)
/*
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "<pre>";
    print_r($_POST); // Muestra todos los datos enviados por el formulario
    echo "</pre>";
    exit(); // Detener ejecución para revisión
}
*/

// Lógica para agregar un nuevo producto al inventario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "add") {
    // Obtener y limpiar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $categoria_id = intval($_POST['categoria_id']);

    // Validar que todos los campos obligatorios sean válidos
    if (empty($nombre) || empty($descripcion) || $precio <= 0 || $stock <= 0 || $categoria_id <= 0) {
        echo "<script>alert('Todos los campos son obligatorios y deben contener valores válidos.');</script>";
    } else {
        // Preparar la consulta para insertar el nuevo producto
        $sql = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Asociar parámetros y ejecutar la consulta
            $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $categoria_id);
            if ($stmt->execute()) {
                echo "<script>alert('Producto agregado correctamente.');</script>";
                echo "<script>window.location.href = 'gestionar_inventario.php';</script>"; // Recargar página
            } else {
                echo "<script>alert('Error al agregar el producto: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error al preparar la consulta: " . $conn->error . "');</script>";
        }
    }
}

// Lógica para eliminar un producto del inventario
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action']) && $_POST['action'] === "delete") {
    $product_id = intval($_POST['product_id']); // Obtener el ID del producto

    if ($product_id > 0) { // Validar que el ID sea válido
        $sql = "DELETE FROM productos WHERE product_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $product_id); // Asociar el parámetro
            if ($stmt->execute()) {
                echo "<script>alert('Producto eliminado correctamente.');</script>";
                echo "<script>window.location.href = 'gestionar_inventario.php';</script>"; // Recargar página
            } else {
                echo "<script>alert('Error al eliminar el producto: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error al preparar la consulta: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('El ID del producto no es válido.');</script>";
    }
}

// Consultar todos los productos de la base de datos
$sql = "SELECT p.*, c.nombre AS categoria_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id";
$result = $conn->query($sql);

// Consultar todas las categorías disponibles
$sql_categorias = "SELECT id, nombre FROM categorias";
$result_categorias = $conn->query($sql_categorias);

if (!$result_categorias) {
    echo "<script>alert('Error en la consulta de categorías: " . $conn->error . "');</script>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario - SoyArte</title>
    <!-- Fuentes de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #CCA8FF;
            color: #333;
        }
        h1, h2 {
            font-family: 'Playfair Display', serif;
            color: #400036;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            background: linear-gradient(145deg, #ffffff, #f0e6f6);
        }
        .card-header {
            font-size: 1.5rem;
            font-weight: 700;
            background-color: #6c5b7b;
            color: #fff;
            border-bottom: none;
        }
        .btn-primary {
            background-color: #355c7d;
            border-color: #355c7d;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #2a465c;
            border-color: #2a465c;
        }
        .btn-danger {
            background-color: #e84a5f;
            border-color: #e84a5f;
            font-weight: 600;
        }
        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #c0392b;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        .table thead {
            background-color: #6c5b7b;
            color: #ffffff;
        }
        .table tbody tr:hover {
            background-color: #f8eee8;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #ccc;
        }
        footer {
            margin-top: 20px;
            text-align: center;
            color: #999;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestión de Inventario SoyArte</h1>
        
        <!-- Formulario para agregar productos -->
        <div class="card mb-4">
            <div class="card-header text-center">Agregar Producto</div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre del Producto:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio:</label>
                        <input type="number" id="precio" name="precio" step="0.01" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Cantidad en Stock:</label>
                        <input type="number" id="stock" name="stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoria_id" class="form-label">Categoría:</label>
                        <select id="categoria_id" name="categoria_id" class="form-select" required>
                            <option value="">Seleccionar categoría</option>
                            <?php if ($result_categorias && $result_categorias->num_rows > 0): ?>
                                <?php while ($categoria = $result_categorias->fetch_assoc()): ?>
                                    <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nombre']); ?></option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="">No hay categorías disponibles</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Agregar Producto</button>
                </form>
            </div>
        </div>

        <!-- Tabla para mostrar productos -->
        <div class="card">
            <div class="card-header text-center">Lista de Productos</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $row['product_id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                    <td><?php echo htmlspecialchars($row['descripcion']); ?></td>
                                    <td><?php echo $row['precio']; ?></td>
                                    <td><?php echo $row['stock']; ?></td>
                                    <td><?php echo htmlspecialchars($row['categoria_nombre'] ?? 'Sin categoría'); ?></td>
                                    <td>
                                        <form method="POST" style="display:inline-block;">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">No hay productos registrados.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <footer>
            <p>Diseñado por SoyArte &copy; <?php echo date('Y'); ?></p>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
