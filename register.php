<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);  // Limpiamos el email
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Formato de correo inválido.');
                window.location.href = 'register.html';
              </script>";
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Este usuario ya está registrado.');
                window.location.href = 'register.html';
              </script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (email, contraseña) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Registro exitoso. Redirigiendo al login...');
                    setTimeout(function() {
                        window.location.href = 'login.html';
                    }, 3000);
                  </script>";
        } else {
            echo "<script>alert('Error en el registro: " . htmlspecialchars($conn->error) . "');</script>";
        }
    }

    $stmt->close();
    $conn->close();
}
?>
