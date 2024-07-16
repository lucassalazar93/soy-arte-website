<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['contraseña'])) {
            // Autenticación exitosa
            $_SESSION['user_id'] = $user['User_id'];
            $_SESSION['nombre_completo'] = $user['nombre_completo'];
            header("Location: dashboard.php"); // Redirigir a una página de dashboard o bienvenida
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No se encontró una cuenta con ese email.";
    }

    $conn->close();
}
?>
