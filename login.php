<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitizar entrada de datos
    $email = trim($_POST['email']); // Elimina espacios al inicio y final
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Usar prepared statements para evitar inyección SQL
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();

                // Verificar la contraseña
                if (password_verify($password, $user['contraseña'])) {
                    // Autenticación exitosa
                    $_SESSION['user_id'] = $user['User_id'];
                    $_SESSION['nombre_completo'] = !empty($user['nombre_completo']) ? $user['nombre_completo'] : 'Usuario'; // Valor predeterminado si está vacío
                    $_SESSION['fecha_registro'] = !empty($user['fecha_registro']) ? $user['fecha_registro'] : 'Fecha desconocida';

                    // Redirigir al dashboard
                    header("Location: dashboard.php");
                    exit();
                } else {
                    // Contraseña incorrecta
                    echo "<script>alert('Contraseña incorrecta. Inténtalo de nuevo.');</script>";
                }
            } else {
                // Usuario no encontrado
                echo "<script>alert('No se encontró una cuenta con ese email.');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Error en la consulta. Inténtalo más tarde.');</script>";
        }
    } else {
        echo "<script>alert('Por favor, complete todos los campos.');</script>";
    }

    $conn->close();
}
?>
