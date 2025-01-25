<?php
session_start();
// Aquí puedes agregar cualquier lógica necesaria para manejar la sesión o datos del usuario
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Dirección de Envío</title>
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

        .form-control {
            background-color: #9f8bc0;
            color: #4e4363;
            border-color: rgb(80, 255, 203);
        }

        .form-control::placeholder {
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
                    <h4 class="card-title text-center mb-4">Datos y dirección de Envío</h4>
                    <form action="payment.php" method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="mb-3">
                            <label for="localidad" class="form-label">Localidad</label>
                            <input type="text" class="form-control" id="localidad" name="localidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="provincia" class="form-label">Provincia</label>
                            <input type="text" class="form-control" id="provincia" name="provincia" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" pattern="[0-9]{9}" title="El teléfono debe tener 9 dígitos" required>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-custom">Continuar</button>
                        </div>
                    </form>
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
        // Aquí puedes agregar cualquier JavaScript necesario para actualizar dinámicamente el resumen del carrito
        // Similar a lo que tienes en tu archivo cart.php
    </script>
</body>
</html>