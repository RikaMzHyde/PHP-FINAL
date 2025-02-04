<?php
session_start();
require("functions/security.php");

// Verifica si los datos necesarios existen en la sesión
if (!isset($_SESSION['order_details'], $_SESSION['user_address'], $_SESSION['payment_info'], $_SESSION['nombre'])) {
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
$orderDetails = $_SESSION['cart'];
// Dirección del usuario
$userAddress = $_SESSION['user_address'];
var_dump($userAddress);


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
    <?php require('navbar.php'); ?>
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
                            
                                 $_SESSION['pedido_completado'] = true;

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

    <?php require('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>