<?php
session_start();
require("functions/security.php");
require_once 'apiBD.php'; // Incluir el archivo de la base de datos
// echo '<pre>';
// echo 'Debug variables';
// var_dump($_SESSION);
// var_dump($_POST);
// echo '</pre>';
// Verificar si se ha iniciado un pago
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart']) && !empty($_SESSION['cart']) && isset($_SESSION['dni']) && !empty($_SESSION['dni'])) {
    $dni = $_SESSION['dni']; // DNI del usuario desde la sesión
    $fecha = date('Y-m-d H:i:s'); // Fecha actual
    $total = 0;
    //$orderDetails = $_SESSION['cart']; // Ejemplo: ['products' => 2, 'total' => 51.87, 'order_number' => 12345]
    $codes = array_column($_SESSION['cart'], 'code');
    $quantityMap = array_column($_SESSION['cart'], 'quantity', 'code');
    $placeholders = str_repeat('?,', count($codes) - 1) . '?';
    $orderDetails = getCartItems($codes, $quantityMap, $placeholders);
    
    foreach ($orderDetails as $product) {
        $total += $product['price'] * $product['quantity'];
    }
    // Insertar el pedido en la base de datos
    $idPedido = insertarPedido($fecha, $total, 'Pendiente', $dni);

    foreach ($orderDetails as $product) {
        insertarDetallePedido(
            $idPedido,
            $product['code'],
            $product['price'],
            $product['quantity']
        );
    }


    // Guardar el ID del pedido en la sesión para usarlo en successful_payment
    $_SESSION['id_pedido'] = $idPedido;
    $_SESSION['pago'] = $_POST['pago'];

    // Redirigir al archivo successful_payment
    header('Location: successful_payment.php');
    exit();
}
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
    <?php require('navbar.php') ?>
    <main class="py-5">
        <div class="container">
            <div class="row">
                <div>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center mb-4">Seleccione un Método de Pago</h4>
                            <form name="tramitarPago" method="post" action="payment.php">
                                <div class="row justify-content-center">
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pago" id="visa" value="Visa" required>
                                            <label class="form-check-label" for="visa">
                                                <img src="imgs\visa.png" alt="Visa" class="img-fluid">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pago" id="mastercard" value="MasterCard" required>
                                            <label class="form-check-label" for="mastercard">
                                                <img src="imgs\mc.png" alt="Mastercard" class="img-fluid">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pago" id="american" value="AmericanExpress" required>
                                            <label class="form-check-label" for="american">
                                                <img src="imgs\ae.png" alt="American Express" class="img-fluid">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="pago" id="paypal" value="Paypal" required>
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

    <?php require('footer.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

