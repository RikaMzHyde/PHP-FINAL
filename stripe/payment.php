<?php
require 'vendor/autoload.php'; // Asegúrate de que esta ruta sea correcta

// Configura tu clave secreta de Stripe
\Stripe\Stripe::setApiKey('api_server');

header('Content-Type: application/json');

try {
    $YOUR_DOMAIN = 'http://localhost/stripe'; // Asegúrate de que este dominio sea correcto

    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => 'Producto de Ejemplo',
                ],
                'unit_amount' => 2000,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/success.html',
        'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
    ]);

    echo json_encode(['id' => $checkout_session->id]);
} catch (Error $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
