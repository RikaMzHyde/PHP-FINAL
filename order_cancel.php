<?php
session_start();

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
    <link rel="stylesheet" href="stylesheetcart.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <?php require('components/navbar.php'); ?>

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

    <?php require('components/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>