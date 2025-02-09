<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar con Stripe</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Producto de Ejemplo</h1>
    <button id="checkout-button">Pagar</button>

    <script>
        const stripe = Stripe('api_publica'); // Tu clave pública de Stripe

        document.getElementById('checkout-button').addEventListener('click', () => {
            fetch('/stripe/payment.php', { method: 'POST' }) // Ruta al archivo PHP
                .then(response => response.json())
                .then(session => {
                    return stripe.redirectToCheckout({ sessionId: session.id });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    </script>
</body>
</html>


