<?php
include 'config.php';

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];
    $imagen_url = '';

    // Manejo de la subida de imágenes
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = basename($_FILES['imagen']['name']); // Nombre del archivo
        $rutaTemporal = $_FILES['imagen']['tmp_name']; // Ruta temporal del archivo
        $directorioDestino = 'img/' . $nombreArchivo; // Ruta destino en el servidor

        // Mover el archivo al directorio de destino
        if (move_uploaded_file($rutaTemporal, $directorioDestino)) {
            $imagen_url = $directorioDestino; // Guardar la ruta de la imagen
        } else {
            echo "Error al subir la imagen.";
        }
    }

    // Insertar los datos en la base de datos
    $query = "INSERT INTO productos (nombre, descripcion, precio, stock, categoria_id, imagen) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdiss", $nombre, $descripcion, $precio, $stock, $categoria_id, $imagen_url);

    if ($stmt->execute()) {
        // Redirigir al inventario
        header("Location: inventario.php");
        exit;
    } else {
        echo "Error al agregar el producto: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conn->close();
}
?>
