<?php
include 'config.php'; // Asegúrate de incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    $query = "SELECT * FROM productos WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Solicitud no válida.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="css/editar_producto.css">

</head>
<body>
    <h1>Editar Producto</h1>
    <form action="procesar_edicion.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($product['nombre']); ?>" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($product['descripcion']); ?></textarea><br>

        <label for="precio">Precio:</label>
        <input type="number" step="0.01" id="precio" name="precio" value="<?php echo htmlspecialchars($product['precio']); ?>" required><br>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required><br>

        <label for="categoria_id">Categoría:</label>
        <select id="categoria_id" name="categoria_id" required>
            <?php
            include 'config.php';
            $categorias = $conn->query("SELECT id, nombre FROM categorias");

            while ($row = $categorias->fetch_assoc()) {
                $selected = $row['id'] == $product['categoria_id'] ? 'selected' : '';
                echo "<option value='" . htmlspecialchars($row['id']) . "' $selected>" . htmlspecialchars($row['nombre']) . "</option>";
            }
            ?>
        </select><br>

        <label for="imagen">Imagen del Producto:</label>
        <?php if (!empty($product['imagen'])): ?>
            <div>
                <img src="<?php echo htmlspecialchars($product['imagen']); ?>" alt="Imagen del Producto" style="max-width: 150px;">
            </div>
        <?php endif; ?>
        <input type="file" id="imagen" name="imagen"><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
