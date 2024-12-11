<?php
include 'config.php'; // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar los datos del formulario
    $producto_id = isset($_POST['producto_id']) ? intval($_POST['producto_id']) : 0;
    $nombre_usuario = isset($_POST['nombre_usuario']) ? htmlspecialchars(trim($_POST['nombre_usuario']), ENT_QUOTES, 'UTF-8') : '';
    $calificacion = isset($_POST['calificacion']) ? intval($_POST['calificacion']) : 0;
    $comentario = isset($_POST['comentario']) ? htmlspecialchars(trim($_POST['comentario']), ENT_QUOTES, 'UTF-8') : '';

    // Verificar que todos los campos estén completos
    if ($producto_id > 0 && !empty($nombre_usuario) && $calificacion > 0 && $calificacion <= 5 && !empty($comentario)) {
        // Preparar la consulta para evitar inyección SQL
        $sql_insert = "INSERT INTO reseñas (producto_id, nombre_usuario, calificacion, comentario) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);

        if ($stmt) {
            $stmt->bind_param("isis", $producto_id, $nombre_usuario, $calificacion, $comentario);

            if ($stmt->execute()) {
                // Redirigir al usuario con un mensaje de éxito
                echo "<script>
                    alert('¡Reseña agregada correctamente!');
                    window.location.href = 'tienda.php';
                </script>";
                exit; // Asegurarse de detener la ejecución después de la redirección
            } else {
                // Manejo de errores en la ejecución
                error_log("Error al ejecutar la consulta: " . $stmt->error); // Registrar errores en el log
                echo "<script>
                    alert('Error al agregar la reseña. Inténtalo de nuevo más tarde.');
                    window.history.back();
                </script>";
            }
            $stmt->close();
        } else {
            // Manejo de errores en la preparación de la consulta
            error_log("Error al preparar la consulta: " . $conn->error); // Registrar errores en el log
            echo "<script>
                alert('Error al preparar la consulta. Inténtalo de nuevo más tarde.');
                window.history.back();
            </script>";
        }
    } else {
        // Validación de los campos
        echo "<script>
            alert('Por favor, completa todos los campos correctamente.');
            window.history.back();
        </script>";
    }
}

$conn->close();
?>
