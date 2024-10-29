<?php
// Detalles del servidor de la base de datos
$servername = "127.0.0.1"; // El servidor de la base de datos, generalmente es 'localhost'
$username = "root"; // El nombre de usuario de la base de datos
$password = ""; // La contraseña del usuario de la base de datos
$dbname = "db_soy_arte_1.0"; // El nombre de la base de datos que estás utilizando

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
