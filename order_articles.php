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
            <td><?= $order['numero_pedido'] ?></td>
            <td><?= $order['fecha'] ?></td>
            <td><?= number_format($order['total'], 2); ?>€</td>
            <td><?= $order['estado'] ?></td>
        </tr>
    </tbody>
</table>

<h5 class="mb-3">Datos del Cliente</h5>
<table class="table table-bordered mb-4">
    <tr>
        <th>D.N.I.</th>
        <td><?= htmlspecialchars($dniCliente); ?></td>
        <th>Nombre</th>
        <td><?= htmlspecialchars($customer['nombre']); ?></td>
    </tr>
    <tr>
        <th>Dirección</th>
        <td><?= htmlspecialchars($customer['direccion']); ?></td>
        <th>Localidad</th>
        <td><?= htmlspecialchars($customer['localidad']); ?></td>
    </tr>
    <tr>
        <th>Provincia</th>
        <td><?= htmlspecialchars($customer['provincia']); ?></td>
        <th>Teléfono</th>
        <td><?= htmlspecialchars($customer['telefono']); ?></td>
    </tr>
    <tr>
        <th>E-mail</th>
        <td colspan="3"><?= htmlspecialchars($customer['email']); ?></td>
    </tr>
</table>

<h5 class="mb-3">Detalles del Pedido</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <!-- <th>Nº línea</th> -->
            <th>Artículo</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Precio Actual</th>
            <th>Precio Pagado</th>
            <th>Descuento</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orderItems as $item): ?>
            <tr>
                <!-- <td><?= $item['line'] ?></td> -->
                <td><?= $item['code'] ?></td>
                <td><?= $item['descripcion'] ?></td>
                <td><?= $item['cantidad'] ?></td>
                <td><?= number_format($item['precio_articulo'], 2) ?>€</td>
                <td><?= number_format($item['precio_pagado'], 2); ?>€</td>
                <td style="<?= number_format($item['discount'], 2) > 0 ? 'background-color: #5ffa88' : '' ?>"><?= number_format($item['discount'], 2) ?>%</td>
                <td><?= number_format($item['subtotal'], 2) ?>€</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>