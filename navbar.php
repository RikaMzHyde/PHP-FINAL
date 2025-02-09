<?php 
//Determina la página de sesión según el rol de usuario
$url_session = 'user_session.php'; //URL por defecto
$rol = $_SESSION['rol'] ?? '';
//Redirección según el rol
switch ($rol){
    case 'EDITOR':
        $url_session = 'editor_session.php';
        break;
    case 'ADMIN':
        $url_session = 'admin_session.php';
        break;
}
?>
<!--Barra principal-->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <!-- Logo -->
        <a href="index.php"><img src="imgs\Amato.png" alt="Amato" style="height: 90px; width: 220px"></a>
        <!-- Menú hamburger-->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Menú de navegación-->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- Mensaje de bienvenida para usuarios logueados -->
                <?php if(isset($_SESSION['usuario']['nombre'])){ ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= $url_session ?>">Bienvenido <?= $_SESSION['usuario']['nombre'] ?>! </a>
                </li>
                <?php } ?>
                <!--Links nav-->
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contacto</a>
                </li>  
                <!-- Enlace a pedidos (solo visible para usuarios logueados) -->              
                <?php
                if(isset($_SESSION["dni"]) && !empty($_SESSION["dni"]) ){                    
                echo '
                <li class="nav-item">
                    <a class="nav-link" href="order_history.php">Mis pedidos</a>
                </li>';
                }
                ?>
                <!-- Enlace de cuenta/login dinámico -->
                <li class="nav-item">
                    <a class="nav-link" href="<?= isset($_SESSION["dni"]) && !empty($_SESSION["dni"]) ? $url_session : 'login.php' ?>">
                        <i class="bi bi-person"></i> 
                        <?= isset($_SESSION["dni"]) && !empty($_SESSION["dni"]) ? 'Mi Cuenta' : 'Iniciar sesión' ?>
                    </a>
                </li>

                <!-- Formulario de login rápido (solo visible para usuarios no logueados) -->
                <?php if( !isset($_SESSION["dni"]) && empty($_SESSION["dni"])){ ?>
                    <li id="nav-login">
                        <form class="d-flex align-items-center gap-2" action="login.php" method="POST">
                            <input type="text" class="form-control" name="dni" placeholder="DNI (Usuario)" required>
                            <input type="password" class="form-control" placeholder="Contraseña" name="password" required>
                            <button class="btn btn-custom" type="submit" name="submit">Entrar</button>
                        </form>
                    </li>
                <?php } ?>
            </ul>
        </div>
                <!--Carrito e items -->
        <div id="cart-summary" class="cart-summary d-flex align-items-center justify-content-end p-3">
            <a href="cart.php" class="nav-link me-3"><i class="bi bi-cart3 fs-4"></i></a>
            <span class="me-3">Items en carrito: <strong id="cart-items-count">0</strong></span>
            <span>Total: <strong id="cart-total-price">0.00</strong> €</span>
        </div>
    </div>
</nav>
<script>
        //Estado inicial del carrito
        let cart = {
            items: 0,
            totalPrice: 0,
        };

        //Función para actualizar la vista del carrito
        function updateCartView() {
            // Actualizar la cantidad de items en el carrito y el precio total
            document.getElementById('cart-items-count').textContent = cart.items;
            document.getElementById('cart-total-price').textContent = cart.totalPrice.toFixed(2);
        }

        // Cargar el carrito desde la sesión al iniciar la página
        async function loadCartFromSession() {
            let totalPrice = 0;
            let totalItems = 0;
            try {
                const response = await fetch('carritoApi.php', {
                    method: 'GET'
                });
                if (!response.ok) throw new Error('Error al cargar el carrito');
                const cartData = await response.json();
                //Calcula totales según items en el carrito y cantidades
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
    //Evento que se ejecuta cuando el DOM está totalmente cargado
    document.addEventListener('DOMContentLoaded', () => {
        //Obtener la pagina actual
        const currentPage = window.location.pathname.split('/').pop();
        //Seleccionar todos los enlaces de nav
        const navLinks = document.querySelectorAll('.nav-link');
        //Lista de direcciones que no pueden mostrar el carrito
        const forbiddenSummaryCartLinks = ["order_confirmation", "user_address", "payment", "successful_payment", "admin_session", 
            "newuser_admin", "modify_admin", "search_user", "editor_articles", "new_article", "editor_session", "new_article", "delete_article"];
        //Recogida la pag actual y todos los enlaces, compara, encuentra y marca el enlace correspondiente a la página actual    
        navLinks.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
            }
        });
        //Oculta carrito
        forbiddenSummaryCartLinks.forEach(forbiddenLink => {
            if (currentPage.includes(forbiddenLink)) {
                document.getElementById("cart-summary").remove();
            }
        })
        //Oculta login rápido si ya estoy logeado
        if(currentPage.includes("login")){
            document.getElementById("nav-login").remove();
        }

        //Carga el carrito desde la sesión
        loadCartFromSession();
        
    });
</script>