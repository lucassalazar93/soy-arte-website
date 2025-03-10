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

// Procesar formulario
$mensaje = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $contenido = $conexion->real_escape_string($_POST['contenido']);
    $youtube = $conexion->real_escape_string($_POST['youtube']);

    // Directorio de subida
    $directorio_subida = "uploads/";

    // Imagen
    $imagen = "uploads/default-image.jpg";
    if (!empty($_FILES['imagen']['name'])) {
        $ruta_imagen = $directorio_subida . basename($_FILES["imagen"]["name"]);
        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $ruta_imagen)) {
            $imagen = $ruta_imagen;
        }
    }

    // Video
    $video = "";
    if (!empty($_FILES['video']['name'])) {
        $ruta_video = $directorio_subida . basename($_FILES["video"]["name"]);
        if (move_uploaded_file($_FILES["video"]["tmp_name"], $ruta_video)) {
            $video = $ruta_video;
        }
    }

    // Audio
    $audio = "";
    if (!empty($_FILES['audio']['name'])) {
        $ruta_audio = $directorio_subida . basename($_FILES["audio"]["name"]);
        if (move_uploaded_file($_FILES["audio"]["tmp_name"], $ruta_audio)) {
            $audio = $ruta_audio;
        }
    }

    // Música de fondo
    $musica = "";
    if (!empty($_FILES['musica']['name'])) {
        $ruta_musica = $directorio_subida . basename($_FILES["musica"]["name"]);
        if (move_uploaded_file($_FILES["musica"]["tmp_name"], $ruta_musica)) {
            $musica = $ruta_musica;
        }
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO entradas_blog (titulo, contenido, imagen, video, audio, musica, youtube) 
            VALUES ('$titulo', '$contenido', '$imagen', '$video', '$audio', '$musica', '$youtube')";

    if ($conexion->query($sql) === TRUE) {
        $mensaje = "<div class='alert alert-success'>Artículo agregado correctamente.</div>";
    } else {
        $mensaje = "<div class='alert alert-danger'>Error: " . $conexion->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Artículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>➕ Agregar Nuevo Artículo</h2>
    <?= $mensaje ?>
    <form method="post" enctype="multipart/form-data" class="p-4 border rounded bg-light">
        <div class="mb-3">
            <label for="titulo" class="form-label">Título:</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido:</label>
            <textarea name="contenido" id="contenido" class="form-control" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen de Portada:</label>
            <input type="file" name="imagen" id="imagen" class="form-control">
        </div>
        <div class="mb-3">
            <label for="video" class="form-label">Subir Video:</label>
            <input type="file" name="video" id="video" class="form-control" accept="video/mp4,video/webm">
        </div>
        <div class="mb-3">
            <label for="audio" class="form-label">Subir Audio:</label>
            <input type="file" name="audio" id="audio" class="form-control" accept="audio/mpeg,audio/wav">
        </div>
        <div class="mb-3">
            <label for="musica" class="form-label">Subir Música de Fondo:</label>
            <input type="file" name="musica" id="musica" class="form-control" accept="audio/mpeg,audio/wav">
        </div>
        <div class="mb-3">
            <label for="youtube" class="form-label">Enlace de YouTube:</label>
            <input type="url" name="youtube" id="youtube" class="form-control" placeholder="https://www.youtube.com/watch?v=ID_DEL_VIDEO">
        </div>
        <button type="submit" class="btn btn-success">Publicar</button>
        <a href="admin.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
