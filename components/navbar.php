<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand fs-2" href="#">Amato</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= isset($_SESSION["dni"]) && !empty($_SESSION["dni"]) ? 'user_session.php' : 'login.php' ?>">
                        <i class="bi bi-person"></i> 
                        <?= isset($_SESSION["dni"]) && !empty($_SESSION["dni"]) ? 'Mi Cuenta' : 'Iniciar sesión' ?>
                    </a>
                </li>
            </ul>
        </div>
        <div id="cart-summary" class="cart-summary d-flex align-items-center justify-content-end p-3">
            <a href="cart.php" class="nav-link me-3"><i class="bi bi-cart3 fs-4"></i></a>
            <span class="me-3">Items en carrito: <strong id="cart-items-count">0</strong></span>
            <span>Total: <strong id="cart-total-price">0.00</strong> €</span>
        </div>
    </div>
</nav>
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

    document.addEventListener('DOMContentLoaded', () => {
        const currentPage = window.location.pathname.split('/').pop();
        const navLinks = document.querySelectorAll('.nav-link');
        const forbiddenSummaryCartLinks = ["order_confirmation", "user_address", "payment", "successful_payment"];
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            }
        });
        forbiddenSummaryCartLinks.forEach(forbiddenLink => {
            if (currentPage.includes(forbiddenLink)) {
                document.getElementById("cart-summary").remove();
            }
        })

        loadCartFromSession();
        
    });

    
</script>