<?php
session_start();
$cart = json_decode($_SESSION['cart'] ?? '[]', true);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #9f8bc0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar,
        .footer {
            background-color: #4e4363;
            color: rgb(80, 255, 203);
        }

        .btn-custom {
            background-color: #85b1c5;
            color: #4e4363;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: rgb(80, 255, 203);
            color:#4e4363;
        }

        .txt-custom {
            color: rgb(80, 255, 203);
        }

        .card {
            background-color: #4e4363;
            border: 1px solid rgb(80, 255, 203);
            color: rgb(80, 255, 203);
        }

        .table {
            color: rgb(80, 255, 203);
        }

        .table th, .table td {
            border-color: rgb(80, 255, 203);
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand fs-2 fw-bold" href="#">Amato</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ofertas</a>
                    </li>
                    <a class="nav-link" href="login.php">
                        <i class="bi bi-person"></i> Mi Cuenta
                    </a>
                </ul>
            </div>
            <a href="cart.php" class="nav-link txt-custom ms-3"><i class="bi bi-cart3 fs-4"></i></a>
            <div class="cart-summary d-flex align-items-center justify-content-end p-3">
    <span class="me-3">Items en carrito: <strong id="cart-items-count">0</strong></span>
    <span>Total: $<strong id="cart-total-price">0.00</strong></span>
</div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Tu pedido</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $totalPrice = 0;
                                if (!empty($cart)) {
                                    foreach ($cart['items'] as $item) {
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $totalPrice += $subtotal;
                                        echo "<tr>
                                                <td>{$item['name']}</td>
                                                <td>{$item['price']}€</td>
                                                <td>{$item['quantity']}</td>
                                                <td>{$subtotal}€</td>
                                                <td><a href='#' class='btn btn-sm btn-outline-danger'><i class='bi bi-trash'></i></a></td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5' class='text-center'>No hay productos en el carrito</td></tr>";
                                }
                                ?>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">TOTAL PEDIDO:</td>
                                    <td class="fw-bold"><?= $totalPrice ?>€</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="index.php" class="btn btn-custom me-2">Seguir comprando</a>
                        <a href="user_address.php" class="btn btn-custom">Confirmar</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer py-4 mt-auto">
        <div class="container text-center">
            <p>&copy; 2024 Amato - Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para añadir un producto al carrito (con AJAX)
        function addToCart(name, price) {
            const formData = new FormData();
            formData.append('product_name', name);
            formData.append('product_price', price);

            fetch('update_cart.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log(data.message);
                    // Aquí podrías actualizar la vista del carrito en la página, si es necesario
                    updateCartView();
                } else {
                    console.error('Error al añadir el producto al carrito');
                }
            })
            .catch(error => {
                console.error('Error en la petición AJAX:', error);
            });
        }

        // Asignar eventos a los botones "Añadir al carrito"
        document.querySelectorAll('.btn.btn-custom').forEach((button) => {
            button.addEventListener('click', (event) => {
                const price = parseFloat(event.target.getAttribute('data-price')); // Obtener el precio desde el atributo data-price
                const name = event.target.closest('.card-body').querySelector('.card-title').textContent; // Obtener el nombre del producto
                addToCart(name, price);
            });
        });
    </script>
</body>

</html>