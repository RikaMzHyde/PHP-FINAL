<?php
require("functions/security.php");
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
    <?php require('components/navbar.php') ?>
    <main class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Revisa y Confirma tu Pedido</h4>
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
                                    <td id="total_cart_price" class="fw-bold"></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <a href="cart.php" class="btn btn-custom me-2">Volver a Mi Cesta</a>
                        <a href="user_address.php" class="btn btn-custom">Confirmar</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require('components/footer.php'); ?>

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
                            <span class="mx-2">${item.quantity}</span>
                        </td>
                        <td>${subtotal.toFixed(2)} €</td>
                        <td></td>
                    </tr>`;
            });

            cartTotal.textContent = totalPrice.toFixed(2) + " €";
            cartTotalPrice.textContent = totalPrice.toFixed(2);
            cartItemsCount.textContent = totalItems;
        }
        loadCart();

        // // Add event listeners to remove buttons
        // document.querySelectorAll('.remove-item').forEach(button => {
        //     button.addEventListener('click', (event) => {
        //         event.preventDefault();
        //         const name = event.target.closest('.remove-item').getAttribute('data-name');
        //         removeFromCart(name);
        //     });
        // });
    </script>
</body>

</html>