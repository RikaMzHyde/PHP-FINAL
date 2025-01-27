<?php
session_start();

$order = [
    'id' => 52,
    'date' => '2025-01-25',
    'total' => 19.95,
    'status' => 'Creado'
];
$customer = [
    'dni' => '74017237V',
    'name' => 'Laura',
    'address' => 'C/ falsa 123',
    'city' => 'Alicante',
    'province' => 'Alicante',
    'phone' => '633322112',
    'email' => 'as@ej.com'
];
$orderItems = [
    [
        'line' => 1,
        'code' => 'AAA00030',
        'description' => 'Galletas Shin Chan Plátano',
        'quantity' => 1,
        'price' => 19.95,
        'discount' => 0,
        'subtotal' => 19.95
    ]
];
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
    <?php require('components/navbar.php'); ?>
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Detalles del Pedido</h2>
                    
                    <h5 class="mb-3">Resumen del Pedido</h5>
                    <table class="table table-bordered mb-4">
                        <thead>
                            <tr>
                                <th>Nº Pedido</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['date']; ?></td>
                                <td><?php echo number_format($order['total'], 2); ?>€</td>
                                <td><?php echo $order['status']; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="mb-3">Datos del Cliente</h5>
                    <table class="table table-bordered mb-4">
                        <tr>
                            <th>D.N.I.</th>
                            <td><?php echo $customer['dni']; ?></td>
                            <th>Nombre</th>
                            <td><?php echo $customer['name']; ?></td>
                        </tr>
                        <tr>
                            <th>Dirección</th>
                            <td><?php echo $customer['address']; ?></td>
                            <th>Localidad</th>
                            <td><?php echo $customer['city']; ?></td>
                        </tr>
                        <tr>
                            <th>Provincia</th>
                            <td><?php echo $customer['province']; ?></td>
                            <th>Teléfono</th>
                            <td><?php echo $customer['phone']; ?></td>
                        </tr>
                        <tr>
                            <th>E-mail</th>
                            <td colspan="3"><?php echo $customer['email']; ?></td>
                        </tr>
                    </table>

                    <h5 class="mb-3">Detalle del Pedido</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nº línea</th>
                                <th>Artículo</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Descuento</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td><?php echo $item['line']; ?></td>
                                <td><?php echo $item['code']; ?></td>
                                <td><?php echo $item['description']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo number_format($item['price'], 2); ?>€</td>
                                <td><?php echo $item['discount']; ?>%</td>
                                <td><?php echo number_format($item['subtotal'], 2); ?>€</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-center mt-4">
                        <a href="order_cancel.php?id=<?php echo $order['id']; ?>&zona=1" class="btn btn-custom me-2">Cancelar Pedido</a>
                        <a href="order_history.php?zona=1" class="btn btn-custom">Volver a Pedidos</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require('components/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>