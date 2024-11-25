<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
$conn = new mysqli("localhost", "root", "", "db_inventario_tienda_soy_arte");

$query = "SELECT p.nombre, SUM(dv.cantidad) AS total_vendido
          FROM detalle_ventas dv
          JOIN productos p ON dv.producto_id = p.product_id
          GROUP BY p.nombre
          ORDER BY total_vendido DESC";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos Más Vendidos</title>
</head>
<body>
    <h1>Productos Más Vendidos</h1>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Total Vendido</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nombre']}</td>
                    <td>{$row['total_vendido']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
