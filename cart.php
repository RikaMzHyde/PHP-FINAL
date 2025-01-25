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
            color: #4e4363;
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

        .table th,
        .table td {
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
                                <?php
                                $totalPrice = 0;
                                if (!empty($cart['items'])) {
                                    foreach ($cart['items'] as $item) {
                                        $subtotal = $item['price'] * $item['quantity'];
                                        $totalPrice += $subtotal;
                                        echo "<tr>
                                            <td>{$item['name']}</td>
                                            <td>{$item['price']}€</td>
                                            <td>
                                                <button class='btn btn-sm btn-outline-secondary decrease-quantity' data-name='{$item['name']}'>-</button>
                                                <span class='mx-2'>{$item['quantity']}</span>
                                                <button class='btn btn-sm btn-outline-secondary increase-quantity' data-name='{$item['name']}'>+</button>
                                            </td>
                                            <td>{$subtotal}€</td>
                                            <td><a href='#' class='btn btn-sm btn-outline-danger remove-item' data-name='{$item['name']}'><i class='bi bi-trash'></i></a></td>
                                          </tr>";
                                    }
                                }
                                
                                    
                                 else {
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
                        <a href="order_confirmation.php" class="btn btn-custom">Realizar pedido</a>
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

    <script>
        /*function loadCartFromSession() {
            const cartData = JSON.parse(sessionStorage.getItem('cart')) || {
                items: []
            };
            const cartItemsCount = document.getElementById('cart-items-count');
            const cartTotalPrice = document.getElementById('cart-total-price');

            let totalItems = 0;
            let totalPrice = 0;

            cartData.items.forEach(item => {
                totalItems += item.quantity;
                totalPrice += item.price * item.quantity;
            });

            cartItemsCount.textContent = totalItems;
            cartTotalPrice.textContent = totalPrice.toFixed(2);

            // Update PHP session
            updatePHPSession(cartData);
        }

        function updatePHPSession(cartData) {
            fetch('update_session.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(cartData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('PHP session updated successfully');
                    } else {
                        console.error('Failed to update PHP session');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        // Load cart data when the page loads
        document.addEventListener('DOMContentLoaded', loadCartFromSession);*/
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
    const cartTotal = document.querySelector('.fw-bold span');
    let totalPrice = 0;

    cartTableBody.innerHTML = '';

    if (cart.length === 0) {
        cartTableBody.innerHTML = '<tr><td colspan="5" class="text-center">No hay productos en el carrito</td></tr>';
        cartTotal.textContent = '0.00';
        return;
    }

    cart.forEach(item => {
        const subtotal = item.price * item.quantity;
        totalPrice += subtotal;

        cartTableBody.innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.price}€</td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary decrease-quantity" data-id="${item.id}">-</button>
                    <span class="mx-2">${item.quantity}</span>
                    <button class="btn btn-sm btn-outline-secondary increase-quantity" data-id="${item.id}">+</button>
                </td>
                <td>${subtotal.toFixed(2)}€</td>
                <td><button class="btn btn-sm btn-outline-danger remove-item" data-id="${item.id}"><i class="bi bi-trash"></i></button></td>
            </tr>`;
    });

    cartTotal.textContent = totalPrice.toFixed(2);
}
loadCart();

        function removeFromCart(name) {
            let cartData = JSON.parse(sessionStorage.getItem('cart')) || {
                items: []
            };
            cartData.items = cartData.items.filter(item => item.name !== name);
            sessionStorage.setItem('cart', JSON.stringify(cartData));
            loadCartFromSession();
            location.reload(); // Reload the page to reflect changes
        }

        // Add event listeners to remove buttons
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                const name = event.target.closest('.remove-item').getAttribute('data-name');
                removeFromCart(name);
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
        const updateQuantity = (name, change) => {
            let cartData = JSON.parse(sessionStorage.getItem('cart')) || { items: [] };
            cartData.items = cartData.items.map(item => {
                if (item.name === name) {
                    item.quantity = Math.max(1, item.quantity + change); // Evitar cantidad menor a 1
                }
                return item;
            });
            sessionStorage.setItem('cart', JSON.stringify(cartData));
            updatePHPSession(cartData);
            location.reload(); // Recargar para reflejar cambios
        };

        document.querySelectorAll('.increase-quantity').forEach(button => {
            button.addEventListener('click', (event) => {
                const name = event.target.closest('.increase-quantity').getAttribute('data-name');
                updateQuantity(name, 1);
            });
        });

        document.querySelectorAll('.decrease-quantity').forEach(button => {
            button.addEventListener('click', (event) => {
                const name = event.target.closest('.decrease-quantity').getAttribute('data-name');
                updateQuantity(name, -1);
            });
        });
    });
    </script>
</body>

</html>