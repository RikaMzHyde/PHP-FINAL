<?php
session_start();
// Aquí deberías incluir la lógica para verificar si el usuario está autenticado
// y obtener los datos de los pedidos desde tu base de datos
// Por ahora, usaremos datos de ejemplo
$orders = [
    ['id' => 50, 'date' => '2025-01-25', 'total' => 13.56, 'status' => 'Creado'],
    ['id' => 49, 'date' => '2025-01-25', 'total' => 119.70, 'status' => 'Creado'],
    ['id' => 47, 'date' => '2025-01-22', 'total' => 51.86, 'status' => 'Creado'],
];
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
    <?php require('components/navbar.php'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">
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
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                                        <td><?php echo htmlspecialchars($order['date']); ?></td>
                                        <td><?php echo number_format($order['total'], 2); ?>€</td>
                                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                                        <td>
                                            <a href="order_view.php?id=<?php echo $order['id']; ?>" class="btn btn-custom btn-sm">Ver</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require('components/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>