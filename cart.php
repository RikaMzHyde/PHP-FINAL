<?php
session_start();
$mensaje_error = '';
//Verifica si hay un mensaje de error en la URL
if(isset($_GET['error'])){
    $error = $_GET['error'];
    if($error === 'carrito'){
        $mensaje_error = 'El carrito está vacío por favor introduce artículos en él.';
    } else {
        $mensaje_error = 'La página a la que intentas acceder no se encuentra disponible.';
    }
}
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
        //Modificar cantidad de producto en el carrito
        const modifyQuantity = (code, action) => {
            //Solicitud con POST a "carritoApi" con los datos correspondientes
            fetch('carritoApi.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: action, //Incrementar o disminuir cantidad
                        code: code
                    })
                })
                .then(response => response.json()) //Convierte respuesta a JSON
                .then(data => {
                    if (data.success) {
                        loadCart(); // Recarga la UI del carrito si la operación ha sido exitosa
                    } else {
                        alert(data.message || 'Error al modificar la cantidad');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
    <?php require('navbar.php') ?>
    <main class="py-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Tu Cesta</h4>
                    <!-- Muestra el mensaje de error si existe -->
                    <?php if ($mensaje_error !== ''){ ?> <div class="error"><?= $mensaje_error ?></div> <?php } ?>
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
                                <!-- Elementos del carrito cargados desde función updateCartUI -->
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
    <!--Botones para seguir comprando o realizar pedido-->
                        <a href="index.php" class="btn btn-custom me-2">Seguir comprando</a>
                        <a href="order_confirmation.php" class="btn btn-custom">Realizar pedido</a>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php require('footer.php'); ?>
    <script>
        //Función para cargar los productos del carrito
        async function loadCart() {
            try {
                //Pide los datos del carrito a "carritoApi"
                const response = await fetch('carritoApi.php', { method: 'GET' });
                if (!response.ok) throw new Error('Error al cargar el carrito');

                //Convierte la respuesta a JSON y actualiza la UI(interfaz) del carrito
                const cartData = await response.json();
                updateCartUI(cartData);
            } catch (error) {
                console.error('Error al cargar el carrito:', error);
            }
        }

        //Función que actualiza la interfaz de usuario con los datos del carrito
        function updateCartUI(cart) {
            const cartTableBody = document.querySelector('tbody'); //Selecciona cuerpo de la tabla donde se mostrarán los productos
            const cartTotal = document.querySelector('#total_cart_price'); //Selecciona el elementos para mostrar el total
            const cartItemsCount = document.querySelector('#cart-items-count'); //Cuenta artículos
            const cartTotalPrice = document.querySelector('#cart-total-price'); //Mustra totoal en el pie de tabla
            let totalPrice = 0;
            let totalItems = 0;

            cartTableBody.innerHTML = ''; //Limpia el cuerpo de la tabla antes de agregar productos
            
            if (cart.length === 0) {
                 //Si no hay productos en el carrito, muestra mensaje 
                cartTableBody.innerHTML = '<tr><td colspan="5" class="text-center">No hay productos en el carrito</td></tr>';
                cartTotal.textContent = '0.00';
                cartTotalPrice.textContent = '0.00';
                cartItemsCount.textContent = '0';
                return;
            }

            //Itera sobre los productos del carrito para mostrar los detalles
            cart.forEach(item => {
                const subtotal = item.price * item.quantity; //Calcular subtotal de cada prod
                totalPrice += subtotal; //Suma al total el subtotal
                totalItems += item.quantity; //Suma al total el número de unidades

                //Agregar una fila a la tabla para cada producto con sus detalles
                cartTableBody.innerHTML += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.price}€</td>
                        <td>
                            <button class="btn btn-sm btn-outline-secondary decrease-quantity" onclick="modifyQuantity('${item.code}', 'remove')">-</button>
                            <span class="mx-2">${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-secondary increase-quantity" onclick="modifyQuantity('${item.code}', 'add')">+</button>
                        </td>
                        <td>${subtotal.toFixed(2)} €</td>
                        <td><button class="btn btn-sm btn-outline-danger remove-item" onclick="modifyQuantity('${item.code}', 'clear')" data-id="${item.id}"><i class="bi bi-trash"></i></button></td>
                    </tr>`;
            });

            //Muestra el total del carrito
            cartTotal.textContent = totalPrice.toFixed(2) + " €";
            cartTotalPrice.textContent = totalPrice.toFixed(2);
            cartItemsCount.textContent = totalItems;
        }
        //Llama a la función para cargar el carrito al cargar la página
        loadCart();

        //Elimina elementos del carrito
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault(); //Evita el comportamiento por defecto
                const name = event.target.closest('.remove-item').getAttribute('data-name'); //Obtiene nombre prod desde data-name y lo elimina
                removeFromCart(name); //Llamada a la función para eliminar
            });
        });
    </script>
</body>

</html>