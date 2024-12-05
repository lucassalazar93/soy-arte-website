<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOYARTE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <?php
// Inicia la sesión para acceder a las variables de $_SESSION
session_start();

// Calcula la cantidad total de productos en el carrito
// Si no hay carrito, se define como 0
$carrito_count = isset($_SESSION['carrito']) ? array_sum(array_column($_SESSION['carrito'], 'cantidad')) : 0;
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <!-- Contenedor general para la barra de navegación -->
    <div class="container">

        <!-- Logo de la página con enlace -->
        <a href="index.php" class="navbar-brand">
            <img src="img/Logo_Morado.png" alt="Logo" height="70" width="60">
        </a>

        <!-- Botón para colapsar la barra en pantallas pequeñas -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarS"
            aria-controls="navbarS" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Contenido de la barra de navegación -->
        <div class="collapse navbar-collapse" id="navbarS">
            <!-- Lista de navegación -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                <!-- Enlace a Inicio -->
                <li class="nav-item">
                    <a href="index.php" class="nav-link">Inicio</a>
                </li>

                <!-- Menú desplegable: Menú -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="menuDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Menú
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="menuDropdown">
                        <li><a class="dropdown-item" href="#">Nuestro Origen</a></li>
                        <li><a class="dropdown-item" href="#">Historia</a></li>
                        <li><a class="dropdown-item" href="#">Registro</a></li>
                        <li><a class="dropdown-item" href="#">Testimonios</a></li>
                        <li><a class="dropdown-item" href="#">Contáctanos</a></li>
                    </ul>
                </li>

                <!-- Enlace a Mujeres -->
                <li class="nav-item">
                    <a href="#" class="nav-link">Mujeres</a>
                </li>

                <!-- Enlace a Tendencias -->
                <li class="nav-item">
                    <a href="#" class="nav-link">Tendencias</a>
                </li>

                <!-- Menú desplegable: Tienda -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="tiendaDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Tienda
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="tiendaDropdown">
                        <li><a class="dropdown-item" href="tienda.php">Todos los Productos</a></li>
                        <li><a class="dropdown-item" href="tienda.php?categoria=1">Accesorios</a></li>
                        <li><a class="dropdown-item" href="tienda.php?categoria=2">Belleza</a></li>
                        <li><a class="dropdown-item" href="tienda.php?categoria=3">Hogar</a></li>
                    </ul>
                </li>

                <!-- Enlace a Registro -->
                <li class="nav-item">
                    <a href="register.html" class="nav-link">Registro</a>
                </li>

                <!-- Enlace a Login -->
                <li class="nav-item">
                    <a href="login.html" class="nav-link">Login</a>
                </li>

                <!-- Botón del Carrito -->
                <li class="nav-item">
                    <a href="carrito.php" class="nav-link btn btn-outline-primary position-relative">
                        🛒 Carrito
                        <!-- Muestra el contador solo si hay productos en el carrito -->
                        <?php if ($carrito_count > 0): ?>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <?php echo $carrito_count; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>
 <!-- aqui finaliza el menu de navegacion -->

    <div id="caruselE" class="carousel slide" data-bs-ride="carousel">
        <!-- aqui va el carrusel botones de funcion-flechas -->

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#caruselE" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="slide 1"></button>

            <button type="button" data-bs-target="#caruselE" data-bs-slide-to="1" aria-current="true"
                aria-label="slide 2"></button>

            <button type="button" data-bs-target="#caruselE" data-bs-slide-to="2" aria-current="true"
                aria-label="slide 3"></button>

            <button type="button" data-bs-target="#caruselE" data-bs-slide-to="3" aria-current="true"
                aria-label="slide 4"></button>

            <button type="button" data-bs-target="#caruselE" data-bs-slide-to="4" aria-current="true"
                aria-label="slide 5"></button>


        </div>

        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="img/banner (4).png" class="d-block w-100" alt=""> <!-- imagenes de carrusel -->
                <div class="carousel-caption">
                    <h5>ENCUENTRA LA PAZ INTERIOR</h5> <!-- titulo sobre la imagen -->
                    <p>
                        "Sumérgete en un viaje hacia la serenidad y descubre herramientas y recursos que te guiarán
                        hacia un estado de paz interior y equilibrio, transformando tu vida con cada paso que das."
                    </p>
                    <a href="#" class="btn btn-custom mt-3">mas informacion</a> <!-- boton y enlace sobre la imagen -->
                </div>
            </div>

            <div class="carousel-item">
                <img src="img/banner (3).png" class="d-block w-100" alt=""> <!-- imagenes de carrusel -->
                <div class="carousel-caption">
                    <h5>RELACIONES SANAS, CORAZONES FUERTES</h5> <!-- titulo sobre la imagen -->
                    <p>
                        "Explora cómo cultivar relaciones significativas que fortalezcan tu corazón y enriquezcan tu
                        vida, guiándote hacia un bienestar emocional duradero y conexiones profundas."
                    </p>
                    <a href="#" class="btn btn-custom mt-3">mas informacion</a> <!-- boton y enlace sobre la imagen -->
                </div>
            </div>

            <div class="carousel-item">
                <img src="img/banner (7).png" class="d-block w-100" alt=""> <!-- imagenes de carrusel -->
                <div class="carousel-caption">
                    <h5>SABOR Y SALUD EN CADA MORDISCO</h5> <!-- titulo sobre la imagen -->
                    <p>
                        "Descubre nuestra colección de recetas que combinan el sabor irresistible con ingredientes
                        saludables, diseñadas para nutrir cuerpo y alma con cada bocado. Sumérgete en la terapia
                        culinaria y disfruta de una experiencia gastronómica que alimenta más que solo el cuerpo."
                    </p>
                    <a href="#" class="btn btn-custom mt-3">mas informacion</a> <!-- boton y enlace sobre la imagen -->
                </div>
            </div>

            <div class="carousel-item">
                <img src="img/banner (1).png" class="d-block w-100" alt="">
                <div class="carousel-caption">
                    <h5>ENCUENTRA LO QUE TE EMPODERA</h5>
                    <p>"Explora nuestra colección de productos pensados para fortalecer tu día a día, ofreciéndote
                        opciones que te empoderan y complementan tu vida con cada elección que haces."</p>
                    <a href="#" class="btn btn-custom mt-3">Más información</a>
                </div>

            </div>
            <div class="carousel-item">
                <img src="img/banner (8).png" class="d-block w-100" alt="">
                <div class="carousel-caption">
                    <h5>MUJERES QUE DEJAN HUELLA</h5>
                    <p>"Descubre las historias de mujeres valientes y visionarias que desafían el status quo y marcan un
                        camino de inspiración y cambio."</p>
                    <a href="#" class="btn btn-custom mt-3">Más información</a>
                </div>
            </div>
        </div>





    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#caruselE" data-bs-slide="prev">

        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">previous</span> <!-- flechas botones -->

    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#caruselE" data-bs-slide="next">

        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">next</span>

    </button>

    </div>

    <section class="about section-padding">

        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="about-img">
                        <img src="img/IMG_8947.JPEG" class="img-fluid rounded-image" alt="">

                    </div>
                </div>
                <div class="col-lg-8 col-md-12 col-12 ps-lg-5 mt-md-5">
                    <div class="about-text text-white text-center">
                        <h2 class="soyarte text-center">
                            <img src="img/Logo_Morado.png" alt="Logo" height="200">
                        </h2>
                        <p class="my-3">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Provident aperiam ipsam voluptas,
                            adipisci possimus architecto neque quae consequatur saepe. Dolor deserunt ab ducimus.
                            Recusandae numquam cupiditate quo, repudiandae dignissimos quas sapiente obcaecati itaque
                            amet cumque voluptas iusto! Aperiam aut adipisci nam neque harum ratione ullam incidunt,
                            esse repellat facilis, reiciendis accusamus atque veritatis nulla optio itaque corrupti quas
                            quos impedit voluptas ex repellendus. Consequatur placeat fugiat perspiciatis aliquid
                            distinctio eius pariatur laborum, nesciunt architecto, saepe quae molestiae accusamus
                            accusantium nobis, dolorum blanditiis officiis doloribus earum! Error esse possimus,
                            quibusdam nobis blanditiis saepe tempora itaque, dicta in libero quisquam vero optio nostrum
                            recusandae porro ipsum ducimus. Quia blanditiis cumque sint dignissimos dolorum repudiandae
                            reiciendis ut voluptatibus dolorem, consectetur, incidunt minima aut.
                        </p>
                        <a href="#" class="btn btn-custom ">mas informacion</a>

                    </div>

                </div>
            </div>
        </div>
        <!-- contenedor de imagenes  -->
        <div class="container my-5">
            <div class="row">
                <div class="col-3 col-md-3 col-lg-3">
                    <div class="card text-center" style="width: 18rem;">
                        <img src="img/foto-4.png" class="card-img-top" alt="Terapia Culinaria">
                        <div class="card-body">
                            <h5 class="card-title" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Terapia
                                Culinaria</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Mas informacion</a>
                        </div>
                    </div>
                </div>

                <div class="col-3 col-md-3 col-lg-3">
                    <div class="card text-center" style="width: 18rem;">
                        <img src="img/estres.png" class="card-img-top" alt="Control del estrés">
                        <div class="card-body">
                            <h5 class="card-title" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Control del
                                estrés</h5>
                            <p class="card-text">Some quick example text to build on the card to build on the card to
                                build on the card Some quick example text to build on the cardtitle and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Mas informacion</a>
                        </div>
                    </div>
                </div>

                <div class="col-3 col-md-3 col-lg-3">
                    <div class="card text-center" style="width: 18rem;">
                        <img src="img/senos.png" class="card-img-top" alt="¿Por qué las mujeres se aumentan los senos?">
                        <div class="card-body">
                            <h5 class="card-title" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">¿Por qué las
                                mujeres se aumentan los senos?</h5>
                            <p class="card-text">Some quick Some quick example text to build on the card example text to
                                build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Mas informacion</a>
                        </div>
                    </div>
                </div>

                <div class="col-3 col-md-3 col-lg-3">
                    <div class="card text-center" style="width: 18rem;">
                        <img src="img/foto-1.png" class="card-img-top" alt="Secretos para ser perfecta">
                        <div class="card-body">
                            <h5 class="card-title" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">Secretos para
                                ser perfecta</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk
                                of the card's content.</p>
                            <a href="#" class="btn btn-primary">Mas informacion</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </section>

    <section class="nore my-5">
        <div class="container">
            <div class="row">

                <div class="col-md-8 order-md-1">
                    <h2 class="text-center">Norella M. Quintero</h2>
                    <p class="text-center">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusamus vitae id vel consequatur
                        perspiciatis sed molestiae explicabo, commodi reprehenderit enim animi atque et ad quam eos unde
                        distinctio repudiandae veniam? Maxime laudantium animi possimus eligendi sit molestiae vero.
                        Minima dolorem asperiores delectus cupiditate sequi placeat quia. Natus nostrum nam aperiam quas
                        repudiandae libero commodi cupiditate quae necessitatibus, quibusdam quos, aliquid vero illum
                        excepturi fugit, itaque laborum? Molestiae architecto odio rem odit assumenda nostrum veniam.
                        Facilis aliquid inventore adipisci laborum provident expedita, cum reiciendis perspiciatis
                        excepturi blanditiis eligendi consectetur consequuntur explicabo aliquam, doloremque, fugit
                        beatae repellendus! Incidunt, accusantium tenetur. Sint iusto nam expedita dolores repellendus
                        cumque facere doloribus molestias quos quia sapiente atque delectus exercitationem maxime
                        ratione rerum nobis, porro corporis, voluptatum ab consectetur eum consequatur dolorem? Quos
                        excepturi exercitationem dolores porro nemo, dolor odit aspernatur doloribus voluptate! Atque
                        quis sunt odio aut optio facilis sapiente, velit inventore itaque consequuntur, beatae
                        doloremque dolor ipsam eum ex molestias, ea amet voluptas? Nulla consequuntur perspiciatis aut
                        debitis culpa enim nobis iste illo minima quo inventore, ut quod quam quibusdam itaque alias
                        nemo animi!
                    </p>
                </div>

                <div class="col-md-4 order-md-2">
                    <img src="img/IMG_3291.JPEG" alt="nore2" class="img-fluid">
                </div>

            </div>
        </div>
    </section>



    <!-- Contenedor de imágenes  promociones-->
    <section class="promociones section-padding">
        <div class="container my-3">
            <h2 class="promo text-center my-5">PROMOCIONES</h2>
            <div class="row">
                <div class="col-12 col-md-3 col-lg-3">
                    <div class="card promo-card text-center" style="width: 18rem;">
                        <div class="promo-header">50% de Descuento</div>
                        <img src="img/prod-1.png" class="card-img-top" alt="producto 1">
                        <div class="card-body">
                            <h5 class="card-title" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">PRODUCTO 1</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            <a href="#" class="btn btn-primary">COMPRAR AHORA</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-lg-3">
                    <div class="card promo-card text-center" style="width: 18rem;">
                        <div class="promo-header">30% de Descuento</div>
                        <img src="img/prod-2.png" class="card-img-top" alt="producto 2">
                        <div class="card-body">
                            <h5 class="card-title" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">PRODUCTO 2</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                            <a href="#" class="btn btn-primary">COMPRAR AHORA</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-lg-3">
                    <div class="card promo-card text-center" style="width: 18rem;">
                        <div class="promo-header">20% de Descuento</div>
                        <img src="img/prod-3.png" class="card-img-top" alt="producto 3">
                        <div class="card-body">
                            <h5 class="card-title" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">PRODUCTO 3</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit..</p>
                            <a href="#" class="btn btn-primary">COMPRAR AHORA</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-3 col-lg-3">
                    <div class="card promo-card text-center" style="width: 18rem;">
                        <div class="promo-header">40% de Descuento</div>
                        <img src="img/producto4.png" class="card-img-top" alt="producto 4">
                        <div class="card-body">
                            <h5 class="card-title" style="text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">PRODUCTO 4</h5>
                            <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                            <a href="#" class="btn btn-primary">COMPRAR AHORA</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

        <div class="boton text-center">
            <a href="https://www.youtube.com/watch?v=L_rTcQo8BUs">
                <img src="img/TIENDA.png" alt="boton">
            </a>
        </div>

    </section> 
    <h2 class="collage text-center bg-custom text-custom my-4">LA MAGIA DE SER MUJER</h2>



    <section class="collage full-screen-image my-5">
        <img src="img/A4 horizontal collage familia beige.png" alt="Collage">
    </section>

