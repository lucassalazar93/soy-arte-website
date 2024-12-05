<?php
include 'config.php'; // Asegúrate de incluir la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);

    $query = "DELETE FROM productos WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: inventario.php"); // Redirige a la página de inventario después de eliminar
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Solicitud no válida";
}
?>
