<?php
// Iniciar sesión y verificar autenticación
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "db_soy_arte_1.0");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Verificar si se pasó un ID de artículo válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = $_GET['id'];

    // Obtener archivos multimedia antes de eliminar el artículo
    $sql = "SELECT imagen, video, audio, musica FROM entradas_blog WHERE post_id = $post_id";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        $articulo = $resultado->fetch_assoc();

        // Eliminar archivos si existen
        foreach (['imagen', 'video', 'audio', 'musica'] as $file) {
            if (!empty($articulo[$file]) && file_exists($articulo[$file])) {
                unlink($articulo[$file]);
            }
        }

        // Eliminar el artículo de la base de datos
        $sql = "DELETE FROM entradas_blog WHERE post_id = $post_id";
        if ($conexion->query($sql) === TRUE) {
            header("Location: admin.php?mensaje=Artículo eliminado correctamente");
            exit();
        } else {
            echo "<p style='color:red;'>Error al eliminar el artículo: " . $conexion->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Artículo no encontrado.</p>";
    }
} else {
    echo "<p style='color:red;'>ID de artículo no válido.</p>";
}

$conexion->close();
?>
