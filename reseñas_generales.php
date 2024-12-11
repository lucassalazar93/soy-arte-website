<?php
include 'config.php';

$sql = "SELECT nombre_usuario, calificacion, comentario, fecha FROM reseñas_generales ORDER BY fecha DESC";
$result = $conn->query($sql);

echo "<h2>Reseñas Generales:</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div>";
        echo "<h3>" . htmlspecialchars($row['nombre_usuario']) . " (" . $row['calificacion'] . "/5)</h3>";
        echo "<p>" . htmlspecialchars($row['comentario']) . "</p>";
        echo "<small>" . htmlspecialchars($row['fecha']) . "</small>";
        echo "</div><hr>";
    }
} else {
    echo "<p>No hay reseñas aún.</p>";
}

$conn->close();
?>
