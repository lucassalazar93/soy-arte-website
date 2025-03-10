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

// Verificar si el ID es válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID de artículo no válido.");
}

$post_id = $_GET['id'];

// Obtener el artículo actual
$sql = "SELECT * FROM entradas_blog WHERE post_id = $post_id";
$resultado = $conexion->query($sql);
if ($resultado->num_rows === 0) {
    die("Artículo no encontrado.");
}
$articulo = $resultado->fetch_assoc();

// Procesar actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $contenido = $conexion->real_escape_string($_POST['contenido']);
    $youtube = $conexion->real_escape_string($_POST['youtube']);

    // Directorio de subida
    $directorio_subida = "uploads/";

    // Procesar imagen
    $imagen = $articulo['imagen'];
    if (!empty($_FILES['imagen']['name'])) {
        $ruta_imagen = $directorio_subida . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_imagen)) {
            if (file_exists($articulo['imagen']) && $articulo['imagen'] !== "uploads/default-image.jpg") {
                unlink($articulo['imagen']);
            }
            $imagen = $ruta_imagen;
        }
    }

    // Procesar video
    $video = $articulo['video'];
    if (!empty($_FILES['video']['name'])) {
        $ruta_video = $directorio_subida . basename($_FILES["video"]["name"]);
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $ruta_video)) {
            if (!empty($articulo['video']) && file_exists($articulo['video'])) {
                unlink($articulo['video']);
            }
            $video = $ruta_video;
        }
    }

    // Procesar audio
    $audio = $articulo['audio'];
    if (!empty($_FILES['audio']['name'])) {
        $ruta_audio = $directorio_subida . basename($_FILES["audio"]["name"]);
        if (move_uploaded_file($_FILES["audio"]["tmp_name"], $ruta_audio)) {
            if (!empty($articulo['audio']) && file_exists($articulo['audio'])) {
                unlink($articulo['audio']);
            }
            $audio = $ruta_audio;
        }
    }

    // Procesar música de fondo
    $musica = $articulo['musica'];
    if (!empty($_FILES['musica']['name'])) {
        $ruta_musica = $directorio_subida . basename($_FILES["musica"]["name"]);
        if (move_uploaded_file($_FILES["musica"]["tmp_name"], $ruta_musica)) {
            if (!empty($articulo['musica']) && file_exists($articulo['musica'])) {
                unlink($articulo['musica']);
            }
            $musica = $ruta_musica;
        }
    }

    // Actualizar la base de datos
    $sql = "UPDATE entradas_blog SET 
                titulo = '$titulo', 
                contenido = '$contenido', 
                imagen = '$imagen', 
                video = '$video', 
                audio = '$audio', 
                musica = '$musica', 
                youtube = '$youtube'
            WHERE post_id = $post_id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: admin.php?mensaje=Artículo actualizado correctamente");
        exit();
    } else {
        echo "<p style='color: red;'>Error al actualizar: " . $conexion->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Artículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>✏️ Editar Artículo</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" name="titulo" id="titulo" class="form-control" value="<?= htmlspecialchars($articulo['titulo']); ?>" required>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido:</label>
            <textarea name="contenido" id="contenido" class="form-control" rows="5" required><?= htmlspecialchars($articulo['contenido']); ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen Actual:</label><br>
            <?php if (!empty($articulo['imagen'])): ?>
                <img src="<?= $articulo['imagen']; ?>" width="150"><br><br>
            <?php endif; ?>
            <input type="file" name="imagen" id="imagen" class="form-control">
        </div>

        <div class="mb-3">
            <label for="youtube" class="form-label">Enlace de YouTube:</label>
            <input type="url" name="youtube" id="youtube" class="form-control" value="<?= htmlspecialchars($articulo['youtube']); ?>">
        </div>

        <button type="submit" class="btn btn-success">✅ Guardar Cambios</button>
        <a href="admin.php" class="btn btn-danger">❌ Cancelar</a>
    </form>
</div>

</body>
</html>
