<?php
require_once 'apiBD.php';
function loadCartItems(){
    $cartItems = [];
    $codes = array_column($_SESSION['cart'], 'code');
    if(count($codes) > 0){
        $quantityMap = array_column($_SESSION['cart'], 'quantity', 'code');
        $placeholders = str_repeat('?,', count($codes) - 1) . '?';
        $cartItems = getCartItems($codes, $quantityMap, $placeholders);
    }
    return $cartItems ?? ['items' => []];
}

function checkCartItems(){
    $cartItems = loadCartItems();
    if(count($cartItems ) == 0){
        header("Location: cart.php?error=carrito");
        exit;
    }
}

?>