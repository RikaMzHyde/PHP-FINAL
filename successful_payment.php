<?php
session_start();
// Add any necessary session checks or data retrieval here
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Pedido Exitoso</title>
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

        .accordion-button {
            background-color: #4e4363;
            color: rgb(80, 255, 203);
        }

        .accordion-button:not(.collapsed) {
            background-color: #85b1c5;
            color: #4e4363;
        }

        .list-group-item {
            background-color: #4e4363;
            color: rgb(80, 255, 203);
            border-color: rgb(80, 255, 203);
        }

        .list-group-item:hover {
            background-color: #85b1c5;
            color: #4e4363;
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
                    <li class="nav-item">
                        <a class="nav-link" href="#">Envío</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Devoluciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">¡Pedido Realizado con Éxito!</h2>
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">¡Gracias por tu compra!</h4>
                                <p>Tu pedido ha sido procesado correctamente. Hemos enviado un correo electrónico de confirmación a tu dirección registrada.</p>
                                <hr>
                                <p class="mb-0">Número de pedido: <strong>#<?php echo rand(10000, 99999); ?></strong></p>
                            </div>
                            <p>Resumen de tu pedido:</p>
                            <ul>
                                <li>Productos: 2</li>
                                <li>Total: 51.87€</li>
                                <li>Método de pago: Tarjeta de crédito</li>
                            </ul>
                            <div class="text-center mt-4">
                                <a href="index.php" class="btn btn-custom me-2">Volver a la tienda</a>
                                <a href="order_history.php" class="btn btn-custom">Ver mis pedidos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Amato</h5>
                    <p>Tu proveedor de productos de importación Japoneses de confianza 🌸</p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-decoration-none txt-custom">Política de Privacidad</a></li>
                        <li><a href="#" class="text-decoration-none txt-custom">Términos y Condiciones</a></li>
                        <li><a href="#" class="text-decoration-none txt-custom">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Síguenos</h5>
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

