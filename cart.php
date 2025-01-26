<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Carrito</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="stylesheetcart.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <script>
        const modifyQuantity = (name, price, action) => {
            fetch('api/carritoApi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: action,
                        price: price,
                        name: name
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        loadCart(); // Recarga la UI del carrito
                    } else {
                        alert(data.message || 'Error al modificar la cantidad');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
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
            <a href="cart.php" class="nav-link ms-3"><i class="bi bi-cart3 fs-4"></i></a>
            <div class="cart-summary d-flex align-items-center justify-content-end p-3">
                <span class="me-3">Items en carrito: <strong id="cart-items-count">0</strong></span>
                <span>Total: $<strong id="cart-total-price">0.00</strong>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Tu Cesta</h4>
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
                                <!-- Cargado desde función updateCartUI -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">TOTAL PEDIDO:</td>
                                    <td id="total_cart_price" class="fw-bold"><?= $totalPrice ?>€</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="index.php" class="btn btn-custom me-2">Seguir comprando</a>
                        <a href="order_confirmation.php" class="btn btn-custom">Realizar pedido</a>
                    </div>
                </div>
            </div>
        </div>
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

    <script>
        async function loadCart() {
            try {
                const response = await fetch('api/carritoApi.php', { method: 'GET' });
                if (!response.ok) throw new Error('Error al cargar el carrito');

                const cartData = await response.json();
                updateCartUI(cartData);
            } catch (error) {
                console.error('Error al cargar el carrito:', error);
            }
        }

        function updateCartUI(cart) {
            const cartTableBody = document.querySelector('tbody');
            const cartTotal = document.querySelector('#total_cart_price');
            const cartItemsCount = document.querySelector('#cart-items-count');
            const cartTotalPrice = document.querySelector('#cart-total-price');
            let totalPrice = 0;
            let totalItems = 0;

            cartTableBody.innerHTML = '';

            if (cart.length === 0) {
                cartTableBody.innerHTML = '<tr><td colspan="5" class="text-center">No hay productos en el carrito</td></tr>';
                cartTotal.textContent = '0.00';
                cartTotalPrice.textContent = '0.00';
                cartItemsCount.textContent = '0';
                return;
            }

            cart.forEach(item => {
                const subtotal = item.price * item.quantity;
                totalPrice += subtotal;
                totalItems += item.quantity;

                cartTableBody.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.price}€</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary decrease-quantity" onclick="modifyQuantity('${item.name}', ${item.price}, 'remove')">-</button>
                            <span class="mx-2">${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-secondary increase-quantity" onclick="modifyQuantity('${item.name}', ${item.price}, 'add')">+</button>
                        </td>
                        <td>${subtotal.toFixed(2)}€</td>
                        <td><button class="btn btn-sm btn-outline-danger remove-item" onclick="modifyQuantity('${item.name}', ${item.price}, 'clear')" data-id="${item.id}"><i class="bi bi-trash"></i></button></td>
                    </tr>`;
            });

            cartTotal.textContent = totalPrice.toFixed(2);
            cartTotalPrice.textContent = totalPrice.toFixed(2);
            cartItemsCount.textContent = totalItems;
        }
        loadCart();

        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const name = event.target.closest('.remove-item').getAttribute('data-name');
                removeFromCart(name);
            });
        });
    </script>
</body>

</html>