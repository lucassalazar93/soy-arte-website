<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = $conn->real_escape_string($_POST['full_name']);
    $cedula = $conn->real_escape_string($_POST['id_number']);
    $email = $conn->real_escape_string($_POST['email']);
    $dob_day = $conn->real_escape_string($_POST['dob_day']);
    $dob_month = $conn->real_escape_string($_POST['dob_month']);
    $dob_year = $conn->real_escape_string($_POST['dob_year']);
    $fecha_nacimiento = "$dob_year-$dob_month-$dob_day";
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Verificar que la cédula no esté duplicada
    $check_cedula = "SELECT * FROM usuarios WHERE cedula='$cedula' LIMIT 1";
    $result = $conn->query($check_cedula);

    if ($result->num_rows > 0) {
        echo "La cédula ya está registrada.";
    } else {
        $sql = "INSERT INTO usuarios (nombre_completo, cedula, fecha_nacimiento, email, contraseña) VALUES ('$nombre_completo', '$cedula', '$fecha_nacimiento', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registro exitoso";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>
