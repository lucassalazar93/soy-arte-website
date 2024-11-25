<?php
// Detalles del servidor de la base de datos
$servername = "127.0.0.1"; 
$username = "root"; 
$password = ""; 
$dbname = "db_soy_arte_1.0"; 

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
