<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $categoria_id = intval($_POST['categoria_id']);

    $query = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria_id = ? WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $stock, $categoria_id, $product_id);

    if ($stmt->execute()) {
        header("Location: inventario.php");
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Solicitud no válida";
}
?>
