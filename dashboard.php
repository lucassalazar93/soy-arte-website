<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirigir a login si no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_completo']); ?>!</h1>
        <p>Has iniciado sesión exitosamente.</p>
        <a href="logout.php" class="btn btn-custom">Cerrar Sesión</a>
    </div>
</body>
</html>
