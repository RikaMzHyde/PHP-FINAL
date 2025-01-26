<?php
include("connect.php");
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
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fs-2" href="#">Amato</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                    <a class="nav-link" href="login.php">
                        <i class="bi bi-person"></i> Mi Cuenta
                    </a>
                </ul>
            </div>
            <a href="cart.php" class="nav-link ms-3"><i class="bi bi-cart3 fs-4"></i></a>
            <div class="cart-summary d-flex align-items-center justify-content-end p-3">
                <span class="me-3">Items en carrito: <strong id="cart-items-count">0</strong></span>
                <span>Total: <strong id="cart-total-price">0.00</strong> €</span>
            </div>
        </div>
    </nav>

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

                    // Conexión a la base de datos
                    $conn = conectar_db();
                    if (!$conn) {
                        die("Error al conectar a la base de datos");
                    }

                    // Configuración para paginación
                    $productos_por_pagina = 11;
                    $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
                    $offset = ($pagina_actual - 1) * $productos_por_pagina;

                    // Consulta base
                    $sql = "SELECT * FROM articulos WHERE 1";

                    // Filtrar por categoría, si se seleccionó una
                    if ($categoria) {
                        $sql .= " AND categoria = :categoria";
                    }

                    // Filtrar por nombre de producto, si hay un término de búsqueda
                    if ($buscar) {
                        $sql .= " AND nombre LIKE :buscar";
                    }

                    // Agregar límite y offset para la paginación
                    $sql .= " LIMIT :offset, :limite";

                    // Preparar la consulta
                    $stmt = $conn->prepare($sql);

                    // Vincular los parámetros de la consulta
                    if ($categoria) {
                        $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
                    }
                    if ($buscar) {
                        $buscar = "%" . $buscar . "%"; // Utilizamos % para hacer la búsqueda parcial
                        $stmt->bindParam(':buscar', $buscar, PDO::PARAM_STR);
                    }
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->bindParam(':limite', $productos_por_pagina, PDO::PARAM_INT);

                    // Ejecutar la consulta
                    $stmt->execute();

                    // Mostrar los productos
                    while ($datos = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='col-md-2 mb-4'>
                                <div class='card'>
                                    <img src='" . $datos['imagen'] . "' class='card-img-top' alt='Imagen del producto'>
                                    <div class='card-body'>
                                        <h5 class='card-title fw-bold'>" . $datos['nombre'] . "</h5>
                                        <p class='card-text product-description'>" . $datos['descripcion'] . "</p>
                                        <p class='card-price fw-bold'>" . $datos['precio'] . "€</p>
                                        <button onclick=\"addToCart(".$datos['precio'].", '".$datos['nombre']. "', '".$datos['codigo']."')\" class='btn btn-custom' data-price='" . $datos['precio'] . "'>
                                            <i class='bi bi-cart-plus me-2' style='font-size: 1.3em;'></i> Añadir al carrito
                                        </a>
                                    </div>
                                </div>
                            </div>";
                    }

                    // Obtener el número total de productos para la paginación
                    $sql_total = "SELECT COUNT(*) FROM articulos WHERE 1";
                    if ($categoria) {
                        $sql_total .= " AND categoria = :categoria";
                    }
                    if ($buscar) {
                        $sql_total .= " AND nombre LIKE :buscar";
                    }

                    $stmt_total = $conn->prepare($sql_total);
                    if ($categoria) {
                        $stmt_total->bindParam(':categoria', $categoria, PDO::PARAM_STR);
                    }
                    if ($buscar) {
                        $buscar = "%" . $buscar . "%"; // Utilizamos % para hacer la búsqueda parcial
                        $stmt_total->bindParam(':buscar', $buscar, PDO::PARAM_STR);
                    }
                    $stmt_total->execute();
                    $total_productos = $stmt_total->fetchColumn();
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
            <!-- Sección separadora -->
            <!-- <section class="py-5" style="background-color: #9f8bc0;">
                <div class="container">
                    <h2 class="text-center mb-4 txt-custom">¿Por qué elegir Amato?</h2>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Calidad Garantizada</h5>
                                    <p class="card-text">Todos nuestros productos son importados directamente de Japón,
                                        asegurando la más alta calidad.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Envío Rápido</h5>
                                    <p class="card-text">Entregamos tus productos en tiempo récord para que puedas
                                        disfrutarlos lo antes posible.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Atención al Cliente</h5>
                                    <p class="card-text">Nuestro equipo está siempre disponible para ayudarte con
                                        cualquier duda o consulta.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> -->
    </main>

    <footer class="footer py-4 mt-auto">
        <div class="container">
            <div class="row gy-4">
                <div class="col-12 col-md-4">
                    <h5 class="mb-3">Amato</h5>
                    <p class="small">Tu proveedor de productos de importación Japoneses de confianza 🌸</p>
                </div>
                <div class="col-12 col-md-4">
                    <h5 class="mb-3">Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none txt-custom">Política de Privacidad</a></li>
                        <li><a href="#" class="text-decoration-none txt-custom">Términos y Condiciones</a></li>
                        <li><a href="#" class="text-decoration-none txt-custom">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-12 col-md-4">
                    <h5 class="mb-3">Síguenos</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="txt-custom"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="txt-custom"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="txt-custom"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="py-2 text-center txt-custom small" style="background-color: #4e4363;">
        © 2024 Amato - Todos los derechos reservados
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Estado inicial del carrito
        let cart = {
            items: 0,
            totalPrice: 0,
        };

        // Función para actualizar la vista del carrito
        function updateCartView() {
            // Actualizar la cantidad de items en el carrito y el precio total
            document.getElementById('cart-items-count').textContent = cart.items;
            document.getElementById('cart-total-price').textContent = cart.totalPrice.toFixed(2);
        }

        // Función para añadir un producto al carrito
        function addToCart(price, name, code) {
            fetch('api/carritoApi.php', {
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
        async function loadCartFromSession() {
            let totalPrice = 0;
            let totalItems = 0;
            try {
                const response = await fetch('api/carritoApi.php', {
                    method: 'GET'
                });
                if (!response.ok) throw new Error('Error al cargar el carrito');
                const cartData = await response.json();
                cartData.forEach(item => {
                    const subtotal = item.price * item.quantity;
                    totalPrice += subtotal;
                    totalItems += item.quantity;
                });

                cart.items = totalItems;
                cart.totalPrice = totalPrice;

                updateCartView();
            } catch (error) {
                console.error('Error al cargar el carrito:', error);
            }
        }
        loadCartFromSession();
    </script>
</body>

</html>