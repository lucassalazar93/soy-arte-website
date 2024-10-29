<?php
session_start();

// Verificar si la sesión está activa y de un mensaje personalizado con la fecha de creacion de la cuenta.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
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
</head>
<body>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_completo']); ?>!</h1> 
        <p>Registrado el: <?php echo date("d/m/Y", strtotime($_SESSION['fecha_registro'])); ?></p>
        <a href="logout.php" class="btn btn-custom">Cerrar Sesión</a>
    </div>
</body>
</html>
