<?php
session_start();
// Aquí deberías incluir la lógica para obtener los datos del pedido desde tu base de datos
// Por ahora, usaremos datos de ejemplo
$order = [
    'id' => 52,
    'date' => '2025-01-25',
    'total' => 19.95,
    'status' => 'Creado'
];
$customer = [
    'dni' => '74017237V',
    'name' => 'aaa aaa',
    'address' => 'asda',
    'city' => 'asdasd',
    'province' => 'asa',
    'phone' => '633322112',
    'email' => 'as@ej.com'
];
$orderItems = [
    [
        'line' => 1,
        'code' => 'AAA00030',
        'description' => 'PAÑUELO SATINADO ESTAMPADO',
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
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #9f8bc0;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar,
        .footer {
            background-color: #4e4363;
            color: rgb(80, 255, 203);
        }

        .btn-custom {
            background-color: #85b1c5;
            color: #4e4363;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: rgb(80, 255, 203);
            color: #4e4363;
        }

        .txt-custom {
            color: rgb(80, 255, 203);
        }

        .card {
            background-color: #4e4363;
            border: 1px solid rgb(80, 255, 203);
            color: rgb(80, 255, 203);
        }

        .table {
            color: rgb(80, 255, 203);
        }

        .table th, .table td {
            border-color: rgb(80, 255, 203);
        }
    </style>
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Ofertas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">
                            <i class="bi bi-person"></i> Mi Cuenta
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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

    <footer class="footer py-4 mt-auto">
        <div class="container text-center">
            <p>&copy; 2024 Amato - Todos los derechos reservados</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>