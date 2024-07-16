<?php
$servername = "localhost";
$username = "root"; // Cambia esto según tu configuración
$password = ""; // Cambia esto según tu configuración
$dbname = "mi_base_de_datos";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $id_number = $conn->real_escape_string($_POST['id_number']);
    
    $dob_day = $conn->real_escape_string($_POST['dob_day']);
    $dob_month = $conn->real_escape_string($_POST['dob_month']);
    $dob_year = $conn->real_escape_string($_POST['dob_year']);
    $dob = "$dob_year-$dob_month-$dob_day";
    
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (first_name, last_name, id_number, dob, password) VALUES ('$first_name', '$last_name', '$id_number', '$dob', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Registro exitoso";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
