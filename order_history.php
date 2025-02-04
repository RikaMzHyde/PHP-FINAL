<?php
session_start();
require("functions/security.php");
require_once 'apiBD.php';

//vaciar el carrito al tener todo hecho
if (isset($_SESSION['pedido_completado']) && $_SESSION['pedido_completado'] === true) {
    unset($_SESSION['cart']); // Vacía el carrito
    unset($_SESSION['pedido_completado']); // Elimina la marca de pedido completado
}


$dniCliente = $_SESSION['dni'];
// echo $dniCliente;
$pedidos = obtenerPedidos($dniCliente);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amato - Historial de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="stylesheetcart.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <?php require('navbar.php'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">
            <?php if (isset($_SESSION['mensaje'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['mensaje'];
                    unset($_SESSION['mensaje']); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Historial de Pedidos</h2>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Número</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pedidos)): ?>
                                    <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($pedido['numero_pedido']); ?></td>
                                            <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                                            <td><?php echo number_format($pedido['total'], 2); ?>€</td>
                                            <td><?php echo htmlspecialchars($pedido['estado']); ?></td>
                                            <td>
                                                <a href="order_view.php?numero_pedido=<?= urlencode($pedido['numero_pedido']); ?>&fecha=<?= urlencode($pedido['fecha']); ?>&total=<?= urlencode($pedido['total']); ?>&estado=<?= urlencode($pedido['estado']); ?>"
                                                    class="btn btn-custom btn-sm">Ver</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No hay pedidos disponibles.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>