<?php
// Conexión a la base de datos
include 'config.php'; // Asegúrate de que este archivo esté configurado correctamente

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar los datos del formulario
    $nombre_usuario = isset($_POST['nombre_usuario']) ? htmlspecialchars(trim($_POST['nombre_usuario'])) : '';
    $calificacion = isset($_POST['calificacion']) ? intval($_POST['calificacion']) : 0;
    $comentario = isset($_POST['comentario']) ? htmlspecialchars(trim($_POST['comentario'])) : '';

    // Verificar que todos los campos estén completos y correctos
    if (!empty($nombre_usuario) && $calificacion > 0 && $calificacion <= 5 && !empty($comentario)) {
        // Preparar la consulta para evitar inyección SQL
        $sql_insert = "INSERT INTO reseñas_generales (nombre_usuario, calificacion, comentario) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql_insert);

        if ($stmt) {
            $stmt->bind_param("sis", $nombre_usuario, $calificacion, $comentario);

            if ($stmt->execute()) {
                // Mostrar mensaje y redirigir a la tienda
                echo "<script>
                    alert('¡Reseña agregada correctamente!');
                    window.location.href = 'tienda.php'; // Redirigir a la tienda
                </script>";
            } else {
                // Manejo de errores en la ejecución
                echo "<script>
                    alert('Error al agregar reseña: " . $stmt->error . "');
                    window.history.back();
                </script>";
            }
            $stmt->close();
        } else {
            // Manejo de errores en la preparación de la consulta
            echo "<script>
                alert('Error al preparar la consulta: " . $conn->error . "');
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
