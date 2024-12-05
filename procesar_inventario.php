<?php
include 'config.php';

// Capturar los datos del formulario
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$categoria_id = $_POST['categoria_id'];

// Insertar en la base de datos
$query = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id) 
          VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $stock, $categoria_id);

if ($stmt->execute()) {
    echo "Producto agregado exitosamente";
    header("Location: inventario.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
