<?php
session_start();
require("functions/security.php");
require_once("apiBD.php");
include("user_class.php");

//Verificamos si el id_pedido está en la sesión, sino, redirigimos al carrito con error
if (!isset($_SESSION['id_pedido'])) {
    header("Location: cart.php?error=error");
    exit();
}
//Vacíamos el carrito al finalizar un pago.
$_SESSION['cart'] = [];

//Obtenemos el ID del pedido desde la sesión si está disponible
$idPedido = $_SESSION['id_pedido'] ?? null;

//Marcar el pedido como completado en la sesión
$_SESSION['pedido_completado'] = true;

//Obtenemos los artículos del pedido con el idPedido y dni del cliente
$orderItems = obtenerArticulosPedido($idPedido, $_SESSION['dni']);

//Obtenemos la dirección del usuario desde la sesión
$userAddress = $_SESSION['user_address'];

//Obtenemos el dni del cliente
$dniCliente = $_SESSION['dni'] ?? null;
//Obtenemos los detalles del pedido usando idPedido y dniCliente
$order = obtenerDetallesPedido($idPedido, $dniCliente);

//Obtenemos la info del usuario desde la clase Usuario usando el dni y creamos array con los datos del cliente para usarlos luego
$usuarioSesion = Usuario::obtenerUsuarioDNI($dniCliente);
$customer = [
    'dni' => $_SESSION['dni'] ?? '',
    'nombre' => $usuarioSesion->getNombre(),
    'direccion' => $usuarioSesion->getDireccion(),
    'localidad' => $usuarioSesion->getLocalidad(),
    'provincia' => $usuarioSesion->getProvincia(),
    'telefono' => $usuarioSesion->getTelefono(),
    'email' => $usuarioSesion->getEmail(),
];
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
                            if (isset($idPedido)) {
                                ?>
                                <!--Mensaje de éxito-->
                                <h2 class="card-title text-center mb-4">¡Pedido Realizado con Éxito!</h2>
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">¡Gracias por tu compra,
                                        <?php echo htmlspecialchars($userAddress['nombre']); ?>!</h4>
                                    <p>Tu pedido ha sido procesado correctamente. Hemos enviado un correo electrónico de
                                        confirmación a tu dirección registrada.</p>
                                    <hr>
                                    <p class="mb-0">Número de pedido:
                                        <strong>#<?php echo htmlspecialchars($idPedido); ?></strong></p>
                                </div>
                                <p>Resumen de tu pedido:</p>
                                <!--Incluir la vista de los artículos del pedido-->
                                <?php require('order_articles.php') ?>
                                <div class="text-center mt-4">
                                    <!-- Botones de volver y ver mis pedidos -->
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