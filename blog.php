<?php
// 🔹 Conectar a la base de datos (solo una vez)
$conexion = new mysqli("localhost", "root", "", "db_soy_arte_1.0");

// 🔹 Verificar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// 🔹 Obtener total de artículos para paginación
$sqlTotal = "SELECT COUNT(*) AS total FROM entradas_blog";
$resultadoTotal = $conexion->query($sqlTotal);
$totalArticulos = $resultadoTotal->fetch_assoc()['total'];

// 🔹 Paginación
$articulosPorPagina = 6;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $articulosPorPagina;

// 🔹 Obtener artículos con calificación promedio
$sql = "SELECT 
            e.post_id, 
            e.titulo, 
            e.contenido, 
            e.imagen, 
            e.fecha_creacion, 
            e.video, 
            e.audio, 
            IFNULL(AVG(c.calificacion), 0) AS calificacion_promedio
        FROM entradas_blog e
        LEFT JOIN comentarios_blog c ON e.post_id = c.post_id
        GROUP BY e.post_id
        ORDER BY e.fecha_creacion DESC
        LIMIT $articulosPorPagina OFFSET $offset";
$resultado = $conexion->query($sql);

// 🔹 Obtener imágenes para el banner (solo una vez)
$sqlImagenes = "SELECT imagen FROM entradas_blog WHERE imagen IS NOT NULL ORDER BY fecha_creacion DESC LIMIT 5";
$resultadoImagenes = $conexion->query($sqlImagenes);
$imagenes = [];
while ($img = $resultadoImagenes->fetch_assoc()) {
    $imagenes[] = htmlspecialchars($img['imagen']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Soy Arte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/blog.css">
    <style>
        /* 🚀 Banner en Cascada */
        .banner-container {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
            background: black;
        }

        .banner-slide {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: transform 1s ease-in-out, opacity 1s ease-in-out;
        }

        .active {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-up {
            transform: translateY(-100%);
        }

        /* 📌 Título del Blog Centrado */
        .banner-title {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.8);
            z-index: 2;
        }

        .banner-subtitle {
            font-size: 1.5rem;
            font-weight: normal;
        }
    </style>
</head>

<body>

    <!-- 🔵 Banner con Título Centrado -->
    <header>
        <div class="banner-container">
            <!-- 🎯 Título del Blog -->
            <div class="banner-title">
                Blog Soy Arte
                <div class="banner-subtitle">Explora contenido inspirador y educativo</div>
            </div>

            <!-- 🔄 Imágenes en Cascada -->
            <?php foreach ($imagenes as $index => $imagen): ?>
                <img src="<?= $imagen; ?>" class="banner-slide <?= ($index === 0) ? 'active' : ''; ?>" alt="Imagen destacada">
            <?php endforeach; ?>
        </div>
        <button id="toggle-theme">🌙 Modo Oscuro</button>

    </header>


    <div class="container mt-5">
        <div class="row">
            <!-- 📌 COLUMNA PRINCIPAL (8 columnas) -->
            <div class="col-md-8">
                <h2 class="text-center mb-4">Últimos Artículos</h2>

                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <?php while ($post = $resultado->fetch_assoc()): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img src="<?= htmlspecialchars($post['imagen']); ?>" class="card-img-top" alt="<?= htmlspecialchars($post['titulo']); ?>">
                                <div class="card-body">
                                    <p class="text-warning">
                                        <?= str_repeat("⭐", round($post['calificacion_promedio'])) ?>
                                        <span class="text-muted">(<?= number_format($post['calificacion_promedio'], 1); ?>)</span>
                                    </p>
                                    <h5 class="card-title"><?= htmlspecialchars($post['titulo']); ?></h5>
                                    <p class="card-text"><?= substr(htmlspecialchars($post['contenido']), 0, 100) . '...'; ?></p>
                                    <a href="articulo.php?id=<?= $post['post_id']; ?>" class="btn btn-primary mb-2">Leer más</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- 🔴 COLUMNA DERECHA (4 columnas) -->
            <?php include 'seccion_derecha.php'; ?>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Soy Arte. Todos los derechos reservados.</p>
    </footer>

    <!-- 🚀 Script para el Efecto Cascada -->
    <script>
        let slides = document.querySelectorAll(".banner-slide");
        let currentSlide = 0;

        function changeSlide() {
            slides[currentSlide].classList.remove("active");
            slides[currentSlide].classList.add("slide-up");

            currentSlide = (currentSlide + 1) % slides.length;

            slides[currentSlide].classList.remove("slide-up");
            slides[currentSlide].classList.add("active");
        }

        setInterval(changeSlide, 3000); // Cambia cada 3 segundos
    </script>

<script>
    const toggleThemeButton = document.getElementById("toggle-theme");
    const body = document.body;

    // Comprobar si el usuario ya activó el modo oscuro antes
    if (localStorage.getItem("dark-mode") === "enabled") {
        body.classList.add("dark-mode");
        toggleThemeButton.textContent = "☀️ Modo Claro";
    }

    toggleThemeButton.addEventListener("click", () => {
        body.classList.toggle("dark-mode");
        
        // Guardar preferencia en el almacenamiento local
        if (body.classList.contains("dark-mode")) {
            localStorage.setItem("dark-mode", "enabled");
            toggleThemeButton.textContent = "☀️ Modo Claro";
        } else {
            localStorage.setItem("dark-mode", "disabled");
            toggleThemeButton.textContent = "🌙 Modo Oscuro";
        }
    });
</script>


</body>
</html>
