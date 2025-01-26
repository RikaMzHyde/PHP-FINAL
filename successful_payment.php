<?php
session_start();

// Verifica si los datos necesarios existen en la sesión
if (!isset($_SESSION['order_details'], $_SESSION['user_address'], $_SESSION['payment_info'])) {
    // Redirigir a una página de error o a la página de inicio si faltan datos
//     echo '<pre>';
//     echo 'Debug variables';
//  var_dump($_SESSION);
// // var_dump($_POST);
// echo '</pre>';
//     /*header("Location: index.php");
//     exit;*/
}

// Datos del pedido
$orderDetails = $_SESSION['cart']; // Ejemplo: ['products' => 2, 'total' => 51.87, 'order_number' => 12345]

// Dirección del usuario
$userAddress = $_SESSION['user_address']; // Ejemplo: ['name' => 'Laura', 'address' => 'Calle Falsa 123', 'city' => 'Madrid', 'zip' => '28001']

// Información del pago
$paymentInfo = '';
// Guardar el método de pago en la sesión si el formulario fue enviado
$paymentInfo = $_SESSION['pago']
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
                    <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
                    <a class="nav-link" href="login.php">
                        <i class="bi bi-person"></i> Mi Cuenta
                    </a>
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
                            <?php 
                            
                                // Verificar si el pago fue exitoso y el ID del pedido está disponible
                                if (isset($_SESSION['id_pedido'])) {
                                    $idPedido = $_SESSION['id_pedido'];
                            ?>
                    <h2 class="card-title text-center mb-4">¡Pedido Realizado con Éxito!</h2>
                            <div class="alert alert-success" role="alert">
                                <h4 class="alert-heading">¡Gracias por tu compra, <?php echo htmlspecialchars($userAddress['nombre']); ?>!</h4>
                                <p>Tu pedido ha sido procesado correctamente. Hemos enviado un correo electrónico de confirmación a tu dirección registrada.</p>
                                <hr>
                                <p class="mb-0">Número de pedido: <strong>#<?php echo htmlspecialchars($idPedido); ?></strong></p>
                            </div>
                            <p>Resumen de tu pedido:</p>
                            <ul>
                                <li><strong>Productos:</strong>
                                <?php 
                                $total = 0;
                                foreach ($orderDetails as $product) {
                                    $productTotal = $product['price'] * $product['quantity'];
                                    $total += $productTotal;
                                    echo "<li>" . htmlspecialchars($product['name']) . 
                                        " - Cantidad: " . htmlspecialchars($product['quantity']) . 
                                        " - Precio Unitario: " . number_format($product['price'], 2) . "€";
                                }
                                ?>
                                <li><strong>Total del pedido:</strong> <?php echo number_format($total, 2); ?>€
                                <li><strong>Método de pago:</strong> <?php echo htmlspecialchars($paymentInfo); ?></li>
                                <li><strong>Enviado a:</strong> <?php echo htmlspecialchars($userAddress['direccion'] . ", " . $userAddress['localidad'] . " " . $userAddress['provincia']); ?></li>
                            </ul>
                            <div class="text-center mt-4">
                                <a href="index.php" class="btn btn-custom me-2">Volver a la tienda</a>
                                <a href="order_history.php" class="btn btn-custom">Ver mis pedidos</a>
                            </div>
                            <?php
                            } else {
                                echo "<h1>Error</h1>";
                                echo "<p>No se encontró información del pedido. Por favor, inténtalo de nuevo.</p>";
                            }
                            ?>
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