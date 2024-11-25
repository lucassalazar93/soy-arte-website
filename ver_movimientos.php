<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
$conn = new mysqli("localhost", "root", "", "db_inventario_tienda_soy_arte");

$query = "SELECT i.movimiento_id, p.nombre AS producto, i.tipo_movimiento, i.cantidad, i.fecha 
          FROM inventario i
          JOIN productos p ON i.producto_id = p.product_id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos de Inventario</title>
</head>
<body>
    <h1>Movimientos de Inventario</h1>
    <table border="1">
        <tr>
            <th>ID Movimiento</th>
            <th>Producto</th>
            <th>Tipo</th>
            <th>Cantidad</th>
            <th>Fecha</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['movimiento_id']}</td>
                    <td>{$row['producto']}</td>
                    <td>{$row['tipo_movimiento']}</td>
                    <td>{$row['cantidad']}</td>
                    <td>{$row['fecha']}</td>
                  </tr>";
        }
        ?>
    </table>
</body>
</html>
