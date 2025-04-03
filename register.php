<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['full_name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
    $rol = $_POST['rol'];
    $adminCode = $_POST['admin_code'] ?? ''; // Captura el código si existe

    // 🔒 Código secreto para administradores
    $codigo_secreto = "SOYARTEADMIN123";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<script>alert('Formato de correo inválido.'); window.location.href='register.html';</script>");
    }

    // Validar si intentan registrarse como administrador
    if ($rol === "admin") {
        if ($adminCode !== $codigo_secreto) {
            die("<script>alert('Código incorrecto. No puedes registrarte como administrador.'); window.location.href='register.html';</script>");
        }
        $tabla = "administradores";
    } else {
        $tabla = "usuarios";
    }

    // Verificar si el usuario ya existe en la tabla correspondiente
    $stmt = $conn->prepare("SELECT * FROM $tabla WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Este usuario ya está registrado.'); window.location.href='register.html';</script>";
    } else {
        // Insertar el nuevo usuario o administrador
        $stmt = $conn->prepare("INSERT INTO $tabla (nombre_completo, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $email, $password, $rol);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Registro exitoso. Redirigiendo al login...');
                    window.location.href = 'login.html';
                  </script>";
        } else {
            echo "<script>alert('Error en el registro.');</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
