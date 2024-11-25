<?php
$conn = new mysqli("localhost", "root", "", "db_inventario_tienda_soy_arte");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$producto_id = $_POST['producto_id'];
$tipo_movimiento = $_POST['tipo_movimiento'];
$cantidad = $_POST['cantidad'];

// Insertar el movimiento en la tabla inventario
$query_movimiento = "INSERT INTO inventario (producto_id, tipo_movimiento, cantidad) 
                     VALUES (?, ?, ?)";
$stmt = $conn->prepare($query_movimiento);
$stmt->bind_param("isi", $producto_id, $tipo_movimiento, $cantidad);
$stmt->execute();

// Actualizar el stock en la tabla productos
if ($tipo_movimiento == 'entrada') {
    $query_update_stock = "UPDATE productos SET stock = stock + ? WHERE product_id = ?";
} else if ($tipo_movimiento == 'salida') {
    $query_update_stock = "UPDATE productos SET stock = stock - ? WHERE product_id = ?";
}
$stmt_update = $conn->prepare($query_update_stock);
$stmt_update->bind_param("ii", $cantidad, $producto_id);
$stmt_update->execute();

echo "Movimiento registrado y stock actualizado correctamente.";
$conn->close();
?>
