<?php
session_start();
require_once("functions/security.php");
require_once('cart_functions.php');
checkCartItems(); //Verificar si hay articulos en el carrito
require_once 'apiBD.php'; //Incluir el archivo de la base de datos

//Cargar librería de Stripe
require __DIR__ . '/stripe/vendor/autoload.php';
//Secret key de Stripe
$stripe_secret_key = 'sk_test_51Qq1R8Co4BLdblxCpaCrrnfopZKymG72SwQvkieXYBiOmQ8cB7AuqpMOScqstC9iyCTY7pid0ioUznOlr7PCnsa900vg7hfExh';
//Config de clave secreta para autenticación
\Stripe\Stripe::setApiKey($stripe_secret_key);

//Determinar el protocolo de la URL para generar la URL base
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$base_url = $protocol . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/";

//Obtener los detalles del carrito desde la sesión
$codes = array_column($_SESSION['cart'], 'code'); //Extraer códigos de productos
$quantityMap = array_column($_SESSION['cart'], 'quantity', 'code'); //Asociar cantidades a cada producto por codigo
$placeholders = str_repeat('?,', count($codes) - 1) . '?'; //Crear placeholders para la consulta SQL
$orderDetails = getCartItems($codes, $quantityMap, $placeholders); //Obtener detalles de los productos en el carrito de la BD

//Preparar datos de los productos para Stripe en un array
$items = [];
foreach ($orderDetails as $product) {
    $itemInfo = [
        "quantity" => $product['quantity'], //Cantidad de cada producto
        "price_data" => [
            "currency" => "eur",
            "unit_amount" => $product['price']*100, //Precio en centavos (Stripe lo pide así)
            "product_data" => [
                "name" => $product['name'], //Nombre prod
            ]
        ]
    ];

    $items[] = $itemInfo; //Agregar al array correctamente
}

//Crear sesión de pago de Stripe
$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => $base_url . "payment.php", //Redirección exitosa
    "cancel_url" => $base_url . "user_address.php", //Redirección si se cancela el pago
    "locale" => "es",
    "line_items" => $items //Productos que se están comprando
]);

//Redirigir a la URL de Stripe para completar el pago
http_response_code(303); //Código respuesta HTTP para redirigir
//Redirigir al usu a la URL de Stripe para continuar con el pago
header("Location: " . $checkout_session->url);
?>