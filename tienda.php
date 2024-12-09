<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - Soy Arte</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- CSS Personalizado -->
    <link href="css/tienda.c?v=1.0" rel="stylesheet">
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

    <!-- Footer -->
    <footer class="text-center mt-5 bg-light py-3">
        <p>&copy; 2024 Soy Arte - Todos los derechos reservados.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
