<?php
include_once 'config.php';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Soy Arte</title>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/soy-arte-website/css/tienda.css?v=1.3" rel="stylesheet">



</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background: linear-gradient(90deg, #ffc1e3, #ff9dea);">
        <div class="container">
            <a class="navbar-brand text-white" href="#">Soy Arte</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white active" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="tienda.php">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="carrito.php">Carrito</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="contacto.php">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="text-center py-5" style="background: linear-gradient(135deg, #ffe4f1, #ffc1e3); color: white; position: relative; overflow: hidden;">
        <h1 class="display-5 fw-bold">LA MAGIA DE SER MUJER</h1>
        <p class="lead">Explora nuestra colección de accesorios únicos diseñados para mujeres sofisticadas.</p>
        <button class="btn btn-primary btn-lg" style="background-color: #ff9dea; border: none; border-radius: 30px; margin-top: 20px;">Descubrir Productos</button>
        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('imagenes/hero-bg.jpg') no-repeat center; background-size: cover; opacity: 0.2; z-index: -1;"></div>
    </header>
    
    <!-- Contenedor Principal -->
<div class="container mt-5">
    
    <!-- Sección de Productos en Oferta -->
<div class="container mt-5">
    <h2 class="text-center mb-4">🌟 Productos en Oferta 🌟</h2>
    <div class="row">
        <?php
        // Verificar conexión a la base de datos
        if (!isset($conn)) {
            echo "<p class='text-center text-danger'>Error: No se pudo conectar a la base de datos. Por favor, intente más tarde.</p>";
        } else {
            // Consulta para obtener productos en oferta
            $sql_ofertas = "SELECT * FROM productos WHERE oferta = 1 LIMIT 4";
            $result_ofertas = $conn->query($sql_ofertas);

            // Verificar si hay productos en oferta
            if ($result_ofertas && $result_ofertas->num_rows > 0) {
                while ($producto = $result_ofertas->fetch_assoc()) {
                    ?>
                    <div class="col-md-3 mb-4">
                        <div class="card">
                            <!-- Imagen del producto -->
                            <img src="<?php echo htmlspecialchars($producto['imagen']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                            <div class="card-body">
                                <!-- Nombre del producto -->
                                <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                                
                                <!-- Precio normal -->
                                <p class="card-text text-success">
                                    Precio: $<?php echo number_format($producto['precio'], 2, ',', '.'); ?> COP
                                </p>
                                
                                <!-- Precio en oferta -->
                                <p class="card-text text-danger">
                                    Oferta: $<?php echo number_format($producto['precio_oferta'], 2, ',', '.'); ?> COP
                                </p>
                                
                                <!-- Formulario para agregar al carrito -->
                                <form method="POST" action="carrito.php">
                                    <input type="hidden" name="action" value="agregar">
                                    <input type="hidden" name="producto_id" value="<?php echo $producto['product_id']; ?>">
                                    <input type="hidden" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>">
                                    <input type="hidden" name="precio" value="<?php echo $producto['precio_oferta']; ?>">
                                    <input type="number" name="cantidad" value="1" min="1" 
                                           class="form-control mb-2" style="width: 80px;">
                                    <button type="submit" class="btn btn-primary btn-sm">Agregar al Carrito</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                // Mensaje si no hay productos en oferta
                echo "<p class='text-center'>No hay productos en oferta en este momento.</p>";
            }
        }
        ?>
    </div>
</div>


    <!-- Contenido -->
    <div class="container mt-5">
        <!-- Filtros -->
        <form method="GET" action="tienda.php" class="row g-3 mb-4">
            <div class="col-md-4">
                <select name="categoria" class="form-select">
                    <option value="">Todas las Categorías</option>
                    <?php
                    include 'config.php';
                    $query = "SELECT id, nombre FROM categorias";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($categoria = $result->fetch_assoc()) {
                            echo "<option value='" . htmlspecialchars($categoria['id']) . "'>" . htmlspecialchars($categoria['nombre']) . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-5">
                <input type="text" name="busqueda" class="form-control" placeholder="Buscar productos..." value="<?php echo isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            </div>
        </form>

        <!-- Productos -->
        <div class="row">
            <?php
            $categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : '';
            $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
            $sql = "SELECT p.*, c.nombre AS categoria_nombre FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE 1";

            if (!empty($categoria_id)) $sql .= " AND p.categoria_id = ?";
            if (!empty($busqueda)) $sql .= " AND (p.nombre LIKE ? OR p.descripcion LIKE ?)";

            $stmt = $conn->prepare($sql);
            if (!empty($categoria_id) && !empty($busqueda)) {
                $busqueda_param = "%" . $busqueda . "%";
                $stmt->bind_param("iss", $categoria_id, $busqueda_param, $busqueda_param);
            } elseif (!empty($categoria_id)) {
                $stmt->bind_param("i", $categoria_id);
            } elseif (!empty($busqueda)) {
                $busqueda_param = "%" . $busqueda . "%";
                $stmt->bind_param("ss", $busqueda_param, $busqueda_param);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                while ($producto = $result->fetch_assoc()) {
                    echo "<div class='col-md-3 mb-4'>
                            <div class='card'>
                                <img src='" . htmlspecialchars($producto['imagen'] ?: 'img/default_placeholder.png') . "' class='card-img-top' alt='" . htmlspecialchars($producto['nombre']) . "'>
                                <div class='card-body'>
                                    <h5 class='card-title'>" . htmlspecialchars($producto['nombre']) . "</h5>
                                    <p class='card-text'>" . htmlspecialchars($producto['descripcion']) . "</p>
                                    <p class='text-success'>$" . number_format($producto['precio'], 2, ',', '.') . " COP</p>
                                    <form method='POST' action='carrito.php'>
                                        <input type='hidden' name='action' value='agregar'>
                                        <input type='hidden' name='producto_id' value='" . htmlspecialchars($producto['product_id']) . "'>
                                        <input type='hidden' name='nombre' value='" . htmlspecialchars($producto['nombre']) . "'>
                                        <input type='hidden' name='precio' value='" . $producto['precio'] . "'>
                                        <input type='number' name='cantidad' value='1' min='1' class='form-control mb-2' style='width: 80px;'>
                                        <button type='submit' class='btn btn-primary btn-sm'>Agregar al Carrito</button>
                                    </form>
                                </div>
                            </div>
                          </div>";
                }
            } else {
                echo "<p class='text-center'>No se encontraron productos.</p>";
            }
            ?>
        </div>
    </div>

    <?php
// Conexión a la base de datos
include 'config.php'; // Asegúrate de que este archivo esté configurado correctamente

// Consulta para mostrar las reseñas generales
$sql_reseñas_generales = "SELECT nombre_usuario, calificacion, comentario, fecha FROM reseñas_generales ORDER BY fecha DESC";
$result_reseñas = $conn->query($sql_reseñas_generales);

echo "<div class='reseñas'>";
echo "<h2>Reseñas generales:</h2>";
if ($result_reseñas->num_rows > 0) {
    while ($reseña = $result_reseñas->fetch_assoc()) {
        echo "<div class='reseña'>";
        echo "<h3>" . htmlspecialchars($reseña['nombre_usuario']) . " (" . $reseña['calificacion'] . "/5)</h3>";
        echo "<p>" . htmlspecialchars($reseña['comentario']) . "</p>";
        echo "<small>" . htmlspecialchars($reseña['fecha']) . "</small>";
        echo "</div>";
    }
} else {
    echo "<p>No hay reseñas aún. ¡Sé el primero en dejar una reseña!</p>";
}
echo "</div>";
?>

<!-- Formulario para enviar una nueva reseña general -->
<form action="procesar_resena_general.php" method="POST">
    <div>
        <label for="nombre_usuario">Nombre:</label>
        <input type="text" id="nombre_usuario" name="nombre_usuario" required>
    </div>
    <div>
        <label for="calificacion">Calificación (1-5):</label>
        <select id="calificacion" name="calificacion" required>
            <option value="1">1 Estrella</option>
            <option value="2">2 Estrellas</option>
            <option value="3">3 Estrellas</option>
            <option value="4">4 Estrellas</option>
            <option value="5">5 Estrellas</option>
        </select>
    </div>
    <div>
        <label for="comentario">Comentario:</label>
        <textarea id="comentario" name="comentario" rows="4" required></textarea>
    </div>
    <button type="submit">Enviar Reseña</button>
</form>

<!-- Modal Promocional -->
<div id="promoModal" class="promo-modal">
    <div class="promo-modal-content">
        <h2>¡Obtén un 20% de descuento!</h2>
        <p>Regístrate con tu correo electrónico y recibe un 20% de descuento en tu primera compra.</p>
        <button id="registerBtn" class="btn btn-primary">Regístrate ahora</button>
        <span class="promo-close">&times;</span>
    </div>
</div>







    <!-- Footer -->
    <footer class="text-center mt-5 bg-light py-3">
        <p>&copy; 2024 Soy Arte - Todos los derechos reservados.</p>
    </footer>

    <script>
// Mostrar el modal al cargar la página
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("promoModal"); // Seleccionar el modal
    const closeBtn = document.querySelector(".promo-close"); // Botón para cerrar
    const registerBtn = document.getElementById("registerBtn"); // Botón de registro

    // Mostrar el modal después de 3 segundos
    setTimeout(() => {
        modal.style.display = "flex"; // Mostrar modal
    }, 3000);

    // Cerrar el modal al hacer clic en la "x"
    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // Redirigir al usuario a la página de registro al hacer clic en el botón
    registerBtn.addEventListener("click", () => {
        window.location.href = "register.html"; // Redirige a la página de registro
    });

    // Cerrar el modal si el usuario hace clic fuera del contenido
    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
</script>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>