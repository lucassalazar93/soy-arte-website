<?php
require 'config.php';

if ($conn->ping()) {
    echo "¡Conexión exitosa!";
} else {
    echo "Error: " . $conn->error;
}
?>
