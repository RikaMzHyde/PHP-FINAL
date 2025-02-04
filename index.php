<?php
require_once("connect.php");
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="stylesheetcart.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require('navbar.php'); ?>

    <main class="flex-grow-1">
        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="productos\sld-oferta-año-nuevo-japonshop.jpg" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="productos\sld-hello-kitty-mundo-japonshop(1)_1.jpg" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="productos\sld-american-bakery-japonshop.jpg" class="d-block w-100" alt="Slide 3">
                </div>
                <div class="carousel-item">
                    <img src="productos\sld-ramen-chikin-duo-japonshop(1).jpg" class="d-block w-100" alt="Slide 4">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-4 txt-custom">¡Bienvenidos a Amato!</h2>
                <p class="text-center text-white">Encuentra aquí todo tipo de productos de importación Japoneses! En
                    Amato ofrecemos una amplia variedad de artículos de alta calidad a los mejores precios ✨🌸</p>
            </div>
        </section>

        <section class="py-5" style="background-color: #4e4363;">
            <div class="container">
                <h2 class="text-center mb-4 txt-custom">Buscador</h2>
                <form action="index.php" method="GET" class="d-flex justify-content-center">
                    <input class="form-control me-2 w-50" type="search" placeholder="¿Qué estás buscando?" aria-label="Search" name="buscar">
                    <button class="btn btn-custom ms-2" type="submit">Buscar</button>
                </form>
            </div>
        </section>

        <section class="py-5">

            <section class="py-5">
                <div class="container-fluid">
                    <div class="row d-flex">
                        <div>
                            <h2 class="text-center mb-4 txt-custom">Nuestros Productos</h2>
                        </div>
                        <!-- Sidebar de categorías -->
                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-body p-0">
                                    <div class="accordion" id="categoriesAccordion">
                                        <div class="accordion-item">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed bg-transparent txt-custom py-5"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#todosCollapse">
                                                        Todos
                                                    </button>
                                                </h2>
                                                <div id="todosCollapse" class="accordion-collapse collapse"
                                                    data-bs-parent="#categoriesAccordion">
                                                    <div class="accordion-body">
                                                        <ul class="list-unstyled mb-0">
                                                            <li><a href="index.php" class="txt-custom text-decoration-none">Ver todo</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed bg-transparent txt-custom py-5"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#ramenCollapse">
                                                        Ramen y Sopas
                                                    </button>
                                                </h2>
                                                <div id="ramenCollapse" class="accordion-collapse collapse"
                                                    data-bs-parent="#categoriesAccordion">
                                                    <div class="accordion-body">
                                                        <ul class="list-unstyled mb-0">
                                                            <li><a href="index.php?categoria=RAMEN"
                                                                    class="txt-custom text-decoration-none">Ramen</a>
                                                            </li>
                                                            <li><a href="index.php?categoria=SOPAS"
                                                                    class="txt-custom text-decoration-none">Sopas</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed bg-transparent txt-custom py-5"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#dulcesCollapse">
                                                        Dulces
                                                    </button>
                                                </h2>
                                                <div id="dulcesCollapse" class="accordion-collapse collapse"
                                                    data-bs-parent="#categoriesAccordion">
                                                    <div class="accordion-body">
                                                        <ul class="list-unstyled mb-0">
                                                            <li><a href="index.php?categoria=CHOCOLATES"
                                                                    class="txt-custom text-decoration-none">Chocolates</a>
                                                            </li>
                                                            <li><a href="index.php?categoria=GALLETAS"
                                                                    class="txt-custom text-decoration-none">Galletas</a>
                                                            </li>
                                                            <li><a href="index.php?categoria=CARAMELOS"
                                                                    class="txt-custom text-decoration-none">Caramelos</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed bg-transparent txt-custom py-5"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#snacksCollapse">
                                                        Snacks
                                                    </button>
                                                </h2>
                                                <div id="snacksCollapse" class="accordion-collapse collapse"
                                                    data-bs-parent="#categoriesAccordion">
                                                    <div class="accordion-body">
                                                        <ul class="list-unstyled mb-0">
                                                            <li><a href="index.php?categoria=PATATAS"
                                                                    class="txt-custom text-decoration-none">Patatas</a>
                                                            </li>
                                                            <li><a href="index.php?categoria=FRUTOS SECOS"
                                                                    class="txt-custom text-decoration-none">Frutos
                                                                    Secos</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header">
                                                    <button class="accordion-button collapsed bg-transparent txt-custom py-5"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#bebidasCollapse">
                                                        Bebidas
                                                    </button>
                                                </h2>
                                                <div id="bebidasCollapse" class="accordion-collapse collapse"
                                                    data-bs-parent="#categoriesAccordion">
                                                    <div class="accordion-body">
                                                        <ul class="list-unstyled mb-0">
                                                            <li><a href="index.php?categoria=REFRESCOS"
                                                                    class="txt-custom text-decoration-none">Refrescos</a>
                                                            </li>
                                                            <li><a href="index.php?categoria=TES"
                                                                    class="txt-custom text-decoration-none">Tés</a></li>
                                                            <li><a href="index.php?categoria=OTRAS BEBIDAS"
                                                                    class="txt-custom text-decoration-none">Otras
                                                                    Bebidas</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Área de productos -->
                    <?php
                    // Obtener la categoría seleccionada desde el parámetro GET (si está presente)
                    $categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
                    // Obtener el término de búsqueda desde el parámetro GET (si está presente)
                    $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

                    // Configuración para paginación
                    $productos_por_pagina = 11;
                    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $offset = ($pagina_actual - 1) * $productos_por_pagina;
                    require_once('apiBD.php');
                    $articulos = getArticulos($categoria, $buscar, $productos_por_pagina, $pagina_actual, $offset);
                    
                    // Mostrar los productos
                    foreach ($articulos as $articulo){
                        echo "<div class='col-md-2 mb-4'>
                                <div class='card'>
                                    <img src='" . $articulo['imagen'] . "' class='card-img-top' alt='Imagen del producto'>
                                    <div class='card-body'>
                                        <h5 class='card-title fw-bold'>" . $articulo['nombre'] . "</h5>
                                        <p class='card-text product-description'>" . $articulo['descripcion'] . "</p>
                                        <div class='d-inline-flex'>
                                            <button onclick=\"addToCart(".$articulo['precio'].", '".$articulo['nombre']. "', '".$articulo['codigo']."')\" class='btn btn-custom' data-price='" . $articulo['precio'] . "'>
                                                <i class='bi bi-cart-plus me-2' style='font-size: 1.3em;'></i> Añadir al carrito
                                            </button>
                                            <div class='card-price fw-bold ms-3'>" . $articulo['precio'] . "€</div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>";
                    }
 
                    // Obtener el número total de productos para la paginación
                    $total_productos = getTotalProductos($categoria, $buscar);
                    $total_paginas = ceil($total_productos / $productos_por_pagina);

                    // Mostrar la paginación
                    echo '<div class="pagination d-flex justify-content-center mt-4">';
                    if ($pagina_actual > 1) {
                        echo '<a href="?pagina=' . ($pagina_actual - 1) . '" class="btn btn-custom me-2">Anterior</a>';
                    }
                    for ($i = 1; $i <= $total_paginas; $i++) {
                        echo '<a href="?pagina=' . $i . '" class="btn btn-custom me-2">' . $i . '</a>';
                    }
                    if ($pagina_actual < $total_paginas) {
                        echo '<a href="?pagina=' . ($pagina_actual + 1) . '" class="btn btn-custom ms-2">Siguiente</a>';
                    }
                    echo '</div>';
                    ?>
            </section>
    </main>
    <?php require('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>

        // Función para añadir un producto al carrito
        function addToCart(price, name, code) {
            fetch('carritoApi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'add',
                        price: price,
                        name: name,
                        code: code
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    loadCartFromSession();
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>