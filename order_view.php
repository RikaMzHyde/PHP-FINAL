<?php
session_start();
require("functions/security.php");
require_once 'apiBD.php';
include("user_class.php");

$dniCliente = $_SESSION['dni'];
$idPedido = $_GET['numero_pedido'];

$usuarioSesion = Usuario::obtenerUsuarioDNI($dniCliente);

//Verificamos si el usuario se ha obtenido correctamente
if ($usuarioSesion) {
    // Construimos el array $customer con los datos del usuario
    $customer = [
        'dni' => $dniCliente ?? '',
        'nombre' => $usuarioSesion->getNombre(),
        'direccion' => $usuarioSesion->getDireccion(),
        'localidad' => $usuarioSesion->getLocalidad(),
        'provincia' => $usuarioSesion->getProvincia(),
        'telefono' => $usuarioSesion->getTelefono(),
        'email' => $usuarioSesion->getEmail(),
    ];
}

$order = [
    'numero_pedido' => $_GET['numero_pedido'] ?? '',
    'fecha' => $_GET['fecha'] ?? '',
    'total' => $_GET['total'] ?? '',
    'estado' => $_GET['estado'] ?? '',
];

$orderItems = obtenerArticulosPedido($idPedido, $dniCliente);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Detalles del Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="stylesheetcart.css">
</head>
<body class="d-flex flex-column min-vh-100">    
    <?php require('navbar.php'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Resumen del Pedido</h2>
                    
                    <!-- <h5 class="mb-3">Resumen del Pedido</h5> -->
                    <?php include('order_articles.php') ?>

                    <div class="text-center mt-4">
                    <a href="order_cancel.php?id=<?= $order['numero_pedido'] ?>&date=<?= $order['fecha'] ?>&zona=1" class="btn btn-custom me-2">Cancelar Pedido</a>
                    <a href="order_history.php?zona=1" class="btn btn-custom">Volver a Pedidos</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>