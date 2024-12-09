<?php
include 'config.php';

// Verificar si se recibió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];
    $imagen = $_FILES['imagen'];

    // Inicializar la ruta de la imagen
    $ruta_imagen = null;

    // Manejar la carga de la imagen
    if (!empty($imagen['name'])) {
        $nombre_imagen = basename($imagen['name']);
        $directorio_destino = 'uploads/';
        $ruta_imagen = $directorio_destino . uniqid() . "_" . $nombre_imagen;

        // Mover la imagen al directorio de destino
        if (!move_uploaded_file($imagen['tmp_name'], $ruta_imagen)) {
            echo "Error al subir la imagen.";
            exit;
        }
    }

    // Construir la consulta SQL
    $query = "UPDATE productos 
              SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria_id = ?";
    $params = [$nombre, $descripcion, $precio, $stock, $categoria_id];

    if ($ruta_imagen) {
        $query .= ", imagen = ?";
        $params[] = $ruta_imagen;
    }

    $query .= " WHERE product_id = ?";
    $params[] = $product_id;

    $stmt = $conn->prepare($query);

    // Construir dinámicamente el tipo de parámetros para `bind_param`
    $tipos_parametros = str_repeat("s", count($params) - 1) . "i";
    $stmt->bind_param($tipos_parametros, ...$params);

    if ($stmt->execute()) {
        header("Location: inventario.php?success=1");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Solicitud no válida.";
    exit;
}
?>
