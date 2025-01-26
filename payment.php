<?php
session_start();
// Add any necessary session checks or data retrieval here
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Método de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="stylesheetcart.css">
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
            <a href="cart.php" class="nav-link ms-3"><i class="bi bi-cart3 fs-4"></i></a>
            <div class="cart-summary d-flex align-items-center justify-content-end p-3">
                <span class="me-3">Items en carrito: <strong id="cart-items-count">2</strong></span>
                <span>Total: <strong id="cart-total-price">51.87€</strong></span>
            </div>
        </div>
    </nav>

    <main class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center mb-4">Seleccione un Método de Pago</h4>
                            <form name="tramitarPago" method="post" action="successful_payment.php">
                                <div class="row justify-content-center">
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pago" id="visa" value="visa" required>
                                            <label class="form-check-label" for="visa">
                                                <img src="imgs\visa.png" alt="Visa" class="img-fluid">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pago" id="mastercard" value="master" required>
                                            <label class="form-check-label" for="mastercard">
                                                <img src="imgs\mc.png" alt="Mastercard" class="img-fluid">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pago" id="american" value="american" required>
                                            <label class="form-check-label" for="american">
                                                <img src="imgs\ae.png" alt="American Express" class="img-fluid">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pago" id="paypal" value="paypal" required>
                                            <label class="form-check-label" for="paypal">
                                                <img src="imgs\pngegg (6).png" alt="PayPal" class="img-fluid">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-custom" name="pagar">Finalizar Pedido</button>
                                </div>
                            </form>
                        </div>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

