<?php
header('Content-Type: application/json'); // Respuesta en JSON
session_start(); // Inicia la sesión
require_once('apiBD.php');

// Inicializar el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Inicializa como un array vacío
}

// Obtener el cuerpo de la solicitud
$requestPayload = json_decode(file_get_contents('php://input'), true);

// Rutas de la API
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $cartItems = [];
    $codes = array_column($_SESSION['cart'], 'code');
    $quantityMap = array_column($_SESSION['cart'], 'quantity', 'code');
    $placeholders = str_repeat('?,', count($codes) - 1) . '?';
    $cartItems = getCartItems($codes, $quantityMap, $placeholders);
    echo json_encode(value: $cartItems ?? ['items' => []]);
    exit;
}
/*
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($requestPayload['action'])) {
    if ($requestPayload['action'] === 'updateQuantity' && isset($requestPayload['name'], $requestPayload['change'])) {
        $name = $requestPayload['name'];
        $change = (int)$requestPayload['change'];

        // Obtener el carrito de la sesión
        $cart = $_SESSION['cart'] ?? ['items' => []];

        foreach ($cart['items'] as &$item) {
            if ($item['name'] === $name) {
                $item['quantity'] = max(1, $item['quantity'] + $change); // No permitir menos de 1
                break;
            }
        }

        // Actualizar el carrito en la sesión
        $_SESSION['cart'] = $cart;

        echo json_encode([
            'success' => true,
            'message' => 'Cantidad actualizada correctamente.',
            'cart' => $cart
        ]);
        exit;
    }
}*/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($requestPayload['action'])) {
    switch ($requestPayload['action']) {
        case 'add':
            if (isset($requestPayload['code'])) {
                $code = $requestPayload['code'];

                // Asegurar que $_SESSION['cart'] es un array
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                $itemFound = false;

                // Buscar si el producto ya existe en el carrito
                foreach ($_SESSION['cart'] as &$item) {
                    if ($item['code'] === $code) {
                        $item['quantity'] += 1; // Incrementar la cantidad
                        $itemFound = true;
                        break;
                    }
                }

                // Si el producto no está en el carrito, añadirlo
                if (!$itemFound) {
                    $_SESSION['cart'][] = [
                        'code' => $code,
                        'quantity' => 1
                    ];
                }

                echo json_encode( ['success' => true, 'message' => 'Cantidad incrementada', 'cart' => $_SESSION['cart']]);
            } else {
                echo json_encode(['error' => 'Faltan parámetros para agregar']);
            }
            break;

        case 'remove':
            if (isset($requestPayload['code'])) {
                $code = $requestPayload['code'];

                // Asegurar que $_SESSION['cart'] es un array
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                foreach ($_SESSION['cart'] as $index => &$item) {
                    if ($item['code'] === $code) {
                        $item['quantity'] -= 1; // Decrementar la cantidad
                        if ($item['quantity'] <= 0) {
                            unset($_SESSION['cart'][$index]); // Eliminar si la cantidad es 0
                        }
                        break;
                    }
                }

                // Reindexar el array para evitar huecos en los índices
                $_SESSION['cart'] = array_values($_SESSION['cart']);

                echo json_encode(['success' => true, 'message' => 'Cantidad decrementada', 'cart' => $_SESSION['cart']]);
            } else {
                echo json_encode(['error' => 'Faltan parámetros para eliminar']);
            }
            break;

        case 'clear':
            if (isset($requestPayload['code'])) {
                $code = $requestPayload['code'];

                // Asegurar que $_SESSION['cart'] es un array
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = [];
                }

                foreach ($_SESSION['cart'] as $index => &$item) {
                    if ($item['code'] === $code) {
                        unset($_SESSION['cart'][$index]); 
                        break;
                    }
                }

                // Reindexar el array para evitar huecos en los índices
                $_SESSION['cart'] = array_values($_SESSION['cart']);

                echo json_encode(['success' => true, 'message' => 'Cantidad decrementada', 'cart' => $_SESSION['cart']]);
            } else {
                echo json_encode(['error' => 'Faltan parámetros para eliminar']);
            }
            break;
        default:
            echo json_encode(['error' => 'Acción no válida']);
            break;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'view') {
    // Ver el carrito
    echo json_encode(['cart' => $_SESSION['cart']]);
} else {
    echo json_encode(['error' => 'Método o acción no soportados']);
}
?>