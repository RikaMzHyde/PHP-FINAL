<?php
header('Content-Type: application/json'); // Respuesta en JSON
session_start(); // Inicia la sesión

// Inicializar el carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Inicializa como un array vacío
}

// Obtener el cuerpo de la solicitud
$requestPayload = json_decode(file_get_contents('php://input'), true);

// Rutas de la API
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($_SESSION['cart'] ?? ['items' => []]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($requestPayload['action'])) {
    switch ($requestPayload['action']) {
        case 'add':
            // Crear producto desde el cuerpo de la solicitud
            $product = [
                'name' => $requestPayload['name'],
                'price' => $requestPayload['price'],
                'quantity' => 1
            ];

            // Asegurarte de que $_SESSION['cart'] es un array
            if (!is_array($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            // Añadir el producto al carrito
            $_SESSION['cart'][] = $product;

            echo json_encode(['message' => 'Producto añadido al carrito', 'cart' => $_SESSION['cart']]);
            break;

        case 'clear':
            // Limpiar el carrito
            $_SESSION['cart'] = [];
            echo json_encode(['message' => 'Carrito limpiado', 'cart' => $_SESSION['cart']]);
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