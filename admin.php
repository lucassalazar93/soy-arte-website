<?php
// Iniciar sesión y verificar si el usuario está autenticado
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html"); // Redirige al login si no está autenticado
    exit();
}

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "db_soy_arte_1.0");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Obtener artículos para administrar
$sql = "SELECT post_id, titulo, imagen, fecha_creacion, video, audio FROM entradas_blog ORDER BY fecha_creacion DESC";
$resultado = $conexion->query($sql);

// Si hay un mensaje en la URL, mostrarlo
$mensaje = isset($_GET['mensaje']) ? htmlspecialchars($_GET['mensaje']) : "";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center">Panel de Administración - Blog Soy Arte</h2>

        <?php if ($mensaje): ?>
            <div class="alert alert-success"><?= $mensaje; ?></div>
        <?php endif; ?>

        <div class="text-end">
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>

        <div class="mt-4">
            <a href="nuevo_articulo.php" class="btn btn-success">➕ Nuevo Artículo</a>
        </div>

        <h3 class="mt-4">Lista de Artículos</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Fecha</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($post = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?= $post['post_id']; ?></td>
                        <td><?= htmlspecialchars($post['titulo']); ?></td>
                        <td><?= date("d/m/Y", strtotime($post['fecha_creacion'])); ?></td>
                        <td><img src="<?= $post['imagen']; ?>" width="100" class="rounded"></td>
                        <td>
                            <a href="editar_articulo.php?id=<?= $post['post_id']; ?>" class="btn btn-warning btn-sm">✏️ Editar</a>
                            <a href="eliminar_articulo.php?id=<?= $post['post_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este artículo?');">🗑️ Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
