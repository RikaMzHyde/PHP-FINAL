<?php
//Require para interacturar con la BD
require_once 'apiBD.php';

//Funcion para cargar los items del carrito de la sesión
function loadCartItems(){
    //Inicializa vacío
    $cartItems = [];

    //Obtiene los códigos de los productos del carrito
    $codes = array_column($_SESSION['cart'], 'code');
    //Verifica si el carrito tiene productos (mediante los códigos)
    if(count($codes) > 0){
        //Crea un map de cantidades asociadas a cada código de producto
        $quantityMap = array_column($_SESSION['cart'], 'quantity', 'code');
        //Crea string de placeholders para la consulta SQL siendo el número de placeholders igual a la cantidad de productos
        $placeholders = str_repeat('?,', count($codes) - 1) . '?';
        //Llama a "getCartItems" para obtener los detalles de los productos del carrito desde la BD
        $cartItems = getCartItems($codes, $quantityMap, $placeholders);
    }
    //Si no se encuentran items, devuelve array con clave "items" vacía
    return $cartItems ?? ['items' => []];
}

//Función para verificar que el carrito tenga productos
function checkCartItems(){
    //Llama a "loadCartItems" para cargar los items del carrito
    $cartItems = loadCartItems();
    //Si no hay, redirige a la página del carrito con error
    if(count($cartItems ) == 0){
        header("Location: cart.php?error=carrito");
        exit;
    }
}

?>