<?php
session_start();

// Verificar si la sesión está activa y que el usuario haya iniciado sesión.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");  // Redirige al login si no está autenticado.
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
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_completo'] ?? 'Usuario'); ?>!</h1> 
        <p>Registrado el: 
            <?php 
            if (isset($_SESSION['fecha_registro'])) {
                echo date("d/m/Y", strtotime($_SESSION['fecha_registro']));
            } else {
                echo "Fecha no disponible.";
            }
            ?>
        </p>
        <a href="logout.php" class="btn btn-custom">Cerrar Sesión</a>
    </div>
</body>
</html>
