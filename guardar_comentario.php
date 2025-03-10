<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "db_soy_arte_1.0");

// Verificar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// Verificar si el formulario fue enviado y si `post_id` es válido
if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
    die("<p style='color: red;'>❌ Error: ID de artículo no válido.</p>");
}

$post_id = (int) $_POST['post_id'];
$nombre = isset($_POST['nombre']) && !empty($_POST['nombre']) ? $conexion->real_escape_string($_POST['nombre']) : 'Anónimo';
$comentario = isset($_POST['comentario']) ? $conexion->real_escape_string($_POST['comentario']) : '';

// Validar que el comentario no esté vacío
if (empty($comentario)) {
    die("<p style='color: red;'>❌ Error: El comentario no puede estar vacío.</p>");
}

// Verificar que la calificación esté entre 1 y 5, estableciendo 5 como valor predeterminado
$calificacion = isset($_POST['calificacion']) ? (int) $_POST['calificacion'] : 5;
if ($calificacion < 1 || $calificacion > 5) {
    $calificacion = 5;
}

// Insertar en la base de datos
$sql = "INSERT INTO comentarios_blog (post_id, nombre, comentario, calificacion, fecha) 
        VALUES ('$post_id', '$nombre', '$comentario', '$calificacion', NOW())";

if ($conexion->query($sql) === TRUE) {
    header("Location: articulo.php?id=$post_id&mensaje=Comentario agregado correctamente");
    exit();
} else {
    echo "<p style='color: red;'>❌ Error al guardar el comentario: " . $conexion->error . "</p>";
}

// Cerrar conexión
$conexion->close();
?>
