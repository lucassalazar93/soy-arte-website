<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "db_soy_arte_1.0");

if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// Verificar si el ID del artículo es válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("❌ Error: ID de artículo no válido.");
}

$post_id = (int) $_GET['id'];

// Obtener el artículo
$sql = "SELECT * FROM entradas_blog WHERE post_id = $post_id";
$resultado = $conexion->query($sql);
if ($resultado->num_rows === 0) {
    die("❌ Error: Artículo no encontrado.");
}
$articulo = $resultado->fetch_assoc();

// Obtener los comentarios
$sqlComentarios = "SELECT nombre, comentario, calificacion, fecha FROM comentarios_blog WHERE post_id = $post_id ORDER BY fecha DESC";
$resultadoComentarios = $conexion->query($sqlComentarios);

// Obtener calificación promedio
$sqlPromedio = "SELECT AVG(calificacion) as promedio FROM comentarios_blog WHERE post_id = $post_id AND calificacion > 0";
$resultadoPromedio = $conexion->query($sqlPromedio);
$promedio = ($resultadoPromedio->num_rows > 0) ? round($resultadoPromedio->fetch_assoc()['promedio'], 1) : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($articulo['titulo']); ?> - Blog Soy Arte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/articulo.css">
    <style>
        .article-header {
            text-align: center;
            padding: 40px 20px;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .article-header h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .article-header .author {
            font-size: 1.2rem;
            font-style: italic;
            opacity: 0.9;
        }
        .separator {
            width: 80px;
            height: 4px;
            background: white;
            margin: 15px auto;
            border-radius: 2px;
        }
        .side-section {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .star-rating {
            font-size: 1.5rem;
            color: gold;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <!-- 🔵 ENCABEZADO MEJORADO -->
    <div class="article-header">
        <h1><?= htmlspecialchars($articulo['titulo']); ?></h1>
        <div class="separator"></div>
        <p class="author">Por <strong><?= htmlspecialchars($articulo['autor'] ?? 'Autor Desconocido'); ?></strong> - Publicado el <?= date("d/m/Y", strtotime($articulo['fecha_actualizacion'])); ?></p>
        
        <!-- ⭐ Calificación Promedio -->
        <div class="mt-2">
            <h5>Calificación del artículo:</h5>
            <p class="star-rating">
                <?= str_repeat("⭐", round($promedio)) . str_repeat("☆", 5 - round($promedio)); ?>
                (<?= $promedio; ?>/5)
            </p>
        </div>
    </div>

    <div class="row">
        <!-- 📌 COLUMNA PRINCIPAL (8 columnas) -->
        <div class="col-md-8">
            <!-- 📸 Imagen Principal -->
            <?php if (!empty($articulo['imagen'])): ?>
                <img src="<?= htmlspecialchars($articulo['imagen']); ?>" class="img-fluid rounded shadow mb-3">
            <?php endif; ?>

            <!-- 📖 Contenido -->
            <article class="p-4 bg-light rounded shadow">
                <p class="text-dark"><?= nl2br(htmlspecialchars($articulo['contenido'])); ?></p>
            </article>

            <!-- 🎥 Video -->
            <?php if (!empty($articulo['video'])): ?>
                <div class="mt-4">
                    <h5>🎥 Video</h5>
                    <video class="w-100 rounded shadow" controls>
                        <source src="<?= htmlspecialchars($articulo['video']); ?>" type="video/mp4">
                    </video>
                </div>
            <?php endif; ?>

            <!-- 🎙️ Audio -->
            <?php if (!empty($articulo['audio'])): ?>
                <div class="mt-4">
                    <h5>🎙️ Audio</h5>
                    <audio class="w-100" controls>
                        <source src="<?= htmlspecialchars($articulo['audio']); ?>" type="audio/mpeg">
                    </audio>
                </div>
            <?php endif; ?>

            <!-- 📺 Video de YouTube -->
            <?php if (!empty($articulo['youtube'])): ?>
                <div class="mt-4">
                    <h5>📺 Video de YouTube</h5>
                    <iframe width="100%" height="315" src="<?= htmlspecialchars($articulo['youtube']); ?>" frameborder="0" allowfullscreen></iframe>
                </div>
            <?php endif; ?>

            <!-- 💬 Sección de Comentarios y Calificación -->
            <div class="bg-white p-3 rounded shadow mt-4">
                <h5>💬 Comentarios y Calificación</h5>
                
                <!-- Mostrar Comentarios -->
                <?php while ($comentario = $resultadoComentarios->fetch_assoc()): ?>
                    <div class="border p-2 rounded mb-2">
                        <strong><?= htmlspecialchars($comentario['nombre'] ?: "Anónimo"); ?></strong> 
                        <small class="text-muted"> - <?= date("d/m/Y", strtotime($comentario['fecha'])); ?></small>
                        <p class="mb-1"><?= nl2br(htmlspecialchars($comentario['comentario'])); ?></p>
                        <p>⭐ Calificación: <?= str_repeat("⭐", $comentario['calificacion']) . str_repeat("☆", 5 - $comentario['calificacion']); ?></p>
                    </div>
                <?php endwhile; ?>

                <!-- Formulario para agregar comentario y calificación -->
                <form method="POST" action="guardar_comentario.php">
                    <input type="hidden" name="post_id" value="<?= $post_id; ?>">
                    
                    <div class="mb-2">
                        <label>Nombre (opcional):</label>
                        <input type="text" name="nombre" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label>Comentario:</label>
                        <textarea name="comentario" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-2">
                        <label>Calificación:</label>
                        <select name="calificacion" class="form-control" required>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="1">⭐</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Enviar Comentario</button>
                </form>
            </div>
        </div>

        <!-- 🔴 COLUMNA DERECHA: Sección adicional -->
        <?php include 'seccion_derecha.php'; ?>
    </div>
</div>
