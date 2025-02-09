<?php
require_once("connect.php");

//función para obtener artículos de la BD con los filtros y paginación
function getArticulos($categoria, $buscar, $productos_por_pagina, $pagina_actual, $offset): array
{
    try {
        //Conexión BD
        $conn = conectar_db();
        if (!$conn) {
            die("Error al conectar a la base de datos");
        }

        //Consulta base
        $sql = "SELECT * FROM articulos WHERE 1";

        //Filtrar por categoría, si se seleccionó una
        if ($categoria) {
            $sql .= " AND categoria = :categoria";
        }

        //Filtrar por nombre de producto, si hay un término de búsqueda
        if ($buscar) {
            $sql .= " AND nombre LIKE :buscar";
        }

        //Agregar límite y offset para la paginación
        $sql .= " LIMIT :offset, :limite";

        //Preparar la consulta
        $stmt = $conn->prepare($sql);

        //Vincular los parámetros de la consulta
        if ($categoria) {
            $stmt->bindParam(':categoria', $categoria, PDO::PARAM_STR);
        }
        if ($buscar) {
            $buscar = "%" . $buscar . "%"; // Utilizamos % para hacer la búsqueda parcial
            $stmt->bindParam(':buscar', $buscar, PDO::PARAM_STR);
        }
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limite', $productos_por_pagina, PDO::PARAM_INT);

        //Ejecutar la consulta
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

//Obtener número total de productos que coinciden con los filtros
function getTotalProductos($categoria, $buscar)
{
    //Conexión BD
    $conn = conectar_db();
    $sql_total = "SELECT COUNT(*) FROM articulos WHERE 1";
    //Aplicar filtros si hay
    if ($categoria) {
        $sql_total .= " AND categoria = :categoria";
    }
    if ($buscar) {
        $sql_total .= " AND nombre LIKE :buscar";
    }

    $stmt_total = $conn->prepare($sql_total);
    if ($categoria) {
        $stmt_total->bindParam(':categoria', $categoria, PDO::PARAM_STR);
    }
    if ($buscar) {
        $buscar = "%" . $buscar . "%"; //Utilizamos % para hacer la búsqueda parcial
        $stmt_total->bindParam(':buscar', $buscar, PDO::PARAM_STR);
    }
    $stmt_total->execute();
    return $stmt_total->fetchColumn();
}


//Insertar un nuevo pedido en la tabla "pedidos"
function insertarPedido($conn, $fecha, $total, $estado, $dni)
{
    $sql = "INSERT INTO pedidos (fecha, total, estado, dni) VALUES (:fecha, :total, :estado, :dni)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':dni', $dni);

    $stmt->execute();

    //Devuelve el ID del pedido insertado
    return $conn->lastInsertId();
}

//Insertar un nuevo detalle del pedido en la tabla "detalles_pedido"
function insertarDetallePedido($conn, $idPedido, $codigoArticulo, $precio, $cantidad)
{
    try {

        $sql = "INSERT INTO detalles_pedido (id_pedido, codigo_articulo, precio, cantidad) VALUES (:id_pedido, :codigo_articulo, :precio, :cantidad)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id_pedido', $idPedido);
        $stmt->bindParam(':codigo_articulo', $codigoArticulo);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->execute();

        //Verificar si la inserción fue exitosa
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        throw new Exception("Error al insertar detalle del pedido: " . $e->getMessage());
    }
}

//Recoger los datos de los pedidos en "mis pedidos" con la paginación
function obtenerPedidos($dniCliente, $porPagina = 5, $pagina = 1)
{
    try {
        $conn = conectar_db();
        $offset = ($pagina - 1) * $porPagina;

        $sql = "SELECT numero_pedido, fecha, total, estado, dni 
                FROM pedidos 
                WHERE dni = :dni 
                ORDER BY fecha DESC 
                LIMIT :limit OFFSET :offset";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':dni', $dniCliente, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return [
            'pedidos' => $stmt->fetchAll(PDO::FETCH_ASSOC),
            'total' => obtenerTotalPedidos($dniCliente)
        ];
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return ['pedidos' => [], 'total' => 0];
    }
}

//Obtener el número total de pedidos que ha realizado el cliente
function obtenerTotalPedidos($dniCliente)
{
    try {
        $conn = conectar_db();
        $sql = "SELECT COUNT(*) as total FROM pedidos WHERE dni = :dni";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':dni', $dniCliente, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        return 0;
    }
}

//Obtener detalles de un pedido concreto
function obtenerDetallesPedido($idPedido, $dniCliente)
{
    try {
        $conn = conectar_db();

        $sql = "SELECT numero_pedido, fecha, total, estado, dni FROM pedidos WHERE numero_pedido = :idPedido AND dni = :dni ORDER BY fecha DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);
        $stmt->bindParam(':dni', $dniCliente, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}

//Obtener artículos de un pedido concreto
function obtenerArticulosPedido($idPedido, $dni)
{
    try {
        $conn = conectar_db();
        //Consulta con JOIN para obtener detalles completos de los artículos
        $sql = "SELECT 
                    dp.id_detalle AS line, 
                    a.codigo AS code, 
                    a.nombre as name,
                    a.descripcion, 
                    dp.cantidad, 
                    dp.precio AS precio_pagado, 
                    a.precio AS precio_articulo,
                    (dp.precio * dp.cantidad) AS subtotal,
                    ((a.precio - dp.precio) / a.precio * 100) AS discount
                FROM detalles_pedido dp
                JOIN pedidos p ON dp.id_pedido = p.Numero_pedido
                JOIN articulos a ON dp.codigo_articulo = a.codigo
                WHERE p.Numero_pedido = :idPedido AND p.dni = :dni";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);
        $stmt->bindParam(':dni', $dni, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

//Cambia el estado de un pedido de "Pendiente" a "Cancelado"
function cancelarPedido($idPedido)
{
    try {
        $conn = conectar_db();

        $sql = "UPDATE pedidos SET estado = 'Cancelado' WHERE numero_pedido = :idPedido AND estado = 'Pendiente'";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idPedido', $idPedido, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

//Obtiene artículos del carrito
function getCartItems($codes, $quantityMap, $placeholders)
{
    try {
        $conn = conectar_db();

        $stmt = $conn->prepare(
            "SELECT codigo as code, nombre as name, precio as price 
            FROM articulos 
            WHERE codigo IN ($placeholders)"
        );

        $stmt->execute($codes);
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Combina cada artículo con su cantidad desde el carrito usando array_map
        // Si no existe cantidad para el código, se establece 0 por defecto
        return array_map(function ($article) use ($quantityMap) {
            return $article + [
                'quantity' => $quantityMap[$article['code']] ?? 0
            ];
        }, $articles);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}