<!-- preguntas frecuentes-->
<section class="faq section-padding">
    <div class="container">
        <h2 class="text-center my-4">PREGUNTAS FRECUENTES</h2>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        ¿Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        ¿Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        ¿Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        ¿Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        ¿Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.</p>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                        ¿Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.?
                    </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                    data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Labore, non.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    





<section class="team section-padding bg-custom-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header text-center text-white pb-5">
                    <h2>ASESORES</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima perspiciatis, aliquid
                        quidem
                        provident eos sequi ipsum obcaecati, et beatae saepe dolorem voluptates maiores eaque
                        voluptatibus molestiae cupiditate, sunt sed harum! Suscipit accusantium voluptatibus
                        officiis aliquid.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-center bg-custom-card">
                    <div class="card-body text-white">
                        <img src="img/perfil (1).png" class="img-fluid rounded-circle" alt="">
                        <h3 class="card-title py-2">maria</h3>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque quo modi animi,
                            iusto
                            maiores rerum ipsam esse laboriosam numquam
                        </p>
                        <p class="socials">
                            <i class="bi bi-twitter text-white mx-1"></i>
                            <i class="bi bi-facebook text-white mx-1"></i>
                            <i class="bi bi-linkedin text-white mx-1"></i>
                            <i class="bi bi-instagram text-white mx-1"></i>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-center bg-custom-card">
                    <div class="card-body text-white">
                        <img src="img/perfil (2).png" class="img-fluid rounded-circle" alt="">
                        <h3 class="card-title py-2">daniela</h3>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque quo modi animi,
                            iusto
                            maiores rerum ipsam esse laboriosam numquam
                        </p>
                        <p class="socials">
                            <i class="bi bi-twitter text-white mx-1"></i>
                            <i class="bi bi-facebook text-white mx-1"></i>
                            <i class="bi bi-linkedin text-white mx-1"></i>
                            <i class="bi bi-instagram text-white mx-1"></i>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-center bg-custom-card">
                    <div class="card-body text-white">
                        <img src="img/perfil (3).png" class="img-fluid rounded-circle" alt="">
                        <h3 class="card-title py-2">camila</h3>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque quo modi animi,
                            iusto
                            mayores rerum ipsam esse laboriosam numquam
                        </p>
                        <p class="socials">
                            <i class="bi bi-twitter text-white mx-1"></i>
                            <i class="bi bi-facebook text-white mx-1"></i>
                            <i class="bi bi-linkedin text-white mx-1"></i>
                            <i class="bi bi-instagram text-white mx-1"></i>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card text-center bg-custom-card">
                    <div class="card-body text-white">
                        <img src="img/perfil (4).png" class="img-fluid rounded-circle" alt="">
                        <h3 class="card-title py-2">lorena</h3>
                        <p class="card-text">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eaque quo modi animi,
                            iusto
                            maiores rerum ipsam esse laboriosam numquam
                        </p>
                        <p class="socials">
                            <i class="bi bi-twitter text-white mx-1"></i>
                            <i class="bi bi-facebook text-white mx-1"></i>
                            <i class="bi bi-linkedin text-white mx-1"></i>
                            <i class="bi bi-instagram text-white mx-1"></i>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="contact section-padding bg-custom-section">
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header text-center text-white pb-5">
                    <h2>CONTACTANOS</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Similique in vel quos
                        provident,
                        nam neque aliquam. Rem deserunt neque veniam accusamus quasi odit quidem adipisci
                        dignissimos, quae, officiis placeat, <br> iusto sapiente quos! Libero, asperiores
                        dolores
                    </p>
                </div>
            </div>
        </div>

        <div class="row m-0">
            <div class="col-md-12 p-0 pt-4 pb-4">
                <form action="#" class="bg-custom-form p-4 m-auto">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="text" class="form-control" placeholder="nombre">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="correo">
                                <!-- espacios para rellenar datos -->
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <textarea class="form-control" placeholder="mensaje" rows="3"></textarea>
                            </div>
                        </div>
                        <button class="btn btn-custom btn-lg btn-block mt-3">enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<footer class="custom-footer text-white pt-5 pb-4">
    <div class="container text-center text-md-left">
        <div class="row text-center text-md-left">
            <!-- Información de Contacto -->
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-custom">Soy Arte</h5>
                <p>
                    Dirección: Calle Falsa 123<br>
                    Teléfono: +123 456 7890<br>
                    Correo: contacto@soyarte.com
                </p>
            </div>
            <!-- Enlaces Rápidos -->
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-custom">Enlaces Rápidos</h5>
                <p><a href="#" class="text-white" style="text-decoration: none;">Inicio</a></p>
                <p><a href="#" class="text-white" style="text-decoration: none;">Sobre Nosotros</a></p>
                <p><a href="#" class="text-white" style="text-decoration: none;">Servicios</a></p>
                <p><a href="#" class="text-white" style="text-decoration: none;">Blog</a></p>
                <p><a href="#" class="text-white" style="text-decoration: none;">Contacto</a></p>
            </div>
            <!-- Redes Sociales -->
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-custom">Síguenos</h5>
                <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white"><i class="bi bi-linkedin"></i></a>
            </div>
            <!-- Suscripción a Newsletter -->
            <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-custom">Suscríbete</h5>
                <form action="#">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Tu correo electrónico" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-custom" type="button">Suscribirse</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Información Legal -->
        <div class="row align-items-center">
            <div class="col-md-7 col-lg-8">
                <p class="text-center text-md-left">© 2024 Todos los derechos reservados:
                    <a href="#" class="text-white" style="text-decoration: none;">
                        <strong class="text-custom">Soy Arte</strong>
                    </a>
                </p>
            </div>
            <div class="col-md-5 col-lg-4">
                <p class="text-center text-md-right">
                    <a href="#" class="text-white" style="text-decoration: none;">Política de Privacidad</a> |
                    <a href="#" class="text-white" style="text-decoration: none;">Términos y Condiciones</a>
                </p>
            </div>
        </div>
        <!-- Créditos del Diseñador -->
        <div class="row mt-4">
            <div class="col-md-12 text-center">
                <p class="text-custom">Diseñado por Lucas Salazar</p>
            </div>
        </div>
    </div>
</footer>






























    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>