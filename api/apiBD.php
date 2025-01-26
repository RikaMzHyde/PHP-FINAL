<?php
// Archivo: apiBD.php
include("connect.php");

// Insertar un nuevo pedido en la tabla "pedidos"
function insertarPedido($fecha, $total, $estado, $dni) {
    $conn = conectar_db();

    $sql = "INSERT INTO pedidos (fecha, total, estado, dni) VALUES (:fecha, :total, :estado, :dni)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':dni', $dni);

    $stmt->execute();

    // Retorna el ID del pedido insertado
    return $conn->lastInsertId();
}

// Insertar un nuevo detalle del pedido en la tabla "detalles_pedido"
function insertarDetallePedido($idPedido, $codigoArticulo, $precio, $cantidad) {
    try {
        $conn = conectar_db();

        $sql = "INSERT INTO detalles_pedido (id_pedido, codigo_articulo, precio, cantidad) VALUES (:id_pedido, :codigo_articulo, :precio, :cantidad)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_pedido', $idPedido);
        $stmt->bindParam(':codigo_articulo', $codigoArticulo);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);

        $stmt->execute();

        // Verificar si la inserción fue exitosa
        if ($stmt->rowCount() > 0) {
            return "Detalle de pedido insertado correctamente.";
        } else {
            echo "";
        }
    } catch (PDOException $e) {
        // Captura cualquier error y muestra el mensaje
        echo "Error: " . $e->getMessage();
    }
}

// Ejemplo de uso
// $idPedido = insertarPedido('2025-01-26', 150.75, 'Pendiente', '12345678A');
// insertarDetallePedido($idPedido, 'ART123', 50.25, 3);

?>