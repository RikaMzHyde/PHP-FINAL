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
                        <a class="nav-link" href="#">Contacto</a>
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