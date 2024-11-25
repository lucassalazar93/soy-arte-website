<?php
// Iniciar la sesión
session_start();

// Limpiar variables de sesión
$_SESSION = []; // Borra todas las variables de sesión activas
session_unset(); // Libera variables de sesión globales
session_destroy(); // Destruye la sesión completamente

// Redirigir al login
header("Location: login.php");
exit(); // Asegura que el script se detenga aquí
?>
