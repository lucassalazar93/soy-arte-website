<?php
// Iniciar la sesión y verificar si el usuario está autenticado
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");  // Redirige al login si no está autenticado
    exit();
}

// Debug (opcional): Mostrar las variables de sesión para verificar
// Eliminar este bloque después de confirmar que todo funciona
/*
echo '<pre>';
print_r($_SESSION);
echo '</pre>';
*/
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
        <!-- Mostrar el nombre completo del usuario -->
        <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_completo'] ?? 'Usuario'); ?>!</h1>

        <!-- Mostrar la fecha de registro -->
        <p>Registrado el: 
            <?php 
            if (!empty($_SESSION['fecha_registro']) && $_SESSION['fecha_registro'] !== 'Fecha desconocida') {
                echo date("d/m/Y", strtotime($_SESSION['fecha_registro']));
            } else {
                echo "Fecha no disponible.";
            }
            ?>
        </p>

        <!-- Botón de cierre de sesión -->
        <a href="logout.php" class="btn btn-custom">Cerrar Sesión</a>
    </div>
</body>
</html>
