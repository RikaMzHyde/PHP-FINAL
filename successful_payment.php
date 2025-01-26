<?php
session_start();

// Verifica si los datos necesarios existen en la sesión
if (!isset($_SESSION['order_details'], $_SESSION['user_address'], $_SESSION['payment_info'])) {
    // Redirigir a una página de error o a la página de inicio si faltan datos
    header("Location: index.php");
    exit;
}

// Datos del pedido
$orderDetails = $_SESSION['order_details']; // Ejemplo: ['products' => 2, 'total' => 51.87, 'order_number' => 12345]

// Dirección del usuario
$userAddress = $_SESSION['user_address']; // Ejemplo: ['name' => 'Laura', 'address' => 'Calle Falsa 123', 'city' => 'Madrid', 'zip' => '28001']

// Información del pago
$paymentInfo = $_SESSION['payment_info']; // Ejemplo: ['method' => 'Tarjeta de crédito']
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Pedido Exitoso</title>
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
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Categorías</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Ofertas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Envío</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Devoluciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center mb-4">¡Pedido Realizado con Éxito!</h2>
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">¡Gracias por tu compra, <?php echo htmlspecialchars($userAddress['name']); ?>!</h4>
                                <p>Tu pedido ha sido procesado correctamente. Hemos enviado un correo electrónico de confirmación a tu dirección registrada.</p>
                                <hr>
                                <p class="mb-0">Número de pedido: <strong>#<?php echo htmlspecialchars($orderDetails['order_number']); ?></strong></p>
                            </div>
                            <p>Resumen de tu pedido:</p>
                            <ul>
                                <li>Productos: <?php echo htmlspecialchars($orderDetails['products']); ?></li>
                                <li>Total: <?php echo htmlspecialchars(number_format($orderDetails['total'], 2)); ?>€</li>
                                <li>Método de pago: <?php echo htmlspecialchars($paymentInfo['method']); ?></li>
                                <li>Enviado a: <?php echo htmlspecialchars($userAddress['address'] . ", " . $userAddress['city'] . " " . $userAddress['zip']); ?></li>
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