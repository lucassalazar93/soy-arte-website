<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario</title>
    <!-- Fuentes y estilos -->
    <link rel="stylesheet" href="css/inventario.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300&family=Dancing+Script:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Encabezado principal -->
    <header class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Gestión de Inventario-SOY ARTE</h1>
            <p class="hero-subtitle">Discriminacion de inventario para la tienda</p>
        </div>
    </header>

    <!-- Sección: Agregar Producto -->
    <section id="formulario-producto">
        <h2 class="section-title">Agregar Producto</h2>
        <form action="procesar_inventario.php" method="POST" enctype="multipart/form-data">
            <label for="nombre">Nombre del Producto:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="3" required></textarea>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" id="precio" name="precio" required>

            <label for="stock">Cantidad en Stock:</label>
            <input type="number" id="stock" name="stock" required>

            <label for="categoria">Categoría:</label>
            <select id="categoria" name="categoria_id" required>
                <?php
                include 'config.php';
                $query = "SELECT id, nombre FROM categorias";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay categorías disponibles</option>";
                }
                ?>
            </select>

            <label for="imagen">Imagen del Producto:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">

            <button type="submit" class="btn-submit">Agregar Producto</button>
        </form>
    </section>

    <hr>

    <!-- Sección: Tabla de Productos -->
    <section id="listado-productos">
        <h2 class="section-title">Productos en Inventario</h2>
        <table class="inventory-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoría</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Actualización</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $queryProductos = "SELECT p.product_id, p.nombre, p.descripcion, p.precio, p.stock, 
                                          c.nombre AS categoria, 
                                          p.`fecha_creación` AS fecha_creacion, 
                                          p.`fecha_actualización` AS fecha_actualizacion
                                   FROM productos p
                                   LEFT JOIN categorias c ON p.categoria_id = c.id";

                $resultProductos = $conn->query($queryProductos);

                if (!$resultProductos) {
                    echo "<tr><td colspan='9'>Error en la consulta: " . $conn->error . "</td></tr>";
                } elseif ($resultProductos->num_rows > 0) {
                    while ($row = $resultProductos->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['product_id']) . "</td>
                                <td>" . htmlspecialchars($row['nombre']) . "</td>
                                <td>" . htmlspecialchars($row['descripcion']) . "</td>
                                <td>$ " . htmlspecialchars(number_format($row['precio'], 2, ',', '.')) . " COP</td>
                                <td>" . htmlspecialchars($row['stock']) . "</td>
                                <td>" . htmlspecialchars($row['categoria']) . "</td>
                                <td>" . htmlspecialchars($row['fecha_creacion']) . "</td>
                                <td>" . htmlspecialchars($row['fecha_actualizacion']) . "</td>
                                <td>
                                    <form method='POST' action='editar_producto.php' class='action-form'>
                                        <input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>
                                        <button type='submit' class='btn-editar'>Editar</button>
                                    </form>
                                    <form method='POST' action='eliminar_producto.php' class='action-form'>
                                        <input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>
                                        <button type='submit' class='btn-eliminar'>Eliminar</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No hay productos en inventario</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>

</html>
