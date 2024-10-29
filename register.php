<?php
require 'config.php';
//usamos javascript para enviar un mensaje emergente con alert, redirigimos automaticamente despues de 3 segundos.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

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
            echo "Error: " . $conn->error;
        }
    }
    $stmt->close();
    $conn->close();
}
?>
