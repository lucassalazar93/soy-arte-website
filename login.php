<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Primero busca en la tabla de administradores
        $sqlAdmin = "SELECT * FROM administradores WHERE email = ?";
        $stmt = $conn->prepare($sqlAdmin);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $userType = 'admin';
        } else {
            // Si no está en administradores, busca en usuarios
            $sqlUser = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $conn->prepare($sqlUser);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $userType = 'usuario';
            } else {
                echo "<script>alert('No se encontró una cuenta con ese email.');</script>";
                exit();
            }
        }

        // 🔹 Cambiar 'contraseña' por 'password'
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nombre_completo'] = $user['nombre_completo'];
            $_SESSION['rol'] = $user['rol'];
            $_SESSION['userType'] = $userType;

            // Redirigir según el tipo de usuario
            if ($userType === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta. Inténtalo de nuevo.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Por favor, complete todos los campos.');</script>";
    }

    $conn->close();
}
?>
