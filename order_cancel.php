<?php
session_start();
// Aquí deberías incluir la lógica para verificar si el usuario está autenticado
// y obtener los datos del pedido desde tu base de datos
$orderId = $_GET['id'] ?? null;
$orderDate = '2025-01-25'; // Este dato debería venir de la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Cancelar Pedido</title>
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
                        <a class="nav-link" href="login.php">
                            <i class="bi bi-person"></i> Mi Cuenta
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body text-center">
                            <h2 class="card-title mb-4">Cancelar Pedido</h2>
                            <p>¿Seguro que desea cancelar el pedido?</p>
                            <p>Número: <?php echo htmlspecialchars($orderId); ?></p>
                            <p>Fecha: <?php echo htmlspecialchars($orderDate); ?></p>
                            <div class="mt-4">
                                <a href="cancelarPedido.php?cancelar=si&id=<?php echo htmlspecialchars($orderId); ?>&zona=1" class="btn btn-custom me-2">Aceptar</a>
                                <a href="pedidosUser.php?zona=1" class="btn btn-custom">Cancelar</a>
                            </div>
                        </div>
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
</body>
</html>