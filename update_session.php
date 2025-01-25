<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cartData = json_decode(file_get_contents('php://input'), true);

    if (isset($cartData['items'])) {
        $_SESSION['cart'] = json_encode($cartData);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid cart data']);
    }
}
