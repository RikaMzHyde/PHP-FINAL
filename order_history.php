<?php
session_start();
require("functions/security.php");
require_once 'apiBD.php';

//vaciar el carrito al tener todo hecho
if (isset($_SESSION['pedido_completado']) && $_SESSION['pedido_completado'] === true) {
    unset($_SESSION['cart']); //Vacía el carrito
    unset($_SESSION['pedido_completado']); //Elimina la marca de pedido completado
}

//Cogemos el dni del cliente de la sesión
$dniCliente = $_SESSION['dni'];

//Configuración de paginación
$porPagina = 10; //Cantidad de pedidos por página
$pagina = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1; //Obtener página actual

$dniCliente = $_SESSION['dni'];
//obtenemos los pedidos del cliente con paginación
$resultado = obtenerPedidos($dniCliente, $porPagina, $pagina);
$pedidos = $resultado['pedidos'];
$totalPedidos = $resultado['total'];
$totalPaginas = ceil($totalPedidos / $porPagina);
//Si la pagina solicitada excede el total de páginas te redirige a la última válida
if ($pagina > $totalPaginas && $totalPaginas > 0) {
    header("Location: ?page=" . $totalPaginas);
    exit();
}
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
            <!-- Muestra mensajes de éxito si hay -->
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
                        <!-- Tabla de pedidos -->
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
                                <!-- Listado de pedidos -->
                                <?php if (!empty($pedidos)): ?>
                                    <?php foreach ($pedidos as $pedido): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($pedido['numero_pedido']); ?></td>
                                            <td><?php echo htmlspecialchars($pedido['fecha']); ?></td>
                                            <td><?php echo number_format($pedido['total'], 2); ?>€</td>
                                            <td><?php echo htmlspecialchars($pedido['estado']); ?></td>
                                            <td>
                                                <!-- Ver más detalles del pedido -->
                                                <a href="order_view.php?numero_pedido=<?= urlencode($pedido['numero_pedido']); ?>&fecha=<?= urlencode($pedido['fecha']); ?>&total=<?= urlencode($pedido['total']); ?>&estado=<?= urlencode($pedido['estado']); ?>"
                                                    class="btn btn-custom btn-sm">Ver</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <!-- Si no hay pedidos muestra el mensaje -->
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No hay pedidos disponibles.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <!-- Páginación -->
                        <nav aria-label="Navegación de páginas">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
                                    <a class="btn btn-custom me-2" href="?page=<?= $pagina - 1 ?>">Anterior</a>
                                </li>

                                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                    <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                                        <a class="btn btn-custom me-2" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>

                                <li class="page-item <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">
                                    <a class="btn btn-custom ms-2" href="?page=<?= $pagina + 1 ?>">Siguiente</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php require('footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>