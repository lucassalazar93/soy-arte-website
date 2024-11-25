<?php
require 'config.php'; // Conexión a la base de datos

// Consultar categorías para el filtro
$sql_categorias = "SELECT * FROM categorias";
$result_categorias = $conn->query($sql_categorias);

// Consultar productos con filtro opcional por categoría
$categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$sql_productos = "SELECT p.*, c.nombre AS categoria_nombre 
                  FROM productos p 
                  LEFT JOIN categorias c ON p.categoria_id = c.id";

if (!empty($categoria_id)) {
    $sql_productos .= " WHERE p.categoria_id = ?";
    $stmt = $conn->prepare($sql_productos);
    $stmt->bind_param("i", $categoria_id);
    $stmt->execute();
    $result_productos = $stmt->get_result();
} else {
    $result_productos = $conn->query($sql_productos);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - SoyArte</title>
    <!-- Bootstrap y estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/estilos.css" rel="stylesheet">
    <style>
        .text-danger { color: #e74c3c; }
        .bi-fire { font-size: 1.2rem; color: #e74c3c; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Incluir la barra de navegación -->
    <div class="container mt-5">
        <h1 class="text-center">Nuestra Tienda</h1>
        <p class="text-center">Explora nuestros productos por categoría o descubre nuestras promociones.</p>

        <!-- Filtro por Categorías -->
        <form method="GET" action="tienda.php" class="mb-4">
            <div class="row">
                <div class="col-md-4">
                    <select name="categoria" class="form-select">
                        <option value="">Todas las Categorías</option>
                        <?php while ($categoria = $result_categorias->fetch_assoc()): ?>
                            <option value="<?php echo $categoria['id']; ?>" <?php echo ($categoria['id'] == $categoria_id) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categoria['nombre']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </div>
            </div>
        </form>

        <!-- Productos -->
        <div class="row">
            <?php while ($producto = $result_productos->fetch_assoc()): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="img/producto_placeholder.png" class="card-img-top" alt="Producto">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <p class="text-success">$<?php echo number_format($producto['precio'], 2); ?></p>
                            
                            <!-- Indicador de temperatura -->
                            <p class="text-danger">
                                <i class="bi bi-fire"></i> 
                                <strong><?php echo $producto['temperatura']; ?>°</strong> <!-- Mostrar la temperatura -->
                            </p>

                            <form method="POST" action="carrito.php">
                                <input type="hidden" name="action" value="agregar">
                                <input type="hidden" name="producto_id" value="<?php echo $producto['product_id']; ?>">
                                <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                <input type="hidden" name="precio" value="<?php echo $producto['precio']; ?>">
                                <input type="number" name="cantidad" value="1" min="1" class="form-control mb-2" style="width: 80px;">
                                <button type="submit" class="btn btn-primary btn-sm">Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?> <!-- Incluir el pie de página -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
